<?php

class Login extends CI_Controller {

	public function index() {
		if ($this->session->userdata('usuarioID')) {
			redirect(base_url('pedidos'), 'refresh');
		}
		$this->form_validation->set_rules('email', 'email', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
		if ($this->form_validation->run()) {
			$usuario = $this->db->get_where('usuario', ['email' => $this->input->post("email")])->row();
			if($usuario){
				if (password_verify($this->input->post("password"), $usuario->password)) {
					$this->session->set_userdata("usuarioID", $usuario->id);
					$this->session->set_userdata("usuario", $usuario->usuario);
					redirect(base_url('pedidos'), 'refresh');
				}else{
					$mensaje = 'Usuario o Contraseña incorrectos';
					$this->session->set_flashdata('mensaje', $mensaje);
  					redirect(base_url('login'), 'refresh');
				}
			}else{
					$mensaje = 'Usuario o Contraseña incorrectos';
					$this->session->set_flashdata('mensaje', $mensaje);
  					redirect(base_url('login'), 'refresh');
			}
		}
			$this->load->view('login');
	}


	public function logout() {
		$sesiones = ['usuarioID', 'usuario'];
		$this->session->unset_userdata($sesiones);
		$this->session->sess_destroy();
		redirect(base_url('login'), 'refresh');
	}
}
