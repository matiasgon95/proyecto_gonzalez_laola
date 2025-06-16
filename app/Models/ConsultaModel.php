<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsultaModel extends Model
{
    protected $table            = 'consultas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['nombre', 'apellido', 'email', 'asunto', 'mensaje', 'estado', 'id_usuario', 'es_registrado'];
    
    // Obtener todas las consultas
    public function getConsultas($estado = null)
    {
        $builder = $this->builder();
        
        if ($estado) {
            $builder->where('estado', $estado);
        }
        
        return $builder->orderBy('fecha_creacion', 'DESC')->get()->getResult();
    }
    
    // Obtener consultas activas (no archivadas)
    public function getConsultasActivas()
    {
        $builder = $this->builder();
        $builder->where('estado !=', 'archivada');
        
        return $builder->orderBy('fecha_creacion', 'DESC')->get()->getResult();
    }
    
    // Obtener consultas por tipo de usuario (registrado o visitante)
    public function getConsultasPorTipo($esRegistrado, $estado = null)
    {
        $builder = $this->builder();
        $builder->where('es_registrado', $esRegistrado);
        
        if ($estado === 'activas') {
            $builder->where('estado !=', 'archivada');
        } else if ($estado) {
            $builder->where('estado', $estado);
        }
        
        return $builder->orderBy('fecha_creacion', 'DESC')->get()->getResult();
    }
    
    // Cambiar el estado de una consulta
    public function cambiarEstado($id, $estado)
    {
        return $this->update($id, ['estado' => $estado]);
    }
}