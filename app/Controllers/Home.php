<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('front/principal', [
            'titulo' => 'Inicio'
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
