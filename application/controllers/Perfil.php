<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perfil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Debe estar logueado sin importar el rol
        if (!$this->session->userdata('logueado')) {
            redirect('auth/login');
        }

        $this->load->model('Usuario_model');
    }

    public function index()
    {
        $id = $this->session->userdata('id_usuario');
        $data['usuario'] = $this->Usuario_model->getUsuarioById($id);

        $data['titulo'] = 'Mi Perfil';
        $data['contenido'] = 'perfil/perfil';
        $this->load->view('layouts/main', $data);
    }

    public function actualizar()
    {
        $id = $this->session->userdata('id_usuario');
        $nombre = $this->input->post('nombre');

        $updateData = [
            'nombre' => $nombre
        ];

        // ✅ Manejo de imagen
        if (!empty($_FILES['foto']['name'])) {

            $config['upload_path'] = './uploads/perfiles/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['file_name'] = 'perfil_' . $id;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $fileData = $this->upload->data();
                $updateData['foto_perfil'] = $fileData['file_name'];
                $this->session->set_userdata('foto_perfil', $fileData['file_name']);
            }
        }

        $this->Usuario_model->actualizarUsuario($id, $updateData);

        $this->session->set_flashdata('success', 'Perfil actualizado correctamente.');
        redirect('perfil');
    }
}
