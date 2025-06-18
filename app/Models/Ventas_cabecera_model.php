<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para gestionar la cabecera de ventas
 * 
 * Este modelo maneja la información principal de las ventas realizadas,
 * como el usuario que realizó la compra y el monto total.
 */
class Ventas_cabecera_model extends Model
{
    protected $table            = 'ventas_cabecera';  // Nombre de la tabla en la base de datos
    protected $primaryKey       = 'id';               // Clave primaria de la tabla
    protected $useAutoIncrement = true;               // La clave primaria es autoincremental
    protected $returnType       = 'array';            // Tipo de retorno de las consultas
    protected $allowedFields    = ['usuario_id', 'total_venta']; // Campos permitidos para inserción masiva
    protected $useTimestamps    = false; // Cambiado a false porque no existen estos campos
    
    /**
     * Inserta un nuevo registro de venta
     * 
     * @param array|object $data Los datos a insertar
     * @param bool $returnID Si se debe devolver el ID insertado
     * @return int|string|bool El ID insertado, o false en caso de error
     */
    public function insert($data = null, bool $returnID = true)
    {
        return parent::insert($data, $returnID);
    }
    
    /**
     * Obtiene todas las ventas de un usuario específico
     * 
     * @param int $id_usuario ID del usuario
     * @return array Lista de ventas ordenadas por fecha descendente
     */
    public function getVentas($id_usuario)
    {
        return $this->where('usuario_id', $id_usuario)
                    ->orderBy('fecha', 'DESC') // Cambiado de created_at a fecha
                    ->findAll();
    }
}