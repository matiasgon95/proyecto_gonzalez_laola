<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para gestionar sinónimos de palabras clave
 * 
 * Este modelo maneja la relación entre palabras clave y sus sinónimos
 * para mejorar las búsquedas en el sistema.
 */
class SinonimoModel extends Model
{
    /**
     * Nombre de la tabla en la base de datos
     */
    protected $table = 'sinonimos';
    
    /**
     * Clave primaria de la tabla
     */
    protected $primaryKey = 'id'; // Ajusta si tu tabla no tiene PK
    
    /**
     * Campos permitidos para inserción masiva
     */
    protected $allowedFields = ['palabra_clave', 'sinonimo'];

    /**
     * Obtiene todos los sinónimos asociados a una palabra clave específica
     *
     * @param string $palabraClave La palabra clave a buscar
     * @return array Lista de sinónimos encontrados
     */
    public function getSinonimosPorPalabraClave(string $palabraClave): array
    {
        return $this->where('palabra_clave', $palabraClave)->findAll();
    }

    /**
     * Obtiene todas las palabras clave asociadas a un sinónimo específico
     * Útil para búsquedas inversas en el sistema
     *
     * @param string $sinonimo El sinónimo a buscar
     * @return array Lista de palabras clave encontradas
     */
    public function getPalabrasClavePorSinonimo(string $sinonimo): array
    {
        return $this->where('sinonimo', $sinonimo)->findAll();
    }
}
