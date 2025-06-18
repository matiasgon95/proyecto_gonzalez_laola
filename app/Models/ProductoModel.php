<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\SinonimoModel;

/**
 * Modelo para gestionar productos
 * 
 * Este modelo maneja las operaciones CRUD y consultas relacionadas con los productos
 * del sistema, incluyendo búsquedas avanzadas y relaciones con categorías.
 */
class ProductoModel extends Model
{
    /**
     * Nombre de la tabla en la base de datos
     */
    protected $table = 'productos';
    
    /**
     * Clave primaria de la tabla
     */
    protected $primaryKey = 'id';

    /**
     * Campos permitidos para inserción masiva
     */
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

    /**
     * Configuración para manejo automático de timestamps
     */
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Instancia del modelo de sinónimos para búsquedas avanzadas
     */
    protected $sinonimoModel;

    /**
     * Constructor del modelo
     * Inicializa la instancia del modelo de sinónimos
     */
    public function __construct()
    {
        parent::__construct();
        $this->sinonimoModel = new SinonimoModel();
    }

    /**
     * Obtener productos activos (no eliminados) junto con la categoría
     * 
     * @return array Lista de productos activos con información de categoría
     */
    public function getProductosConCategoriaActivos()
    {
        return $this->select('productos.*, categorias.descripcion as categoria')
                    ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                    ->where('productos.eliminado', 0)
                    ->findAll();
        // Eliminamos la línea: ->where('productos.stock >', 0)
    }

    /**
     * Obtener productos eliminados (papelera)
     * 
     * @return array Lista de productos en papelera con información de categoría
     */
    public function getProductosEliminados()
    {
        return $this->select('productos.*, categorias.descripcion as categoria')
                    ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                    ->where('productos.eliminado', 1)
                    ->findAll();
    }

    /**
     * Búsqueda de productos usando sinónimos de la palabra clave
     * 
     * @param string $termino Término de búsqueda
     * @return array Lista de productos que coinciden con el término o sus sinónimos
     */
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
                        ->groupStart();
        // Eliminamos la línea: ->where('productos.stock >', 0)
        // Y eliminamos el segundo ->groupStart() que está duplicado

        foreach ($palabrasClave as $palabra) {
            $builder->orLike('productos.nombre', $palabra)
                    ->orLike('productos.descripcion', $palabra)
                    ->orLike('categorias.descripcion', $palabra);
        }

        $builder->groupEnd();

        return $builder->findAll();
    }


    /**
     * Búsqueda avanzada de productos utilizando la tabla de sinónimos
     * 
     * Este método realiza una búsqueda más completa utilizando consultas directas a la base de datos
     * para encontrar productos relacionados con el término de búsqueda o sus sinónimos.
     * 
     * @param string $termino Término de búsqueda
     * @return array Lista de productos que coinciden con los criterios de búsqueda
     */
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
                        ->where('productos.eliminado', 0);
        // Eliminamos la línea: ->where('productos.stock >', 0);

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
}
