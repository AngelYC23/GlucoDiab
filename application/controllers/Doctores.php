<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Doctores extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('logueado')) {
      redirect('auth/login');
    }

    if ($this->session->userdata('id_rol') != 1) {
      redirect('auth/login');
    }
  }

  public function dashboard()
  {
    $data['titulo'] = 'Dashboard';
    $data['contenido'] = 'doctores/dashboard';
    $this->load->view('layouts/main', $data);
  }
}
