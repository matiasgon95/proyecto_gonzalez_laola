<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si el usuario no está logueado, redirigir al login
        if (!session()->get('usuario_logueado')) {
            return redirect()->to(site_url('front/login'));
        }
        
        // Verificar el perfil si se especifica en los argumentos
        if (!empty($arguments) && session()->get('perfil_id') != $arguments[0]) {
            return redirect()->to(site_url('/'));
        }
        
        // Si intenta acceder a rutas de admin y no es admin, redirigir
        if (strpos($request->getUri()->getPath(), 'admin') !== false && session()->get('perfil_id') != 1) {
            return redirect()->to(site_url('/'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hacemos nada después
    }
}
