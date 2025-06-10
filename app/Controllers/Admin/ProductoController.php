<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class ProductoController extends BaseController
{
    protected $productoModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
    }

    // Mostrar productos activos (no eliminados)
    public function index()
    {
        $productos = $this->productoModel
            ->select('productos.*, categorias.descripcion as categoria_descripcion')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.eliminado', 0)   // Solo productos no eliminados
            ->findAll();

        $data['productos'] = $productos;
        $data['titulo'] = 'Gestión de Productos';
        return view('back/productos/index', $data);
    }

    // Mostrar productos eliminados (papelera)
    public function papelera()
    {
        $productosEliminados = $this->productoModel
            ->select('productos.*, categorias.descripcion as categoria_descripcion')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.eliminado', 1)  // Solo productos eliminados
            ->findAll();

        $data['productos'] = $productosEliminados;
        $data['titulo'] = 'Papelera de Productos';
        return view('back/productos/papelera', $data);
    }

    public function crear()
    {
        $data['categorias'] = $this->categoriaModel->findAll();
        $data['titulo'] = 'Crear Producto';
        return view('back/productos/crear', $data);
    }

    private function limpiarNombreArchivo($nombre)
    {
        $nombre = strtolower($nombre);
        $nombre = preg_replace('/[^a-z0-9]+/', '-', $nombre);
        $nombre = trim($nombre, '-');
        return $nombre;
    }

    public function guardar()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre'       => 'required',
            'descripcion'  => 'permit_empty',
            'precio'       => 'required|decimal|greater_than_equal_to[0]',
            'categoria'    => 'required|integer',
            'stock'        => 'required|integer|greater_than_equal_to[0]',
            'imagen'       => 'permit_empty|is_image[imagen]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Si falla la validación, volvemos al formulario con los errores y datos viejos
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $img = $this->request->getFile('imagen');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $originalName = pathinfo($img->getClientName(), PATHINFO_FILENAME);
            $nombreLimpio = $this->limpiarNombreArchivo($originalName);
            $newName = $nombreLimpio . '_' . time() . '.' . $img->getClientExtension();
            $img->move('public/uploads', $newName);
            $imagenPath = 'uploads/' . $newName;
        } else {
            $imagenPath = null;
        }

        $datos = [
            'nombre'       => $this->request->getPost('nombre'),
            'descripcion'  => $this->request->getPost('descripcion'),
            'precio'       => $this->request->getPost('precio'),
            'precio_vta'   => $this->request->getPost('precio_vta'),
            'categoria_id' => $this->request->getPost('categoria'),
            'stock'        => $this->request->getPost('stock'),
            'stock_min' => $this->request->getPost('stock_min'),
            'imagen'       => $imagenPath,
            'eliminado'    => 0,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ];

        $this->productoModel->insert($datos);
        return redirect()->to('back/productos');
    }

    public function editar($id)
    {
        $producto = $this->productoModel->find($id);
        $categorias = $this->categoriaModel->findAll();

        $data = [
            'producto' => $producto,
            'categorias' => $categorias,
        ];

        return view('back/productos/editar', $data);
    }

    public function actualizar($id)
    {
        $img = $this->request->getFile('imagen');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $originalName = pathinfo($img->getClientName(), PATHINFO_FILENAME);
            $nombreLimpio = $this->limpiarNombreArchivo($originalName);
            $extension = $img->getClientExtension();
            $newName = $nombreLimpio . '_' . time() . '.' . $extension;

            $img->move('public/uploads', $newName);
            $imagenPath = 'uploads/' . $newName;
        } else {
            $imagenPath = $this->request->getPost('imagen_actual');
        }

        $datos = [
            'nombre'       => $this->request->getPost('nombre'),
            'descripcion'  => $this->request->getPost('descripcion'),
            'precio'       => $this->request->getPost('precio'),
            'precio_vta' => $this->request->getPost('precio_vta'),
            'categoria_id' => $this->request->getPost('categoria'),
            'stock'        => $this->request->getPost('stock'),
            'stock_min' => $this->request->getPost('stock_min'),
            'imagen'       => $imagenPath,
            'updated_at'=> date('Y-m-d H:i:s'),
        ];

        $this->productoModel->update($id, $datos);
        session()->setFlashdata('exito', 'Producto actualizado correctamente.');
        return redirect()->to('back/productos');
    }

    // Eliminación lógica (marcar eliminado)
    public function eliminar($id)
    {
        $producto = $this->productoModel->find($id);
        if (!$producto) {
            return redirect()->to('back/productos')->with('error', 'Producto no encontrado');
        }

        $this->productoModel->update($id, [
            'eliminado' => 1,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('back/productos')->with('exito', 'Producto eliminado correctamente');
    }
    
    public function eliminar_definitivo($id)
    {
        $this->productoModel->delete($id, true); // `true` para forzar borrado permanente
        return redirect()->to(base_url('back/productos/papelera'))->with('mensaje', 'Producto eliminado permanentemente.');
    }


    // Restaurar producto eliminado
    public function restaurar($id)
    {
        $producto = $this->productoModel->find($id);
        if (!$producto) {
            return redirect()->to('back/productos/papelera')->with('error', 'Producto no encontrado');
        }

        $this->productoModel->update($id, [
            'eliminado' => 0,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('back/productos/papelera')->with('exito', 'Producto restaurado correctamente');
    }

    /**
     * Guarda una nueva categoría desde el modal
     */
    public function guardarCategoria() // Puedes renombrar a guardar_categoria para consistencia
    {
        // Validar los datos del formulario
        $rules = [
            'descripcion' => 'required|min_length[2]|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Preparar los datos para guardar
        $data = [
            'descripcion' => $this->request->getPost('descripcion'),
            'activo' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Guardar la categoría
        $this->categoriaModel->insert($data);

        // Redirigir con mensaje de éxito
        return redirect()->to('back/productos')->with('mensaje_categoria', 'Categoría creada correctamente');
    }
}