<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'precio',
        'precio_vta',
        'categoria_id',
        'stock',
        'stock_min',
        'imagen',
        'eliminado',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Obtener productos activos (no eliminados) y con stock > 0, junto con la categoría
    public function getProductosConCategoriaActivos()
    {
        return $this->select('productos.*, categorias.descripcion as categoria')
                    ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                    ->where('productos.eliminado', 0)
                    ->where('productos.stock >', 0)
                    ->findAll();
    }

    // Obtener productos eliminados (papelera)
    public function getProductosEliminados()
    {
        return $this->select('productos.*, categorias.descripcion as categoria')
                    ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                    ->where('productos.eliminado', 1)
                    ->findAll();
    }
}
