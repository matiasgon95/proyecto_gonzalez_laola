<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para gestionar usuarios del sistema
 * 
 * Este modelo maneja las operaciones CRUD para los usuarios,
 * incluyendo clientes y administradores.
 */
class usuario_model extends Model
{
    protected $table            = 'usuarios';    // Nombre de la tabla en la base de datos
    protected $primaryKey       = 'id';          // Clave primaria de la tabla

    protected $useAutoIncrement = true;          // La clave primaria es autoincremental
    protected $returnType       = 'object';      // Cambiado a object para facilitar el acceso a propiedades
    protected $allowedFields    = ['nombre', 'apellido', 'email', 'pass', 'provincia', 'perfil_id', 'baja'];
    protected $useTimestamps    = false;         // No se utilizan campos de timestamp
    
    /**
     * Obtiene todos los usuarios del sistema
     * 
     * @return array Lista de todos los usuarios
     */
    public function obtener_usuarios()
    {
        return $this->findAll();
    }
    
    /**
     * Obtiene solo los usuarios con perfil de cliente (perfil_id = 2)
     * 
     * @return array Lista de usuarios con perfil de cliente
     */
    public function obtener_clientes()
    {
        return $this->where('perfil_id', 2)->findAll();
    }
    
    /**
     * Obtiene solo los usuarios con perfil de administrador (perfil_id = 1)
     * 
     * @return array Lista de usuarios con perfil de administrador
     */
    public function obtener_administradores()
    {
        return $this->where('perfil_id', 1)->findAll();
    }

    /**
     * Agrega un nuevo usuario al sistema
     * 
     * @param array $data Datos del usuario a agregar
     * @return int|bool ID del usuario insertado o false en caso de error
     */
    public function agregar_usuario($data)
    {
        return $this->insert($data);
    }

    /**
     * Obtiene un usuario específico por su ID
     * 
     * @param int $id ID del usuario
     * @return object|null Objeto con los datos del usuario o null si no existe
     */
    public function obtener_usuario_por_id($id)
    {
        return $this->find($id);
    }

    /**
     * Actualiza los datos de un usuario existente
     * 
     * @param int $id ID del usuario a actualizar
     * @param array $data Nuevos datos del usuario
     * @return bool True si la actualización fue exitosa, false en caso contrario
     */
    public function actualizar_usuario($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Elimina un usuario del sistema
     * 
     * @param int $id ID del usuario a eliminar
     * @return bool True si la eliminación fue exitosa, false en caso contrario
     */
    public function eliminar_usuario($id)
    {
        return $this->delete($id);
    }
    
    /**
     * Bloquea un usuario cambiando su estado de baja a 'si'
     * 
     * @param int $id ID del usuario a bloquear
     * @return bool True si el bloqueo fue exitoso, false en caso contrario
     */
    public function bloquear_usuario($id)
    {
        return $this->update($id, ['baja' => 'si']);
    }
    
    /**
     * Desbloquea un usuario cambiando su estado de baja a 'no'
     * 
     * @param int $id ID del usuario a desbloquear
     * @return bool True si el desbloqueo fue exitoso, false en caso contrario
     */
    public function desbloquear_usuario($id)
    {
        return $this->update($id, ['baja' => 'no']);
    }

    /**
     * Busca un usuario por su dirección de email
     * 
     * @param string $email Email del usuario a buscar
     * @return object|null Objeto con los datos del usuario o null si no existe
     */
    public function obtener_por_email($email)
    {
        return $this->where('email', $email)->first();
    }
}
