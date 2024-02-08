<?php

defined('BASEPATH') || exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('logo_filename')) {
			$empresa = $this->db->get_where('empresa', ['id' => 1])->row();
			$this->session->set_userdata('logo_filename', $empresa->logo);
		}
		if (!$this->session->userdata('usuarioID')) {
			redirect(base_url('login'));
		}
	}

}


class MY_Logo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('logo_filename') || !$this->session->userdata('precio_delivery')) {
			$this->db->select('logo, precio_delivery, DATE_FORMAT(hora_entrada, "%H:%i")  as hora_entrada, DATE_FORMAT(hora_salida, "%H:%i")  as hora_salida');
			$this->db->from('empresa');
			$this->db->where('id=1');
			$empresa = $this->db->get()->row();
			$this->session->set_userdata('logo_filename', $empresa->logo);
			$this->session->set_userdata('horario_entrada', $empresa->hora_entrada);
			$this->session->set_userdata('horario_salida', $empresa->hora_salida);
			$this->session->set_userdata('precio_delivery', $empresa->precio_delivery);
		}
	}

}
