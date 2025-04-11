<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['titulo']='Principal';
        /*echo view('front\nav_view');
        echo view('front\plantilla');
        echo view('front\footer_view');*/
        return view('front\principal', $data);
    }

    public function quienes_somos()
    {
        $data['titulo']='Quienes somos';
        return view('front/quienes_somos', $data);
    }

    public function comercializacion()
    {
        $data['titulo']='Comercialización';
        return view('front/comercializacion', $data);
    }

    public function contacto()
    {
        $data['titulo']='Contacto';
        return view('front/contacto', $data);
    }
}
