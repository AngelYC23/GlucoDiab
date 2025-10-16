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
}
