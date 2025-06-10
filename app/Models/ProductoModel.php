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
        'es_destacado',
        'activo',
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
<<<<<<< Updated upstream
=======

    // Búsqueda usando SinonimoModel para obtener sinónimos de la palabra clave
    public function buscarConSinonimos($termino)
    {
        // Buscar palabras clave relacionadas al sinónimo ingresado
        $registros = $this->sinonimoModel->getPalabrasClavePorSinonimo($termino);

        // Extraer solo las palabras clave en un array
        $palabrasClave = array_map(function($registro) {
            return $registro['palabra_clave'];
        }, $registros);

        // Incluir también el término original
        $palabrasClave[] = $termino;

        // Construir la consulta para buscar productos
        $builder = $this->select('productos.*, categorias.descripcion as categoria')
                        ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                        ->where('productos.eliminado', 0)
                        ->where('productos.stock >', 0)
                        ->groupStart();

        foreach ($palabrasClave as $palabra) {
            $builder->orLike('productos.nombre', $palabra)
                    ->orLike('productos.descripcion', $palabra)
                    ->orLike('categorias.descripcion', $palabra);
        }

        $builder->groupEnd();

        return $builder->findAll();
    }


    // El método buscarProductosAvanzado queda igual, ya que es más completo
    public function buscarProductosAvanzado($termino)
    {
        $db = \Config\Database::connect();

        // Buscar sinónimos relacionados al término ingresado
        $builderSinonimos = $db->table('sinonimos');
        $builderSinonimos->select('palabra_clave');
        $builderSinonimos->like('sinonimo', $termino);
        $querySinonimos = $builderSinonimos->get();
        $sinonimos = $querySinonimos->getResultArray();

        // Obtener los valores de las palabras clave relacionadas (categorías)
        $categoriasRelacionadas = array_column($sinonimos, 'palabra_clave');

        // Iniciar consulta de productos
        $builder = $this->select('productos.*, categorias.descripcion as categoria')
                        ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                        ->where('productos.eliminado', 0)
                        ->where('productos.stock >', 0);

        // Buscar por nombre o descripción del producto
        $builder->groupStart()
                ->like('productos.nombre', $termino)
                ->orLike('productos.descripcion', $termino);

        // Buscar por categorías relacionadas al sinónimo
        if (!empty($categoriasRelacionadas)) {
            foreach ($categoriasRelacionadas as $cat) {
                $builder->orLike('categorias.descripcion', $cat);
            }
        }

        $builder->groupEnd();

        return $builder->get()->getResultArray();
    }

    public function obtenerDestacados($limite = 10)
    {
        return $this->select('productos.*, categorias.descripcion as categoria')
                    ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                    ->where('productos.es_destacado', 1)
                    ->where('productos.activo', 1)
                    ->where('productos.eliminado', 0)
                    ->limit($limite)
                    ->findAll();
    }
    
>>>>>>> Stashed changes
}
