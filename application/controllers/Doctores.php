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

    $this->load->model('Usuario_model');
    $this->load->model('Recordatorio_model');
  }

  public function dashboard()
  {
    $data['titulo'] = 'Dashboard';
    $data['contenido'] = 'doctores/dashboard';
    $this->load->view('layouts/main', $data);
  }

  public function chatdoctor()
  {
    $data['pacientes'] = $this->Usuario_model->getPacientes();

    $data['titulo'] = 'Chat';
    $data['contenido'] = 'chat/chatdoctor';
    $this->load->view('layouts/main', $data);
  }

  public function calendario()
  {
    $data['titulo'] = 'Calendario Médico';
    $data['pacientes'] = $this->Usuario_model->getPacientes();
    $data['contenido'] = 'doctores/calendario';
    $this->load->view('layouts/main', $data);
  }

  public function get_recordatorios()
  {
    header('Content-Type: application/json');
    $doctorId = $this->session->userdata('id_usuario');
    echo json_encode($this->Recordatorio_model->getRecordatoriosPorDoctor($doctorId));
  }

  public function add_recordatorio()
  {
    $editando = $this->input->post('editando');
    
    $fecha = $this->input->post('fecha');
    $horaInicio = $this->input->post('hora_inicio');
    $fechaHoraInicio = $fecha . ' ' . $horaInicio . ':00';
    
    $data = [
      'id_usuario_crea' => $this->session->userdata('id_usuario'),
      'id_usuario_recibe' => $this->input->post('id_usuario_recibe'),
      'titulo' => $this->input->post('titulo'),
      'descripcion' => $this->input->post('descripcion'),
      'fecha' => $fechaHoraInicio,
      'color' => $this->input->post('color')
    ];
    
    $tipoEvento = $this->input->post('tipo_evento');
    if ($tipoEvento === 'cita') {
      $horaFin = $this->input->post('hora_fin');
      if ($horaFin) {
        $data['fecha_fin'] = $fecha . ' ' . $horaFin . ':00';
      }
    } else {
      $data['fecha_fin'] = NULL;
    }

    $id = $this->Recordatorio_model->guardarRecordatorio(
      $data,
      $editando == 'true' || $editando === true,
      $this->input->post('id_recordatorio')
    );

    echo json_encode([
      'success' => true,
      'id_recordatorio' => intval($id)
    ]);
  }

  public function pacientes()
  {
    $data['titulo'] = 'Pacientes';
    $data['pacientes'] = $this->Usuario_model->getPacientes();
    $data['contenido'] = 'doctores/pacientes';
    $this->load->view('layouts/main', $data);
  }

}
