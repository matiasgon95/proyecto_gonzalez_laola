<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoritoModel extends Model
{
    protected $table            = 'favoritos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['usuario_id', 'producto_id', 'fecha'];
    
    // Obtener todos los favoritos de un usuario
    public function getFavoritos($usuario_id)
    {
        return $this->select('favoritos.*, productos.nombre, productos.precio_vta, productos.imagen, categorias.descripcion as categoria')
                    ->join('productos', 'productos.id = favoritos.producto_id')
                    ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                    ->where('favoritos.usuario_id', $usuario_id)
                    ->where('productos.eliminado', 0)
                    ->findAll();
    }
    
    // Verificar si un producto ya está en favoritos
    public function esFavorito($usuario_id, $producto_id)
    {
        return $this->where('usuario_id', $usuario_id)
                    ->where('producto_id', $producto_id)
                    ->countAllResults() > 0;
    }
    
    // Agregar un producto a favoritos
    public function agregarFavorito($usuario_id, $producto_id)
    {
        // Verificar si ya existe
        if ($this->esFavorito($usuario_id, $producto_id)) {
            return false;
        }
        
        // Agregar a favoritos
        return $this->insert([
            'usuario_id' => $usuario_id,
            'producto_id' => $producto_id,
            'fecha' => date('Y-m-d H:i:s')
        ]);
    }
    
    // Eliminar un producto de favoritos
    public function eliminarFavorito($usuario_id, $producto_id)
    {
        return $this->where('usuario_id', $usuario_id)
                    ->where('producto_id', $producto_id)
                    ->delete();
    }
}