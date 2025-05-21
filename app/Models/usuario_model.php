<?php

namespace App\Models;

use CodeIgniter\Model;

class usuario_model extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre', 'apellido', 'email', 'pass', 'provincia', 'perfil_id'];
    protected $useTimestamps    = false;

    public function agregar_usuario($data)
    {
        return $this->insert($data);
    }

    public function obtener_usuarios()
    {
        return $this->findAll();
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

    public function obtener_por_email($email)
    {
        return $this->where('email', $email)->first();
    }
}
