<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class PanelController extends BaseController
{
    public function cliente()
    {
        return view('front/cliente/dashboard');
    }

    public function admin()
    {
        return view('back/dashboard');
    }
}