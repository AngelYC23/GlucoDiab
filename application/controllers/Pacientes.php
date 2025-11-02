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

    $this->load->model('Recordatorio_model');
  }

  public function control()
  {
    $data['titulo'] = 'Control';
    $data['contenido'] = 'pacientes/control';
    $this->load->view('layouts/main', $data);
  }

  public function calendario()
  {
    $data['titulo'] = 'Mi Agenda Médica';
    $data['contenido'] = 'pacientes/calendario';
    $this->load->view('layouts/main', $data);
  }
  
  public function get_recordatorios_asignados()
  {
    header('Content-Type: application/json');
    $pacienteId = $this->session->userdata('id_usuario');
    echo json_encode($this->Recordatorio_model->getRecordatoriosPorPaciente($pacienteId));
  }
}
