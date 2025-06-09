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

    // Buscar productos por nombre o categoría
    public function buscar()
    {
        $busqueda = strtolower($this->request->getGet('q'));

        // 1. Limpiar la búsqueda quitando signos de puntuación comunes
        $busquedaLimpia = preg_replace('/[^\w\s]/u', '', $busqueda);

        // 2. Separar en palabras y eliminar vacíos
        $palabras = array_filter(explode(' ', $busquedaLimpia));

        // Diccionario de sinónimos
        $sinonimos = [
            'placa madre' => ['motherboard', 'placa madre', 'placa base'],
            'placa de video' => ['gpu', 'placa gráfica', 'placa de video', 'tarjeta gráfica'],
            'procesador' => ['cpu', 'procesador'],
            'memoria ram' => ['memoria', 'ram', 'memoria ram', 'ddr3', 'ddr4', 'ddr5', 'memoria ddr3', 'memoria ddr4', 'memoria ddr5'],
            'disco' => ['hdd', 'ssd', 'disco', 'almacenamiento', 'disco HDD', 'disco SSD', 'disco duro HDD'],
        ];

        // 3. Revisar si la búsqueda limpia es sinónimo, y reemplazar por variantes completas
        foreach ($sinonimos as $clave => $variantes) {
            if (in_array($busquedaLimpia, $variantes)) {
                $palabras = $variantes;
                break;
            }
        }

        $productoModel = new \App\Models\ProductoModel();

        $productoModel->select('productos.*, categorias.descripcion as categoria')
                    ->join('categorias', 'categorias.id = productos.categoria_id');

        $productoModel->groupStart();

        // Buscar cada palabra en nombre, descripción y categoría
        foreach ($palabras as $palabra) {
            $productoModel->like('productos.nombre', $palabra)
                        ->orLike('productos.descripcion', $palabra)
                        ->orLike('categorias.descripcion', $palabra);
        }

        $productoModel->groupEnd();

        $productoModel->where('productos.eliminado', 0);
        $productoModel->where('productos.stock >', 0);

        $productos = $productoModel->findAll();

        $categoriaModel = new \App\Models\CategoriaModel();
        $categoriasArray = $categoriaModel->where('activo', 1)->findAll();
        $categorias = array_column($categoriasArray, 'descripcion');

        return view('front/productos/index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'query' => $busqueda,
        ]);
    }

}
