<?php

namespace App\Models;

use CodeIgniter\Model;

class Ventas_cabecera_model extends Model
{
    protected $table            = 'ventas_cabecera';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['usuario_id', 'total_venta'];
    protected $useTimestamps    = false; // Cambiado a false porque no existen estos campos
    
    public function insert($data = null, bool $returnID = true)
    {
        return parent::insert($data, $returnID);
    }
    
    public function getVentas($id_usuario)
    {
        return $this->where('usuario_id', $id_usuario)
                    ->orderBy('fecha', 'DESC') // Cambiado de created_at a fecha
                    ->findAll();
    }
}