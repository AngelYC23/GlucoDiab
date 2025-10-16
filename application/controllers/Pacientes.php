<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pacientes extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('logueado')) {
      redirect('auth/login');
    }

    if ($this->session->userdata('id_rol') != 2) {
      redirect('auth/login');
    }
  }

  public function control()
  {
    $data['titulo'] = 'Control';
    $data['contenido'] = 'pacientes/control';
    $this->load->view('layouts/main', $data);
  }
}
