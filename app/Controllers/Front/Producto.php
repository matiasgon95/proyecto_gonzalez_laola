<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class Producto extends BaseController
{
    protected $productoModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $productos = $this->productoModel->getProductosConCategoriaActivos();

        $categoriasArray = $this->categoriaModel->where('activo', 1)->findAll();
        $categorias = array_column($categoriasArray, 'descripcion');

        return view('front/productos/index', [
            'productos' => $productos,
            'categorias' => $categorias
        ]);
    }

    public function detalle($id)
    {
        if (!is_numeric($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $producto = $this->productoModel->select('productos.*, categorias.descripcion as categoria')
                                        ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                                        ->where('productos.id', $id)
                                        ->where('productos.eliminado', 0)
                                        ->where('productos.stock >', 0)
                                        ->first();

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('front/productos/detalle', ['producto' => $producto]);
    }

    public function categoria($categoria)
    {
        $categoriaObj = $this->categoriaModel->where('descripcion', $categoria)->first();

        if (!$categoriaObj) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $productos = $this->productoModel
                         ->select('productos.*, categorias.descripcion as categoria')
                         ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                         ->where('productos.categoria_id', $categoriaObj['id'])
                         ->where('productos.eliminado', 0)
                         ->where('productos.stock >', 0)
                         ->findAll();

        $categoriasArray = $this->categoriaModel->where('activo', 1)->findAll();
        $categorias = array_column($categoriasArray, 'descripcion');

        return view('front/productos/index', [
            'productos' => $productos,
            'categorias' => $categorias
        ]);
    }

    public function buscar()
    {
        $termino = $this->request->getGet('q');

        if (empty($termino)) {
            return redirect()->to(base_url('productos'));
        }

        $productos = $this->productoModel->buscarProductosAvanzado($termino);

        $categoriasArray = $this->categoriaModel->where('activo', 1)->findAll();
        $categorias = array_column($categoriasArray, 'descripcion');

        return view('front/productos/index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'termino_busqueda' => $termino
        ]);
    }

    public function sugerencias()
    {
        $termino = $this->request->getGet('q');

        if (empty($termino)) {
            $productos = $this->productoModel->getProductosConCategoriaActivos();
        } else {
            $productos = $this->productoModel->buscarConSinonimos($termino);
        }

        return $this->response->setJSON($productos);
    }

}
