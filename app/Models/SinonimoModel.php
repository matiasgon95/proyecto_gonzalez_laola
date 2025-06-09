<?php

namespace App\Models;

use CodeIgniter\Model;

class SinonimoModel extends Model
{
    protected $table = 'sinonimos';
    protected $primaryKey = 'id'; // Ajusta si tu tabla no tiene PK
    protected $allowedFields = ['palabra_clave', 'sinonimo'];

    // Obtener sinónimos para una palabra clave
    public function getSinonimosPorPalabraClave(string $palabraClave): array
    {
        return $this->where('palabra_clave', $palabraClave)->findAll();
    }

    // Obtener palabras clave relacionadas a un sinónimo (búsqueda inversa)
    public function getPalabrasClavePorSinonimo(string $sinonimo): array
    {
        return $this->where('sinonimo', $sinonimo)->findAll();
    }
}
