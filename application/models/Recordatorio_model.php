<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recordatorio_model extends CI_Model
{
  public function getRecordatoriosPorDoctor($doctorId)
  {
    $this->db->select('
      r.id_recordatorio AS id,
      r.titulo AS title,
      r.descripcion,
      r.fecha AS start,
      r.fecha_fin AS end,
      r.color,
      u.nombre AS paciente
    ');
    $this->db->from('recordatorio r');
    $this->db->join('usuario u', 'u.id_usuario = r.id_usuario_recibe');
    $this->db->where('r.id_usuario_crea', $doctorId);
    
    $query = $this->db->get();
    $recordatorios = $query->result();
    
    foreach ($recordatorios as $rec) {
      $rec->backgroundColor = $rec->color ?? '#3498db';
      $rec->borderColor = $rec->color ?? '#3498db';
    }
    
    return $recordatorios;
  }

  public function guardarRecordatorio($data, $editando = false, $id = null)
  {
    if ($editando) {
      $this->db->where('id_recordatorio', $id);
      $this->db->update('recordatorio', $data);
      return $id;
    } else {
      $this->db->insert('recordatorio', $data);
      return $this->db->insert_id();
    }
  }

  public function getRecordatoriosPorPaciente($pacienteId)
  {
    $this->db->select('
      r.id_recordatorio AS id,
      r.titulo AS title,
      r.descripcion,
      r.fecha AS start,
      r.fecha_fin AS end,
      r.color,
      u.nombre AS doctor
    ');
    $this->db->from('recordatorio r');
    $this->db->join('usuario u', 'u.id_usuario = r.id_usuario_crea');
    $this->db->where('r.id_usuario_recibe', $pacienteId);
    $this->db->order_by('r.fecha', 'ASC');

    $query = $this->db->get();
    $recordatorios = $query->result();

    foreach ($recordatorios as $rec) {
      $rec->backgroundColor = $rec->color ?? '#3498db';
      $rec->borderColor = $rec->color ?? '#3498db';
    }

    return $recordatorios;
  }
}
