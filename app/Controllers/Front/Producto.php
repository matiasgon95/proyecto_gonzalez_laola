<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

/**
 * Controlador para gestionar la visualización de productos en el frontend
 * 
 * Este controlador maneja el listado de productos, filtrado por categorías,
 * búsqueda, visualización de detalles y sugerencias de productos
 */
class Producto extends BaseController
{
    /**
     * Modelo de productos para interactuar con la base de datos
     *
     * @var ProductoModel
     */
    protected $productoModel;
    
    /**
     * Modelo de categorías para interactuar con la base de datos
     *
     * @var CategoriaModel
     */
    protected $categoriaModel;

    /**
     * Constructor del controlador
     * 
     * Inicializa los modelos necesarios para las operaciones del controlador
     */
    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
    }

    /**
     * Método para mostrar el listado principal de productos
     * 
     * Muestra todos los productos activos con paginación y opciones de ordenación
     * 
     * @return mixed Vista con el listado de productos
     */
    public function index()
    {
        // Definir cuántos productos por página
        $productosPorPagina = 9; // 3 filas de 3 productos
        
        // Obtener el parámetro de ordenación
        $orden = $this->request->getGet('orden');
        
        // Iniciar la consulta base
        $builder = $this->productoModel->select('productos.*, categorias.descripcion as categoria')
                                      ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                                      ->where('productos.eliminado', 0);
        // Eliminamos la línea: ->where('productos.stock >', 0);
        
        // Aplicar ordenación según el parámetro
        if ($orden == 'precio_asc') {
            $builder->orderBy('productos.precio_vta', 'ASC');
        } elseif ($orden == 'precio_desc') {
            $builder->orderBy('productos.precio_vta', 'DESC');
        } elseif ($orden == 'mas_vendidos') {
            // Consulta para productos más vendidos
            $builder->select('productos.*, categorias.descripcion as categoria, (SELECT COALESCE(SUM(cantidad), 0) FROM ventas_detalle WHERE producto_id = productos.id) as total_vendido');
            $builder->orderBy('total_vendido', 'DESC');
        } else {
            // Ordenación predeterminada
            $builder->orderBy('productos.id', 'DESC');
        }
        
        // Usar el paginador de CodeIgniter
        $productos = $builder->paginate($productosPorPagina);
        
        // Obtener el paginador
        $pager = $this->productoModel->pager;

        // Obtener todas las categorías activas para el menú de navegación
        $categoriasArray = $this->categoriaModel->where('activo', 1)->findAll();
        $categorias = array_column($categoriasArray, 'descripcion');

        // Cargar la vista con los datos
        return view('front/productos/index', [
            'titulo' => 'Catálogo de Productos',
            'productos' => $productos,
            'categorias' => $categorias,
            'pager' => $pager,
            'orden_actual' => $orden // Pasar el orden actual a la vista
        ]);
    }

    /**
     * Método para mostrar el detalle de un producto específico
     * 
     * @param int $id ID del producto a mostrar
     * @return mixed Vista con el detalle del producto
     * @throws \CodeIgniter\Exceptions\PageNotFoundException Si el producto no existe o no es válido
     */
    public function detalle($id)
    {
        // Verificar que el ID sea numérico
        if (!is_numeric($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Buscar el producto en la base de datos
        $producto = $this->productoModel->select('productos.*, categorias.descripcion as categoria')
                                        ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                                        ->where('productos.id', $id)
                                        ->where('productos.eliminado', 0)
                                        ->first();

        // Si no se encuentra el producto, mostrar error 404
        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Cargar la vista de detalle
        return view('front/productos/detalle', [
            'titulo' => $producto['nombre'],
            'producto' => $producto
        ]);
    }

    /**
     * Método para mostrar productos filtrados por categoría
     * 
     * @param string $categoria Nombre de la categoría a filtrar
     * @return mixed Vista con los productos de la categoría seleccionada
     * @throws \CodeIgniter\Exceptions\PageNotFoundException Si la categoría no existe
     */
    public function categoria($categoria)
    {
        // Buscar la categoría por su descripción
        $categoriaObj = $this->categoriaModel->where('descripcion', $categoria)->first();

        // Si no se encuentra la categoría, mostrar error 404
        if (!$categoriaObj) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Definir cuántos productos por página
        $productosPorPagina = 9; // 3 filas de 3 productos
        
        // Obtener el parámetro de ordenación
        $orden = $this->request->getGet('orden');
        
        // Iniciar la consulta base
        $builder = $this->productoModel
                 ->select('productos.*, categorias.descripcion as categoria')
                 ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                 ->where('productos.categoria_id', $categoriaObj['id'])
                 ->where('productos.eliminado', 0);
        // Eliminamos la línea: ->where('productos.stock >', 0);
        
        // Aplicar ordenación según el parámetro
        if ($orden == 'precio_asc') {
            $builder->orderBy('productos.precio_vta', 'ASC');
        } elseif ($orden == 'precio_desc') {
            $builder->orderBy('productos.precio_vta', 'DESC');
        } elseif ($orden == 'mas_vendidos') {
            // Consulta para productos más vendidos
            $builder->select('productos.*, categorias.descripcion as categoria, (SELECT COALESCE(SUM(cantidad), 0) FROM ventas_detalle WHERE producto_id = productos.id) as total_vendido');
            $builder->orderBy('total_vendido', 'DESC');
        } else {
            // Ordenación predeterminada
            $builder->orderBy('productos.id', 'DESC');
        }
        
        // Paginar los resultados
        $productos = $builder->paginate($productosPorPagina);
        
        // Obtener el paginador
        $pager = $this->productoModel->pager;

        // Obtener todas las categorías activas para el menú de navegación
        $categoriasArray = $this->categoriaModel->where('activo', 1)->findAll();
        $categorias = array_column($categoriasArray, 'descripcion');

        // Cargar la vista con los datos
        return view('front/productos/index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'pager' => $pager,
            'orden_actual' => $orden, // Pasar el orden actual a la vista
            'categoria_actual' => $categoria // Pasar la categoría actual a la vista
        ]);
    }

    /**
     * Método para buscar productos por término de búsqueda
     * 
     * Utiliza el método buscarConSinonimos del modelo para encontrar productos
     * relacionados con el término de búsqueda
     * 
     * @return mixed Vista con los resultados de la búsqueda
     */
    public function buscar()
    {
        // Obtener el término de búsqueda
        $termino = $this->request->getGet('q');

        // Si no hay término, redirigir al listado completo
        if (empty($termino)) {
            return redirect()->to(base_url('productos'));
        }

        // Definir cuántos productos por página
        $productosPorPagina = 9; // 3 filas de 3 productos
        
        // Obtener productos usando el método que incluye búsqueda por sinónimos
        $productos = $this->productoModel->buscarConSinonimos($termino);
        
        // Convertir el resultado a un objeto de paginación
        $pager = service('pager');
        $page = (int)(($this->request->getGet('page') ?? 1));
        $total = count($productos);
        $pager->makeLinks($page, $productosPorPagina, $total);
        
        // Paginar manualmente los resultados
        $offset = ($page - 1) * $productosPorPagina;
        $productos = array_slice($productos, $offset, $productosPorPagina);

        // Obtener todas las categorías activas para el menú de navegación
        $categoriasArray = $this->categoriaModel->where('activo', 1)->findAll();
        $categorias = array_column($categoriasArray, 'descripcion');

        // Cargar la vista con los datos
        return view('front/productos/index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'termino_busqueda' => $termino,
            'pager' => $pager
        ]);
    }

    /**
     * Método para proporcionar sugerencias de productos para autocompletado
     * 
     * Devuelve un JSON con productos que coinciden con el término de búsqueda
     * 
     * @return \CodeIgniter\HTTP\Response JSON con los productos sugeridos
     */
    public function sugerencias()
    {
        // Obtener el término de búsqueda
        $termino = $this->request->getGet('q');

        // Si no hay término, mostrar todos los productos activos
        if (empty($termino)) {
            $productos = $this->productoModel->getProductosConCategoriaActivos();
        } else {
            // Buscar productos relacionados con el término
            $productos = $this->productoModel->buscarConSinonimos($termino);
        }

        // Devolver los resultados como JSON
        return $this->response->setJSON($productos);
    }

}
