<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para gestionar las categorías de productos
 * 
 * Este modelo maneja las operaciones CRUD para las categorías en la base de datos
 */
class CategoriaModel extends Model
{
    /**
     * Nombre de la tabla en la base de datos
     */
    protected $table = 'categorias';
    
    /**
     * Clave primaria de la tabla
     */
    protected $primaryKey = 'id';

    /**
     * Campos que se pueden modificar en la base de datos
     */
    protected $allowedFields = ['descripcion', 'activo', 'created_at', 'updated_at'];
}
