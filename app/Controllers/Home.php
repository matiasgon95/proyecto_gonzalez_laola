<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('front\principal');
    }

    public function quienes_somos()
    {
        return view('front/quienes_somos',);
    }

    public function comercializacion()
    {
        return view('front/comercializacion');
    }

    public function contacto()
    {
        return view('front/contacto');
    }

    public function terminos()
    {
        return view('front/terminos_y_usos');
    }
}
