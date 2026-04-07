<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si no hay sesion activa, mandamos al login.
        if (! session('user_id')) {
            return redirect()->route('loginForm')->with('error', 'Primero debes iniciar sesion.');
        }

        // Tomamos el rol esperado desde la ruta: role:admin, role:docente o role:alumno.
        $expectedRole = $arguments[0] ?? 'admin';
        $currentRole  = (string) session('role');

        // Si el rol coincide, dejamos pasar al usuario.
        if ($currentRole === $expectedRole) {
            return;
        }

        // Si el usuario intenta entrar a una vista que no le corresponde,
        // lo regresamos automaticamente a su dashboard real.
        if ($currentRole === 'docente') {
            return redirect()->route('docenteDashboard')
                ->with('error', 'No tienes permiso para entrar a esa vista. Se redirecciono al panel de profesor.');
        }

        if ($currentRole === 'alumno') {
            return redirect()->route('alumnoDashboard')
                ->with('error', 'No tienes permiso para entrar a esa vista. Se redirecciono al panel de alumno.');
        }

        if ($currentRole === 'admin') {
            return redirect()->route('adminDashboard')
                ->with('error', 'No tienes permiso para entrar a esa vista.');
        }

        return redirect()->route('loginForm')->with('error', 'Tu sesion no tiene un rol valido.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
