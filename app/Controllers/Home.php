<?php

namespace App\Controllers;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class Home extends BaseController
{
    public function index()
    {
        $productoModel = new ProductoModel();
        $categoriaModel = new CategoriaModel();
        
        // Obtener IDs de categorías específicas
        $categoriaProcesadores = $categoriaModel->where('descripcion', 'Procesadores')->first();
        $categoriaMemoriasRam = $categoriaModel->where('descripcion', 'Memorias RAM')->first();
        $categoriaPlacasBase = $categoriaModel->where('descripcion', 'Placas Base')->first();
        
        // Obtener productos para cada categoría
        $productosProcesadores = [];
        $productosMemoriasRam = [];
        $productosPlacasBase = [];
        
        if ($categoriaProcesadores) {
            $productosProcesadores = $productoModel->select('productos.*, categorias.descripcion as categoria')
                ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                ->where('productos.categoria_id', $categoriaProcesadores['id'])
                ->where('productos.eliminado', 0)
                ->orderBy('productos.id', 'DESC')
                ->limit(5) // Limitamos a 5 productos para el carrusel
                ->find();
        }
        
        if ($categoriaMemoriasRam) {
            $productosMemoriasRam = $productoModel->select('productos.*, categorias.descripcion as categoria')
                ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                ->where('productos.categoria_id', $categoriaMemoriasRam['id'])
                ->where('productos.eliminado', 0)
                ->orderBy('productos.id', 'DESC')
                ->limit(5) // Limitamos a 5 productos para el carrusel
                ->find();
        }
        
        if ($categoriaPlacasBase) {
            $productosPlacasBase = $productoModel->select('productos.*, categorias.descripcion as categoria')
                ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                ->where('productos.categoria_id', $categoriaPlacasBase['id'])
                ->where('productos.eliminado', 0)
                ->orderBy('productos.id', 'DESC')
                ->limit(5) // Limitamos a 5 productos para el carrusel
                ->find();
        }
        
        return view('front/principal', [
            'titulo' => 'Inicio',
            'productosProcesadores' => $productosProcesadores,
            'productosMemoriasRam' => $productosMemoriasRam,
            'productosPlacasBase' => $productosPlacasBase
        ]);
    }

    public function quienes_somos()
    {
        return view('front/quienes_somos', [
            'titulo' => 'Quiénes Somos'
        ]);
    }

    public function comercializacion()
    {
        return view('front/productos/comercializacion', [
            'titulo' => 'Comercialización'
        ]);
    }

    public function contacto()
    {
        return view('front/contacto', [
            'titulo' => 'Contacto'
        ]);
    }

    public function terminos()
    {
        return view('front/terminos_y_usos', [
            'titulo' => 'Términos y Usos'
        ]);
    }

    public function sitio_en_construccion()
    {
        return view('front/sitio_en_construccion', [
            'titulo' => 'Sitio en Construcción'
        ]);
    }

    public function login()
    {
        return view('front/login', [
            'titulo' => 'Iniciar Sesión'
        ]);
    }

    public function registro_usuario()
    {
        return view('front/registro_usuario', [
            'titulo' => 'Registro de Usuario'
        ]);
    }
}
