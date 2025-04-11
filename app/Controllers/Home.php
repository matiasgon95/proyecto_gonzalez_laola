<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['titulo']='principal';
        echo view('front\nav_view');
        echo view('front\plantilla');
        echo view('front\footer_view');
    }
}
