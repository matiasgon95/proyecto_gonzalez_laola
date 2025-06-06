<?php

namespace App\Models;

use CodeIgniter\Model;

class usuario_model extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'object'; // Cambiado a object para facilitar el acceso a propiedades
    protected $allowedFields    = ['nombre', 'apellido', 'email', 'pass', 'provincia', 'perfil_id', 'baja'];
    // Eliminar 'usuario' de los campos permitidos
    
    // Modificar estos métodos para que no usen el campo usuario
    public function obtener_usuarios()
    {
        return $this->findAll();
        // Eliminar la línea que asigna email a usuario
    }
    
    public function obtener_clientes()
    {
        return $this->where('perfil_id', 2)->findAll();
        // Eliminar la línea que asigna email a usuario
    }
    
    public function obtener_administradores()
    {
        return $this->where('perfil_id', 1)->findAll();
        // Eliminar la línea que asigna email a usuario
    }
    protected $useTimestamps    = false;

    public function agregar_usuario($data)
    {
        return $this->insert($data);
    }

    public function obtener_usuario_por_id($id)
    {
        return $this->find($id);
    }

    public function actualizar_usuario($id, $data)
    {
        return $this->update($id, $data);
    }

    public function eliminar_usuario($id)
    {
        return $this->delete($id);
    }
    
    public function bloquear_usuario($id)
    {
        return $this->update($id, ['baja' => 'si']);
    }
    
    public function desbloquear_usuario($id)
    {
        return $this->update($id, ['baja' => 'no']);
    }

    public function obtener_por_email($email)
    {
        return $this->where('email', $email)->first();
    }
}
