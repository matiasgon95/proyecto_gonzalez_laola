<?php

namespace App\Models;

use CodeIgniter\Model;

class Ventas_detalle_model extends Model
{
    protected $table            = 'ventas_detalle';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['venta_id', 'producto_id', 'cantidad', 'precio'];
    
    public function insert($data = null, bool $returnID = true)
    {
        return parent::insert($data, $returnID);
    }
    
    public function getDetalles($venta_id)
    {
        return $this->select('ventas_detalle.*, productos.nombre, productos.imagen')
                    ->join('productos', 'productos.id = ventas_detalle.producto_id')
                    ->where('venta_id', $venta_id)
                    ->findAll();
    }
}