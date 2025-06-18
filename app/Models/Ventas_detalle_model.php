<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para gestionar los detalles de las ventas
 * 
 * Este modelo maneja la información detallada de cada producto incluido en una venta,
 * como cantidad, precio unitario y referencias al producto y a la venta principal.
 */
class Ventas_detalle_model extends Model
{
    // Configuración de la tabla y sus propiedades
    protected $table            = 'ventas_detalle';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['venta_id', 'producto_id', 'cantidad', 'precio'];
    
    /**
     * Inserta un nuevo detalle de venta
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
     * Obtiene todos los detalles de una venta específica
     * 
     * @param int $venta_id El ID de la venta
     * @return array Los detalles de la venta con información del producto
     */
    public function getDetalles($venta_id)
    {
        return $this->select('ventas_detalle.*, productos.nombre, productos.imagen')
                    ->join('productos', 'productos.id = ventas_detalle.producto_id')
                    ->where('venta_id', $venta_id)
                    ->findAll();
    }
}