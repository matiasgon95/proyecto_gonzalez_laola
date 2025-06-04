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

    public function index()
    {
        $productos = $this->productoModel
            ->select('productos.*, categorias.descripcion as categoria_descripcion')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->findAll();
        $data['productos'] = $productos;
        return view('back/productos/index', $data);
    }

    public function crear()
    {
        $data['categorias'] = $this->categoriaModel->findAll();
        return view('back/productos/crear', $data);
    }

    private function limpiarNombreArchivo($nombre) {
        $nombre = strtolower($nombre);
        $nombre = preg_replace('/[^a-z0-9]+/', '-', $nombre);
        $nombre = trim($nombre, '-');
        return $nombre;
    }

    public function guardar()
    {
        $img = $this->request->getFile('imagen');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $originalName = pathinfo($img->getClientName(), PATHINFO_FILENAME);
            $nombreLimpio = $this->limpiarNombreArchivo($originalName);
            $newName = $nombreLimpio . '_' . time() . '.' . $img->getClientExtension();
            $img->move('public/uploads', $newName);
            $imagenPath = 'public/uploads/' . $newName;
        } else {
            $imagenPath = null;
        }

        $datos = [
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio'      => $this->request->getPost('precio'),
            'categoria_id'=> $this->request->getPost('categoria'),
            'stock'       => $this->request->getPost('stock'),
            'imagen'      => $imagenPath,
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
            $imagenPath = 'public/uploads/' . $newName;
        } else {
            $imagenPath = $this->request->getPost('imagen_actual');
        }

        $datos = [
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio'      => $this->request->getPost('precio'),
            'categoria_id'=> $this->request->getPost('categoria'),
            'stock'       => $this->request->getPost('stock'),
            'imagen'      => $imagenPath,
        ];

        $this->productoModel->update($id, $datos);
        session()->setFlashdata('exito', 'Producto actualizado correctamente.');
        return redirect()->to('back/productos');
    }

    public function eliminar($id)
    {
        $this->productoModel->delete($id);
        return redirect()->to('back/productos');
    }
}
