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

        $categorias = $categoriaModel->where('activo', 1)->findAll();
        $destacados = $productoModel->obtenerDestacados(50); // más cantidad para filtrar bien

        return view('front/principal', [
            'categorias' => $categorias,
            'destacados' => $destacados,
        ]);
    }

    public function quienes_somos()
    {
        return view('front/quienes_somos',);
    }

    public function comercializacion()
    {
        return view('front/productos/comercializacion');
    }

    public function contacto()
    {
        return view('front/contacto');
    }

    public function terminos()
    {
        return view('front/terminos_y_usos');
    }

    public function sitio_en_construccion()
    {
    return view('front/sitio_en_construccion');
    }

    public function login()
    {
    return view('front/login');
    }

    public function registro_usuario()
    {
    return view('front/registro_usuario');
    }
}
