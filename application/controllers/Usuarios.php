<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MY_Controller {

	public $usuarios;

	public function __construct() {
		parent::__construct();

		$this->load->model('usuariosModel');
		$this->usuarios = new UsuariosModel;
	}


	public function index() {
		$this->output->set_template('index');
    $this->load->css("public/css/jquery.dataTables.min.css");
		$this->load->js("public/js/jquery.dataTables.min.js");
		$this->load->js("public/js/pedidos/usuarios.js");
		$data = [];
		$data['grilla'] = $this->grid();
		$this->load->view('usuarios/index', $data);
	}


	public function misClientes() {
		$this->output->set_template('index');
		$this->load->css("public/css/jquery.dataTables.min.css");
		$this->load->js("public/js/data-table/jquery.dataTables.min.js");
		$this->load->js("public/js/archivos/usuario.js");
		$data = [];
		$data['grilla'] = $this->grid();
		$this->load->view('usuarios/clientes',$data);
	}


	public function get($id) {
		echo json_encode($this->usuarios->find_usuario($id));
	}

	public function getTipoUsuarios() {
		echo json_encode($this->usuarios->getTipoUsuarios());
	}


	private function grid() {
		$this->load->library('datatable');
		$this->datatable->setTabla('tablaUsuarios');
		$this->datatable->setNroItem(true);
		$this->datatable->setAttrib('ajax', ['url' => base_url('usuarios/listaGrid')]);
		$this->datatable->setAttrib('language', ['url' => base_url("public/js/spanish.json")]);
		$this->datatable->setAttrib('select', true);
		$this->datatable->setAttrib('dom', 'frtip');
		$this->datatable->setAttrib('processing', false);
		$this->datatable->setAttrib('serverSide', true);
		$this->datatable->setAttrib('responsive', false);
		$this->datatable->setAttrib('order', [[1, 'desc']]);
		$this->datatable->setAttrib('columns', [
			['title' => 'Nombre', 'data' => "nombre", 'name' => "nombre"],
			['title' => 'Usuario', 'data' => "usuario", 'name' => "usuario"],
			['title' => 'Teléfono', 'data' => "telefono", 'name' => "telefono"],
			['title' => 'Email', 'data' => "email", 'name' => "email"],
		]);
		return $this->datatable->getJsGrid();
	}

	public function listaGrid() {
		$this->load->library('datatabledb');
		$this->datatabledb->setColumnaId('id');
		$this->datatabledb->setSelect("nombre, telefono, email, usuario");
		$this->datatabledb->setFrom("usuario");
		$this->datatabledb->setWhere("estado", 1);
		$this->datatabledb->setParams($_GET);
		echo $this->datatabledb->getJson();
	}

	public function store() {
		$this->form_validation->set_rules('nombre', 'nombre', 'required');
    $this->form_validation->set_rules('email', 'email', 'required');
		$this->form_validation->set_rules('usuario', 'usuario', 'required');
		try {
			if ($this->form_validation->run() === FALSE) {
				throw new \Exception(validation_errors());
			}
			$response = [];
			$id = $this->input->post("id");
			if ($id === "") {
				$res = $this->usuarios->insert_usuario();
			} else {
				$res = $this->usuarios->update_usuario($id);
			}
			$response["error"] = $res;
			echo json_encode($response);
		} catch (\Exception $e) {
			echo json_encode(["error" => true, "message" => $e->getMessage()]);
		}
	}

	public function delete($id) {
		$response = [];
		$response["error"] = !$this->usuarios->delete_usuario($id);
		echo json_encode($response);
	}

}
