<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_model extends CI_Model
{

  public function registrar($data)
  {
    return $this->db->insert('usuario', $data);
  }

  public function obtenerPorEmail($email)
  {
    return $this->db->get_where('usuario', ['email' => $email])->row();
  }

  public function getPacientes()
  {
    $this->db->select('id_usuario, nombre');
    $this->db->from('usuario');
    $this->db->where('id_rol', 2);
    return $this->db->get()->result();
  }

}
