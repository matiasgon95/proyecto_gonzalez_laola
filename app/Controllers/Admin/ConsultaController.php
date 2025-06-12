<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConsultaModel;

class ConsultaController extends BaseController
{
    protected $consultaModel;
    
    public function __construct()
    {
        $this->consultaModel = new ConsultaModel();
    }
    
    public function index()
    {
        $data = [
            'titulo' => 'Gestión de Consultas',
            'consultas' => $this->consultaModel->getConsultas()
        ];
        
        return view('back/consultas/index', $data);
    }
    
    public function ver($id)
    {
        $consulta = $this->consultaModel->find($id);
        
        if (!$consulta) {
            return redirect()->to('back/consultas')->with('error', 'Consulta no encontrada');
        }
        
        $data = [
            'titulo' => 'Ver Consulta',
            'consulta' => $consulta
        ];
        
        return view('back/consultas/ver', $data);
    }
    
    public function cambiarEstado($id, $estado)
    {
        $estados_validos = ['pendiente', 'respondida', 'archivada'];
        
        if (!in_array($estado, $estados_validos)) {
            return redirect()->to('back/consultas')->with('error', 'Estado no válido');
        }
        
        $this->consultaModel->cambiarEstado($id, $estado);
        
        return redirect()->to('back/consultas')->with('mensaje', 'Estado de la consulta actualizado correctamente');
    }
    
    public function eliminar($id)
    {
        $this->consultaModel->delete($id);
        
        return redirect()->to('back/consultas')->with('mensaje', 'Consulta eliminada correctamente');
    }
}