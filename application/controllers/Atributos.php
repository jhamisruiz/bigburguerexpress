<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atributos extends MY_Controller {
	public $atributos;

	public function __construct() {
		parent::__construct();

		$this->load->model('atributosModel');
		$this->atributos = new AtributosModel;
	}


	public function index(){
		$this->output->set_template('index');
		$this->load->css("public/css/jquery.dataTables.min.css");
		$this->load->js("public/js/jquery.dataTables.min.js");
		$this->load->js("public/js/pedidos/atributos.js");
		$data = [];
		$data['grilla'] = $this->grid();
		$this->load->view('atributos/index',$data);

	}


	public function get($id) {
			echo json_encode($this->atributos->find_atributo($id));
	}

	public function getAtributos() {
			echo json_encode($this->atributos->getAtributos());
	}

	private function grid() {
		$this->load->library('datatable');
		$this->datatable->setTabla('tablaAtributos');
		$this->datatable->setNroItem(true);
		$this->datatable->setAttrib('ajax', ['url' => base_url('atributos/listaGrid')]);
		$this->datatable->setAttrib('language', ['url' => base_url("public/js/spanish.json")]);
		$this->datatable->setAttrib('select', true);
    $this->datatable->setAttrib('dom', 'frtip');
		$this->datatable->setAttrib('processing', false);
		$this->datatable->setAttrib('serverSide', true);
		$this->datatable->setAttrib('responsive', false);
		$this->datatable->setAttrib('order', [[1, 'desc']]);
		$this->datatable->setAttrib('columns', [
			['title' => 'Título', 'data' => "titulo", 'name' => "titulo"],
      ['title' => 'Variables', 'data' => "variables", 'name' => "variables"],
		]);
		return $this->datatable->getJsGrid();
	}

	public function listaGrid() {
		$this->load->library('datatabledb');
		$this->datatabledb->setColumnaId('id');
		$this->datatabledb->setSelect("titulo, variables");
		$this->datatabledb->setFrom("atributo");
		$this->datatabledb->setWhere("estado",1);
		$this->datatabledb->setOrder("id desc");
		$this->datatabledb->setParams($_GET);
		echo $this->datatabledb->getJson();
	}

	public function store() {
    $this->form_validation->set_rules('titulo', 'titulo', 'required');
    $this->form_validation->set_rules('ats', 'ats', 'required');

		try {
			if ($this->form_validation->run() === FALSE) {
				throw new \Exception(validation_errors());
			}
			$response = [];
			$id = $this->input->post("id");
			if ($id === "") {
				$res = $this->atributos->insert_atributos();
			} else {
				$res = $this->atributos->update_atributos($id);
			}
			$response["error"] = $res;
			echo json_encode($response);
		} catch (\Exception $e) {
			echo json_encode(["error" => true, "message" => $e->getMessage()]);
		}
	}

	public function delete($id) {
		$response = [];
		$response["error"] = !$this->atributos->delete_atributo($id);
		echo json_encode($response);
	}
}
