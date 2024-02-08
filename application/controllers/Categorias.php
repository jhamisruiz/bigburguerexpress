<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends MY_Controller {
	public $categorias;

	public function __construct() {
		parent::__construct();

		$this->load->model('categoriasModel');
		$this->categorias = new CategoriasModel;
	}


	public function index()
	{
		$this->output->set_template('index');
		$this->load->css("public/css/jquery.dataTables.min.css");
		$this->load->js("public/js/jquery.dataTables.min.js");
		$this->load->js("public/js/pedidos/categorias.js");
		$data = [];
		$data['grilla'] = $this->grid();
		$this->load->view('categorias/index',$data);

	}


	public function get($id) {
			echo json_encode($this->categorias->find_categoria($id));
	}



	public function getCategorias() {
			echo json_encode($this->categorias->getCategorias());
	}

	private function grid() {
		$this->load->library('datatable');
		$this->datatable->setTabla('tablaCategorias');
		$this->datatable->setNroItem(true);
		$this->datatable->setAttrib('ajax', ['url' => base_url('categorias/listaGrid')]);
		$this->datatable->setAttrib('language', ['url' => base_url("public/js/spanish.json")]);
		$this->datatable->setAttrib('select', true);
        $this->datatable->setAttrib('dom', 'frtip');
		$this->datatable->setAttrib('processing', false);
		$this->datatable->setAttrib('serverSide', true);
		$this->datatable->setAttrib('responsive', false);
		$this->datatable->setAttrib('order', [[2, 'asc']]);
		$this->datatable->setAttrib('columns', [
			['title' => 'Descripción', 'data' => "descripcion", 'name' => "descripcion"],
			['title' => 'N° Orden', 'data' => "orden", 'name' => "orden"],
		]);
		return $this->datatable->getJsGrid();
	}

	public function listaGrid() {
		$this->load->library('datatabledb');
		$this->datatabledb->setColumnaId('id');
		$this->datatabledb->setSelect("descripcion, orden");
		$this->datatabledb->setFrom("categoria");
		$this->datatabledb->setWhere("estado",1);
		//$this->datatabledb->setOrder("orden asc");
		$this->datatabledb->setParams($_GET);
		echo $this->datatabledb->getJson();
	}

	public function store() {
		$this->form_validation->set_rules('descripcion', 'descripcion', 'required');
		try {
			if ($this->form_validation->run() === FALSE) {
				throw new \Exception(validation_errors());
			}
			$response = [];
			$id = $this->input->post("id");
			if ($id === "") {
				$res = $this->categorias->insert_categoria();
			} else {
				$res = $this->categorias->update_categoria($id);
			}
			$response["error"] = $res;
			echo json_encode($response);
		} catch (\Exception $e) {
			echo json_encode(["error" => true, "message" => $e->getMessage()]);
		}
	}

	public function delete($id) {
		$response = [];
		$response["error"] = !$this->categorias->delete_categoria($id);
		echo json_encode($response);
	}
}
