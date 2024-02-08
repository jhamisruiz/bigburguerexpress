<?php


class EmpresaModel extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function find_empresa() {
		return $this->db->get_where('empresa', ['id' => 1])->row();
	}

	public function update_empresa() {
		$data = [
			'nombre'    => $this->input->post('nombre'),
      'email'    => $this->input->post('email'),
      'telefono'    => $this->input->post('telefono'),
      'direccion'    => $this->input->post('direccion'),
			'precio_delivery'    => $this->input->post('delivery'),
			'hora_entrada'    => $this->input->post('horario_entrada'),
			'hora_salida'    => $this->input->post('horario_salida'),
			'tiempo_espera'    => $this->input->post('tiempo_espera'),
		];

		if($this->input->post('imagen') != ""){
			$data['logo'] = $this->input->post('imagen');
		}

		$this->db->where('id', 1);
		return $this->db->update('empresa', $data);
	}

}
