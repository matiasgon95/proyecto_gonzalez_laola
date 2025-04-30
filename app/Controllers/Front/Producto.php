<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;

class Producto extends BaseController
{
    // Datos de productos estáticos
    private $productos = [
        [
            'id' => 1,
            'nombre' => 'Procesador Intel i9',
            'descripcion' => 'Procesador de alto rendimiento',
            'precio' => 343000,
            'categoria' => 'Procesadores'
        ],
        [
            'id' => 2,
            'nombre' => 'Memoria RAM Corsair 16GB',
            'descripcion' => 'Memoria RAM DDR4 16GB',
            'precio' => 64000,
            'categoria' => 'Memorias RAM'
        ],
        [
            'id' => 3,
            'nombre' => 'Placa Base ASUS ROG',
            'descripcion' => 'Placa base gaming',
            'precio' => 260000,
            'categoria' => 'Placas Base'
        ]
    ];

    // Mostrar la lista de productos
    public function index()
{
    $categorias = array_unique(array_column($this->productos, 'categoria'));

    return view('front/productos/index', [
        'productos' => $this->productos,
        'categorias' => $categorias
    ]);
}


    // Ver detalles de un producto
    public function detalle($id)
    {
        // Buscar el producto por ID
        $producto = array_filter($this->productos, fn($producto) => $producto['id'] == $id);
        $producto = reset($producto); // Obtener el primer producto encontrado

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('front/productos/detalle', ['producto' => $producto]);
    }

    // Filtrar productos por categoría
    public function categoria($categoria)
    {
        $productos = array_filter($this->productos, fn($producto) => $producto['categoria'] == $categoria);
        $categorias = array_unique(array_column($this->productos, 'categoria'));

        return view('front/productos/index', [
            'productos' => $productos,
            'categorias' => $categorias
        ]);
    }


}
