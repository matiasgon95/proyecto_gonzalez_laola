<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class Producto extends BaseController
{
    protected $productoModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        // Definir cuántos productos por página
        $productosPorPagina = 9; // 3 filas de 3 productos
        
        // Obtener el parámetro de ordenación
        $orden = $this->request->getGet('orden');
        
        // Iniciar la consulta base
        $builder = $this->productoModel->select('productos.*, categorias.descripcion as categoria')
                                      ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                                      ->where('productos.eliminado', 0)
                                      ->where('productos.stock >', 0);
        
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

        $categoriasArray = $this->categoriaModel->where('activo', 1)->findAll();
        $categorias = array_column($categoriasArray, 'descripcion');

        return view('front/productos/index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'pager' => $pager,
            'orden_actual' => $orden // Pasar el orden actual a la vista
        ]);
    }

    public function detalle($id)
    {
        if (!is_numeric($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $producto = $this->productoModel->select('productos.*, categorias.descripcion as categoria')
                                        ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                                        ->where('productos.id', $id)
                                        ->where('productos.eliminado', 0)
                                        ->where('productos.stock >', 0)
                                        ->first();

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('front/productos/detalle', ['producto' => $producto]);
    }

    public function categoria($categoria)
    {
        $categoriaObj = $this->categoriaModel->where('descripcion', $categoria)->first();

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
                         ->where('productos.eliminado', 0)
                         ->where('productos.stock >', 0);
        
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
        
        $productos = $builder->paginate($productosPorPagina);
        
        // Obtener el paginador
        $pager = $this->productoModel->pager;

        $categoriasArray = $this->categoriaModel->where('activo', 1)->findAll();
        $categorias = array_column($categoriasArray, 'descripcion');

        return view('front/productos/index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'pager' => $pager,
            'orden_actual' => $orden, // Pasar el orden actual a la vista
            'categoria_actual' => $categoria // Pasar la categoría actual a la vista
        ]);
    }

    public function buscar()
    {
        $termino = $this->request->getGet('q');

        if (empty($termino)) {
            return redirect()->to(base_url('productos'));
        }

        // Definir cuántos productos por página
        $productosPorPagina = 9; // 3 filas de 3 productos
        
        // Usar el método existente pero con paginación
        $builder = $this->productoModel->select('productos.*, categorias.descripcion as categoria')
                                      ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                                      ->where('productos.eliminado', 0)
                                      ->where('productos.stock >', 0)
                                      ->groupStart()
                                      ->like('productos.nombre', $termino)
                                      ->orLike('productos.descripcion', $termino)
                                      ->orLike('categorias.descripcion', $termino)
                                      ->groupEnd();
        
        $productos = $builder->paginate($productosPorPagina);
        $pager = $this->productoModel->pager;

        $categoriasArray = $this->categoriaModel->where('activo', 1)->findAll();
        $categorias = array_column($categoriasArray, 'descripcion');

        return view('front/productos/index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'termino_busqueda' => $termino,
            'pager' => $pager
        ]);
    }

    public function sugerencias()
    {
        $termino = $this->request->getGet('q');

        if (empty($termino)) {
            $productos = $this->productoModel->getProductosConCategoriaActivos();
        } else {
            $productos = $this->productoModel->buscarConSinonimos($termino);
        }

        return $this->response->setJSON($productos);
    }

}
