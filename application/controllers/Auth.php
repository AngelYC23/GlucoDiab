<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Usuario_model');
    $this->load->library('session');
  }

  public function login()
  {
    $data['titulo'] = 'Iniciar sesión - GlucoDiab';
    $this->load->view('auth/login', $data);
  }

  public function do_login()
  {
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $usuario = $this->Usuario_model->obtenerPorEmail($email);

    if ($usuario && password_verify($password, $usuario->contraseña)) {
      $this->session->set_userdata([
        'id_usuario' => $usuario->id_usuario,
        'nombre' => $usuario->nombre,
        'email' => $usuario->email,
        'id_rol' => $usuario->id_rol,
        'foto_perfil' => $usuario->foto_perfil,
        'logueado' => true
      ]);

      if ($usuario->id_rol == 1) {
        redirect('doctores/dashboard');
      } elseif ($usuario->id_rol == 2) {
        redirect('pacientes/control');
      } else {
        redirect('home');
      }

    } else {
      $this->session->set_flashdata('error', 'Correo o contraseña incorrectos');
      redirect('auth/login');
    }
  }


  public function register()
  {
    $this->load->view('auth/register');
  }

  public function do_register()
  {
    $data = [
      'nombre' => $this->input->post('nombre'),
      'email' => $this->input->post('email'),
      'contraseña' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
      'id_rol' => 2
    ];
    if ($this->Usuario_model->registrar($data)) {
      $this->session->set_flashdata('success', 'Cuenta creada exitosamente. Ahora puedes iniciar sesión.');
      redirect('auth/login');
    } else {
      $this->session->set_flashdata('error', 'Error al registrar el usuario.');
      redirect('auth/register');
    }
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect('home');
  }
}
