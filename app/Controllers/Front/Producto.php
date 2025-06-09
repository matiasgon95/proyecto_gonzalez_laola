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

    // Mostrar la lista de productos activos con stock > 0
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

    // Ver detalles de un producto (si está activo y stock > 0)
    public function detalle($id)
    {
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

    // Filtrar productos activos con stock > 0 por categoría
    public function categoria($categoria)
    {
        $productos = $this->productoModel
                         ->select('productos.*, categorias.descripcion as categoria')
                         ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                         ->where('categorias.descripcion', $categoria)
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
    
    // Buscar productos por término de búsqueda
    public function buscar()
    {
        $termino = $this->request->getGet('q');
        
        if (empty($termino)) {
            return redirect()->to(base_url('productos'));
        }
        
        $productos = $this->productoModel
                         ->select('productos.*, categorias.descripcion as categoria')
                         ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                         ->where('productos.eliminado', 0)
                         ->where('productos.stock >', 0)
                         ->groupStart()
                             ->like('productos.nombre', $termino)
                             ->orLike('productos.descripcion', $termino)
                         ->groupEnd()
                         ->findAll();

        $categoriasArray = $this->categoriaModel->where('activo', 1)->findAll();
        $categorias = array_column($categoriasArray, 'descripcion');

        return view('front/productos/index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'termino_busqueda' => $termino
        ]);
    }
    
    // Método para sugerencias de autocompletado
    public function sugerencias()
    {
        $termino = $this->request->getGet('q');
        
        if (empty($termino)) {
            return $this->response->setJSON([]);
        }
        
        $productos = $this->productoModel
                         ->select('productos.id, productos.nombre, productos.precio, productos.imagen, productos.descripcion')
                         ->where('productos.eliminado', 0)
                         ->where('productos.stock >', 0)
                         ->groupStart()
                             ->like('productos.nombre', $termino)
                             ->orLike('productos.descripcion', $termino)
                         ->groupEnd()
                         ->limit(5)
                         ->findAll();
        
        // Asegurarse de que la imagen tenga la ruta correcta
        foreach ($productos as &$producto) {
            // Verificar si la imagen existe
            if (!empty($producto['imagen'])) {
                $rutaImagen = FCPATH . 'public/uploads/' . $producto['imagen'];
                if (!file_exists($rutaImagen)) {
                    $producto['imagen'] = ''; // Si no existe, dejar vacío para usar la imagen por defecto
                }
            }
        }
        
        return $this->response->setJSON($productos);
    }
}
