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

    // Mostrar la lista de productos
    public function index()
    {
        // Traemos todos los productos activos con su categoría
        $productos = $this->productoModel->getProductosConCategoria();

        // Traemos todas las categorías activas para la barra lateral
        $categoriasArray = $this->categoriaModel->where('activo', 1)->findAll();
        $categorias = array_column($categoriasArray, 'descripcion');

        return view('front/productos/index', [
            'productos' => $productos,
            'categorias' => $categorias
        ]);
    }

    // Ver detalles de un producto
    public function detalle($id)
    {
        $producto = $this->productoModel->select('productos.*, categorias.descripcion as categoria')
                                        ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                                        ->where('productos.id', $id)
                                        ->where('productos.eliminado', 0)
                                        ->first();

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('front/productos/detalle', ['producto' => $producto]);
    }

    // Filtrar productos por categoría
    public function categoria($categoria)
    {
        $productos = $this->productoModel
                         ->select('productos.*, categorias.descripcion as categoria')
                         ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                         ->where('categorias.descripcion', $categoria)
                         ->where('productos.eliminado', 0)
                         ->findAll();

        $categoriasArray = $this->categoriaModel->where('activo', 1)->findAll();
        $categorias = array_column($categoriasArray, 'descripcion');

        return view('front/productos/index', [
            'productos' => $productos,
            'categorias' => $categorias
        ]);
    }
}
