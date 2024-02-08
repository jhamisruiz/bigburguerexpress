<?php


class MotorizadosModel extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}


	public function insert_motorizado() {

    $data = [
      'nombre'    => $this->input->post('nombre'),
    ];
    return $this->db->insert('motorizado', $data);

	}

	public function find_motorizado($id) {
		return $this->db->get_where('motorizado', ['id' => $id])->row();
	}

	public function getMotorizados() {
		$this->db->select('*');
				$this->db->from('motorizado');
				$this->db->where('estado=1');
				$q = $this->db->get();

		return $q->result();
	}

	public function update_motorizado($id) {

    $data = [
      'nombre'    => $this->input->post('nombre'),
    ];

    if ($id == 0) {
      return $this->db->insert('motorizado', $data);
    } else {
      $this->db->where('id', $id);
      return $this->db->update('motorizado', $data);
    }

	}

	public function delete_motorizado($id) {
		$data = ['estado' => 0];

		$this->db->where('id', $id);
		return $this->db->update('motorizado', $data);
	}


}
