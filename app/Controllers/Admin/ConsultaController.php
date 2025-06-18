<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConsultaModel;

/**
 * ConsultaController
 * 
 * Controlador para la gestión de consultas en el panel de administración
 * Permite listar, ver, cambiar estado y eliminar consultas de usuarios
 */
class ConsultaController extends BaseController
{
    /**
     * @var ConsultaModel Modelo para operaciones con consultas
     */
    protected $consultaModel;
    
    /**
     * Constructor
     * 
     * Inicializa el modelo necesario para las operaciones del controlador
     */
    public function __construct()
    {
        $this->consultaModel = new ConsultaModel();
    }
    
    /**
     * Muestra el listado de consultas activas
     * 
     * Permite filtrar las consultas por tipo de usuario (registrados o visitantes)
     * 
     * @param string|null $tipo Tipo de usuario ('registrados', 'visitantes' o null para todos)
     * @return mixed Vista con la lista de consultas
     */
    public function index($tipo = null)
    {
        $data = [
            'titulo' => 'Gestión de Consultas',
            'tipo' => $tipo
        ];
        
        if ($tipo === 'registrados') {
            $data['consultas'] = $this->consultaModel->getConsultasPorTipo('si', 'activas');
        } else if ($tipo === 'visitantes') {
            $data['consultas'] = $this->consultaModel->getConsultasPorTipo('no', 'activas');
        } else {
            $data['consultas'] = $this->consultaModel->getConsultasActivas();
        }
        
        return view('back/consultas/index', $data);
    }
    
    /**
     * Muestra el detalle de una consulta específica
     * 
     * @param int $id ID de la consulta a visualizar
     * @return mixed Vista con el detalle de la consulta o redirección si no existe
     */
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
    
    /**
     * Cambia el estado de una consulta
     * 
     * @param int $id ID de la consulta
     * @param string $estado Nuevo estado ('pendiente', 'respondida', 'archivada')
     * @return mixed Redirección a la lista de consultas
     */
    public function cambiarEstado($id, $estado)
    {
        $estados_validos = ['pendiente', 'respondida', 'archivada'];
        
        if (!in_array($estado, $estados_validos)) {
            return redirect()->to('back/consultas')->with('error', 'Estado no válido');
        }
        
        $this->consultaModel->cambiarEstado($id, $estado);
        
        return redirect()->to('back/consultas')->with('mensaje', 'Estado de la consulta actualizado correctamente');
    }
    
    /**
     * Elimina una consulta de la base de datos
     * 
     * @param int $id ID de la consulta a eliminar
     * @return mixed Redirección a la lista de consultas
     */
    public function eliminar($id)
    {
        $this->consultaModel->delete($id);
        
        return redirect()->to('back/consultas')->with('mensaje', 'Consulta eliminada correctamente');
    }
    
    /**
     * Realiza acciones masivas sobre múltiples consultas
     * 
     * Permite marcar como respondidas, archivar o eliminar varias consultas a la vez
     * 
     * @return mixed Redirección a la lista de consultas
     */
    public function accionMasiva()
    {
        $consultas = $this->request->getPost('consultas');
        $accion = $this->request->getPost('accion');
        
        // Verificar que se hayan seleccionado consultas
        if (empty($consultas)) {
            return redirect()->to('back/consultas')->with('error', 'No se seleccionaron consultas');
        }
        
        // Verificar que la acción sea válida
        $acciones_validas = ['respondida', 'archivada', 'eliminar'];
        if (!in_array($accion, $acciones_validas)) {
            return redirect()->to('back/consultas')->with('error', 'Acción no válida');
        }
        
        // Procesar según la acción seleccionada
        if ($accion === 'eliminar') {
            // Eliminar las consultas seleccionadas
            $this->consultaModel->delete($consultas);
            $mensaje = 'Consultas eliminadas correctamente';
        } else {
            // Cambiar el estado de las consultas seleccionadas
            foreach ($consultas as $id) {
                $this->consultaModel->cambiarEstado($id, $accion);
            }
            $mensaje = 'Estado de las consultas actualizado correctamente';
        }
        
        return redirect()->to('back/consultas')->with('mensaje', $mensaje);
    }
    
    /**
     * Muestra el listado de consultas archivadas
     * 
     * Permite filtrar las consultas por tipo de usuario (registrados o visitantes)
     * 
     * @param string|null $tipo Tipo de usuario ('registrados', 'visitantes' o null para todos)
     * @return mixed Vista con la lista de consultas archivadas
     */
    public function archivadas($tipo = null)
    {
        $data = [
            'titulo' => 'Consultas Archivadas',
            'tipo' => $tipo
        ];
        
        if ($tipo === 'registrados') {
            $data['consultas'] = $this->consultaModel->getConsultasPorTipo('si', 'archivada');
        } else if ($tipo === 'visitantes') {
            $data['consultas'] = $this->consultaModel->getConsultasPorTipo('no', 'archivada');
        } else {
            $data['consultas'] = $this->consultaModel->getConsultas('archivada');
        }
        
        return view('back/consultas/archivadas', $data);
    }
    
    /**
     * Obtiene el detalle de una consulta en formato JSON
     * 
     * Método utilizado para peticiones AJAX
     * 
     * @param int $id ID de la consulta
     * @return mixed Respuesta JSON con los datos de la consulta
     */
    public function getDetalleConsulta($id)
    {
        $consulta = $this->consultaModel->find($id);
        
        if (!$consulta) {
            return $this->response->setJSON(['error' => 'Consulta no encontrada']);
        }
        
        return $this->response->setJSON(['consulta' => $consulta]);
    }
    
    /**
     * Realiza acciones masivas sobre múltiples consultas archivadas
     * 
     * Permite restaurar (marcar como pendientes) o eliminar varias consultas archivadas a la vez
     * 
     * @return mixed Redirección a la lista de consultas archivadas
     */
    public function accionMasivaArchivadas()
    {
        $consultas = $this->request->getPost('consultas');
        $accion = $this->request->getPost('accion');
        
        // Verificar que se hayan seleccionado consultas
        if (empty($consultas)) {
            return redirect()->to('back/consultas/archivadas')->with('error', 'No se seleccionaron consultas');
        }
        
        // Verificar que la acción sea válida
        $acciones_validas = ['pendiente', 'eliminar'];
        if (!in_array($accion, $acciones_validas)) {
            return redirect()->to('back/consultas/archivadas')->with('error', 'Acción no válida');
        }
        
        // Procesar según la acción seleccionada
        if ($accion === 'eliminar') {
            // Eliminar las consultas seleccionadas
            $this->consultaModel->delete($consultas);
            $mensaje = 'Consultas eliminadas correctamente';
        } else {
            // Cambiar el estado de las consultas seleccionadas
            foreach ($consultas as $id) {
                $this->consultaModel->cambiarEstado($id, $accion);
            }
            $mensaje = 'Consultas restauradas correctamente';
        }
        
        return redirect()->to('back/consultas/archivadas')->with('mensaje', $mensaje);
    }
}