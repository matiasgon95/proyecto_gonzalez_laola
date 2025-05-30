<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si no hay sesión, redirigir al login
        if (!session()->get('usuario_logueado')) {
            return redirect()->to('front/login');
        }

        // Si hay argumentos (ej. perfil requerido), verificar
        if ($arguments) {
            $perfilRequerido = $arguments[0]; // Ej: '1' para admin
            $perfilUsuario   = session()->get('perfil_id');

            if ($perfilUsuario != $perfilRequerido) {
                // Si no tiene permiso, redirigir al panel correcto
                if ($perfilUsuario == 1) {
                    return redirect()->to('back/dashboard'); // admin
                } else {
                    return redirect()->to('front/cliente/dashboard'); // cliente
                }
            }
        }

        // Si todo está bien, continuar
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se hace nada después
    }
}
