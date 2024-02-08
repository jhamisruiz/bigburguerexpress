<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Motorizados extends MY_Controller {
	public $motorizados;

	public function __construct() {
		parent::__construct();

		$this->load->model('motorizadosModel');
		$this->motorizados = new MotorizadosModel;
	}


	public function index()
	{
		$this->output->set_template('index');
		$this->load->css("public/css/jquery.dataTables.min.css");
		$this->load->js("public/js/jquery.dataTables.min.js");
		$this->load->js("public/js/pedidos/motorizados.js");
		$data = [];
		$data['grilla'] = $this->grid();
		$this->load->view('motorizados/index',$data);

	}


	public function get($id) {
			echo json_encode($this->motorizados->find_motorizado($id));
	}

	public function getMotorizados() {
			echo json_encode($this->motorizados->getMotorizados());
	}


	private function grid() {
		$this->load->library('datatable');
		$this->datatable->setTabla('tablaMotorizados');
		$this->datatable->setNroItem(true);
		$this->datatable->setAttrib('ajax', ['url' => base_url('motorizados/listaGrid')]);
		$this->datatable->setAttrib('language', ['url' => base_url("public/js/spanish.json")]);
		$this->datatable->setAttrib('select', true);
    $this->datatable->setAttrib('dom', 'frtip');
		$this->datatable->setAttrib('processing', false);
		$this->datatable->setAttrib('serverSide', true);
		$this->datatable->setAttrib('responsive', false);
		$this->datatable->setAttrib('order', [[1, 'asc']]);
		$this->datatable->setAttrib('columns', [
			['title' => 'Nombre', 'data' => "nombre", 'name' => "nombre"],
		]);
		return $this->datatable->getJsGrid();
	}

	public function listaGrid() {
		$this->load->library('datatabledb');
		$this->datatabledb->setColumnaId('id');
		$this->datatabledb->setSelect("nombre");
		$this->datatabledb->setFrom("motorizado");
		$this->datatabledb->setWhere("estado",1);
		$this->datatabledb->setParams($_GET);
		echo $this->datatabledb->getJson();
	}

	public function store() {
		$this->form_validation->set_rules('nombre', 'nombre', 'required');
		try {
			if ($this->form_validation->run() === FALSE) {
				throw new \Exception(validation_errors());
			}
			$response = [];
			$id = $this->input->post("id");
			if ($id === "") {
				$res = $this->motorizados->insert_motorizado();
			} else {
				$res = $this->motorizados->update_motorizado($id);
			}
			$response["error"] = $res;
			echo json_encode($response);
		} catch (\Exception $e) {
			echo json_encode(["error" => true, "message" => $e->getMessage()]);
		}
	}

	public function delete($id) {
		$response = [];
		$response["error"] = !$this->motorizados->delete_motorizado($id);
		echo json_encode($response);
	}
}
