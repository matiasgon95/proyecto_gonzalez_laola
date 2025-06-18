<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para gestionar las consultas de usuarios
 * 
 * Este modelo maneja las operaciones relacionadas con las consultas
 * enviadas por usuarios registrados y visitantes del sistema.
 */
class ConsultaModel extends Model
{
    /**
     * Nombre de la tabla en la base de datos
     */
    protected $table            = 'consultas';
    
    /**
     * Clave primaria de la tabla
     */
    protected $primaryKey       = 'id';
    
    /**
     * Indica si se debe usar autoincremento para la clave primaria
     */
    protected $useAutoIncrement = true;
    
    /**
     * Tipo de datos que devuelven las consultas
     */
    protected $returnType       = 'object';
    
    /**
     * Campos permitidos para inserción masiva
     */
    protected $allowedFields    = ['nombre', 'apellido', 'email', 'asunto', 'mensaje', 'estado', 'id_usuario', 'es_registrado'];
    
    /**
     * Obtiene todas las consultas, opcionalmente filtradas por estado
     * 
     * @param string|null $estado Estado de las consultas a filtrar (opcional)
     * @return array Lista de consultas ordenadas por fecha de creación descendente
     */
    public function getConsultas($estado = null)
    {
        $builder = $this->builder();
        
        if ($estado) {
            $builder->where('estado', $estado);
        }
        
        return $builder->orderBy('fecha_creacion', 'DESC')->get()->getResult();
    }
    
    /**
     * Obtiene las consultas que no están archivadas
     * 
     * @return array Lista de consultas activas ordenadas por fecha de creación descendente
     */
    public function getConsultasActivas()
    {
        $builder = $this->builder();
        $builder->where('estado !=', 'archivada');
        
        return $builder->orderBy('fecha_creacion', 'DESC')->get()->getResult();
    }
    
    /**
     * Obtiene consultas filtradas por tipo de usuario (registrado o visitante)
     * 
     * @param bool $esRegistrado TRUE para usuarios registrados, FALSE para visitantes
     * @param string|null $estado Estado de las consultas a filtrar (opcional)
     * @return array Lista de consultas filtradas ordenadas por fecha de creación descendente
     */
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
    
    /**
     * Actualiza el estado de una consulta específica
     * 
     * @param int $id ID de la consulta a actualizar
     * @param string $estado Nuevo estado para la consulta
     * @return bool TRUE si la actualización fue exitosa, FALSE en caso contrario
     */
    public function cambiarEstado($id, $estado)
    {
        return $this->update($id, ['estado' => $estado]);
    }
}