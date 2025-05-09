<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class usuario_model extends CI_Model {

    private $table = 'usuarios';

    public function __construct() {
        parent::__construct();
    }

    public function agregar_usuario($data) {
        return $this->db->insert($this->table, $data);
    }

    public function obtener_usuarios() {
        return $this->db->get($this->table)->result();
    }

    public function obtener_usuario_por_id($id) {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    public function actualizar_usuario($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function eliminar_usuario($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}
