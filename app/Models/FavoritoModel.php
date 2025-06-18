<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para gestionar los productos favoritos de los usuarios
 * 
 * Este modelo maneja las operaciones relacionadas con los productos
 * marcados como favoritos por los usuarios del sistema.
 */
class FavoritoModel extends Model
{
    /**
     * Nombre de la tabla en la base de datos
     */
    protected $table            = 'favoritos';
    
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
    protected $returnType       = 'array';
    
    /**
     * Campos permitidos para inserción masiva
     */
    protected $allowedFields    = ['usuario_id', 'producto_id', 'fecha'];
    
    /**
     * Obtiene todos los productos favoritos de un usuario específico
     * 
     * Incluye información detallada del producto y su categoría
     * 
     * @param int $usuario_id ID del usuario
     * @return array Lista de productos favoritos con detalles
     */
    public function getFavoritos($usuario_id)
    {
        return $this->select('favoritos.*, productos.nombre, productos.precio_vta, productos.imagen, categorias.descripcion as categoria')
                    ->join('productos', 'productos.id = favoritos.producto_id')
                    ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                    ->where('favoritos.usuario_id', $usuario_id)
                    ->where('productos.eliminado', 0)
                    ->findAll();
    }
    
    /**
     * Verifica si un producto ya está en la lista de favoritos del usuario
     * 
     * @param int $usuario_id ID del usuario
     * @param int $producto_id ID del producto
     * @return bool TRUE si el producto ya es favorito, FALSE en caso contrario
     */
    public function esFavorito($usuario_id, $producto_id)
    {
        return $this->where('usuario_id', $usuario_id)
                    ->where('producto_id', $producto_id)
                    ->countAllResults() > 0;
    }
    
    /**
     * Agrega un producto a la lista de favoritos del usuario
     * 
     * Verifica primero si el producto ya está en favoritos para evitar duplicados
     * 
     * @param int $usuario_id ID del usuario
     * @param int $producto_id ID del producto
     * @return mixed ID del nuevo registro o FALSE si ya existe o hay error
     */
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
    
    /**
     * Elimina un producto de la lista de favoritos del usuario
     * 
     * @param int $usuario_id ID del usuario
     * @param int $producto_id ID del producto
     * @return bool TRUE si se eliminó correctamente, FALSE en caso contrario
     */
    public function eliminarFavorito($usuario_id, $producto_id)
    {
        return $this->where('usuario_id', $usuario_id)
                    ->where('producto_id', $producto_id)
                    ->delete();
    }
}