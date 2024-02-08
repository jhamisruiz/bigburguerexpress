<?php

class AtributosModel extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}


	public function insert_atributos() {
		$data = [
			'titulo'    => $this->input->post('titulo'),
      'variables'    => $this->input->post('ats'),
		];
		return $this->db->insert('atributo', $data);
	}

	public function find_atributo($id) {
		return $this->db->get_where('atributo', ['id' => $id])->row();
	}


	public function getAtributos() {
		$this->db->select('*');
				$this->db->from('atributo');
				$this->db->where('estado=1');
				$q = $this->db->get();

		return $q->result();
	}


	public function update_atributos($id) {
		$data = [
			'titulo'    => $this->input->post('titulo'),
      'variables'    => $this->input->post('ats'),
		];

		if ($id == 0) {
			return $this->db->insert('atributo', $data);
		} else {
			$this->db->where('id', $id);
			return $this->db->update('atributo', $data);
		}
	}

	public function delete_atributo($id) {
		$data = ['estado' => 0];

		$this->db->where('id', $id);
		return $this->db->update('atributo', $data);
	}
}
