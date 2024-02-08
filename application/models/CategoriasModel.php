<?php


class CategoriasModel extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}


	public function insert_categoria() {

		$this->db->select('*');
		$this->db->from('categoria');
		$this->db->where('orden', $this->input->post('orden'));
		$query = $this->db->get();

		//VERIFICA SI YA EXISTE EL NÚMERO DE ORDEN
		if ($query->num_rows() > 0) {
				return 3;
		} else {
			$data = [
				'descripcion'    => $this->input->post('descripcion'),
				'orden'    => $this->input->post('orden'),
				'class'    => str_replace(' ', '', $this->input->post('descripcion'))
			];
			return $this->db->insert('categoria', $data);
		}
	}

	public function find_categoria($id) {
		return $this->db->get_where('categoria', ['id' => $id])->row();
	}


	public function getCategorias() {
		$this->db->select('*');
				$this->db->from('categoria');
				$this->db->where('estado=1');
				$q = $this->db->get();

		return $q->result();
	}



	public function update_categoria($id) {

				$this->db->select('*');
				$this->db->from('categoria');
				$this->db->where('orden ='. $this->input->post('orden')." and id != ".$id);
				$query = $this->db->get();

				//VERIFICA SI YA EXISTE EL NÚMERO DE ORDEN
				if ($query->num_rows() > 0) {
						return 3;
				} else {
					$data = [
						'descripcion'    => $this->input->post('descripcion'),
						'orden'    => $this->input->post('orden'),
						'class'    => str_replace(' ', '', $this->input->post('descripcion'))
					];

					if ($id == 0) {
						return $this->db->insert('categoria', $data);
					} else {
						$this->db->where('id', $id);
						return $this->db->update('categoria', $data);
					}
				}

	}

	public function delete_categoria($id) {
		$data = ['estado' => 0];

		$this->db->where('id', $id);
		return $this->db->update('categoria', $data);
	}


}
