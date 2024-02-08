<?php


class UsuariosModel extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}


	public function insert_usuario() {
		$data = [
			'nombre'    => $this->input->post('nombre'),
			'usuario'    => $this->input->post('usuario'),
			'telefono'      => $this->input->post('telefono'),
			'email'      => $this->input->post('email'),
			'password'   => password_hash($this->input->post("password"), PASSWORD_DEFAULT),
		];
		return $this->db->insert('usuario', $data);
	}

	public function find_usuario($id) {
		return $this->db->get_where('usuario', ['id' => $id])->row();
	}

	public function getTipoUsuarios() {
		$this->db->select('*');
        $this->db->from('tipo_usuario');
        $this->db->where('estado=1');
        $q = $this->db->get();
        return $q->result();
	}


	public function update_usuario($id) {
		$data = [
			'nombre'    => $this->input->post('nombre'),
			'usuario'    => $this->input->post('usuario'),
			'telefono'      => $this->input->post('telefono'),
			'email'      => $this->input->post('email'),
		];
		if ($this->input->post("password") !== "") {
			$data["password"] = password_hash($this->input->post("password"), PASSWORD_DEFAULT);
		}

		if ($id == 0) {
			return $this->db->insert('usuario', $data);
		} else {
			$this->db->where('id', $id);
			return $this->db->update('usuario', $data);
		}
	}

	public function delete_usuario($id) {
		$data = ['estado' => 0];

		$this->db->where('id', $id);
		return $this->db->update('usuario', $data);
	}


}
