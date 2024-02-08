<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends MY_Controller {
	public $productos;

	public function __construct() {
		parent::__construct();

		$this->load->model('productosModel');
		$this->productos = new ProductosModel;
	}


	public function index(){
		$this->output->set_template('index');
		$this->load->css("public/css/jquery.dataTables.min.css");
		$this->load->js("public/js/jquery.dataTables.min.js");
		$this->load->js("public/js/pedidos/productos.js");
		$this->load->css("public/plugins/multiselect/css/multi-select.css");
		$this->load->js("public/plugins/multiselect/js/jquery.multi-select.js");
		$data = [];
		$data['grilla'] = $this->grid();
		$data['categorias'] = $this->productos->getCategorias();
		$data['atributos'] = $this->productos->getAtributos();
		$this->load->view('productos/index',$data);

	}


	public function get($id) {
			$datos=$this->productos->find_producto($id);
			$datos->atributos=$this->productos->find_atributos($id);
			$datos->categories=$this->productos->find_categories($id);
			echo json_encode($datos);
	}

	private function grid() {
		$this->load->library('datatable');
		$this->datatable->setTabla('tablaProductos');
		$this->datatable->setNroItem(true);
		$this->datatable->setAttrib('ajax', ['url' => base_url('productos/listaGrid')]);
		$this->datatable->setAttrib('language', ['url' => base_url("public/js/spanish.json")]);
		$this->datatable->setAttrib('select', true);
    $this->datatable->setAttrib('dom', 'frtip');
		$this->datatable->setAttrib('processing', false);
		$this->datatable->setAttrib('serverSide', true);
		$this->datatable->setAttrib('responsive', false);
		$this->datatable->setAttrib('order', [[5, 'asc']]);
		$this->datatable->setAttrib('columns', [
			['title' => 'Nombre', 'data' => "nombre", 'name' => "nombre"],
      ['title' => 'Precio', 'data' => "precio", 'name' => "precio"],
      ['title' => 'Descripcion', 'data' => "des", 'name' => "des"],
      ['title' => 'Categorias', 'data' => "categorias", 'name' => "categorias"],
			['title' => 'N° Orden', 'data' => "orden", 'name' => "orden"],
		]);
		return $this->datatable->getJsGrid();
	}


	public function listaGrid() {
		$this->load->library('datatabledb');
		$this->datatabledb->setColumnaId('id');
		$this->datatabledb->setSelect("nombre, precio, des, categorias, orden");
		$this->datatabledb->setFrom("vw_producto");
		$this->datatabledb->setWhere("estado",1);
		//$this->datatabledb->setOrder("orden asc");
		$this->datatabledb->setParams($_GET);
		echo $this->datatabledb->getJson();
	}

	public function store() {
		$this->form_validation->set_rules('nombre', 'nombre', 'required');
    $this->form_validation->set_rules('precio', 'precio', 'required');
		try {
			if ($this->form_validation->run() === FALSE) {
				throw new \Exception(validation_errors());
			}

			//Uploading image
			$data = [];
			$_POST['imagen']="";
			$config['upload_path'] = 'public/uploads/productos/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = '100000'; // max_size in kb
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);

			$hasError = FALSE;
				if (!empty($_FILES['archivo']['name'])) {
					$_FILES['file']['name'] = $_FILES['archivo']['name'];
					$_FILES['file']['type'] = $_FILES['archivo']['type'];
					$_FILES['file']['tmp_name'] = $_FILES['archivo']['tmp_name'];
					$_FILES['file']['error'] = $_FILES['archivo']['error'];
					$_FILES['file']['size'] = $_FILES['archivo']['size'];

					$this->upload->initialize($config);
					if ($this->upload->do_upload('file')) {
						$uploadData = $this->upload->data();
						$data['path'][] = $uploadData['file_name'];
					} else {
						$hasError = TRUE;
					}
				}
			if ($hasError) {
				if (count($data) > 0) {
					foreach ($data["path"] as $k) {
						unlink("public/uploads/productos/" . $k);//delete uploaded files beacuase an error
					}
				}
				throw new \Exception("Hubo un error en subida de archivos.");
			}
			if(isset($data["path"])){
				foreach ($data["path"] as $j => $k) {
					$_POST['imagen']=$data["path"][$j];
				}
			}

			$response = [];
			$id = $this->input->post("id");
			$val= $this->productos->validar($_POST['orden'], $id);
			if($val != 0){
				$response["error"] = 3;
				echo json_encode($response);
				die();
			}

			if ($id === "") {
				$res = $this->productos->insert_producto();
				$last = $this->db->order_by('id',"desc")->limit(1)->get('producto')->row_array();
				if($res){
					$this->setCategories($this->input->post('id_categoria'), $last['id']);

					$this->setAtributes($this->input->post('selectAtributos'), $last['id']);
				}
			} else {
					$res = $this->productos->update_producto($id);
					$this->setCategories($this->input->post('id_categoria'), $id);
					$this->setAtributes($this->input->post('selectAtributos'), $id);
			}

			$response["error"] = $res;
			echo json_encode($response);
		} catch (\Exception $e) {
			echo json_encode(["error" => true, "message" => $e->getMessage()]);
		}
	}

	private function setCategories($datos, $id){
		$this->productos->quitar_categories($id);
		if($datos){
			foreach ($datos as $categorie) {
				$this->productos->insertar_categories($categorie, $id);
			}
		}
	}


	private function setAtributes($datos, $id){
		$this->productos->quitar_atributos($id);
		if($datos){
			foreach ($datos as $atributo) {
				$this->productos->insertar_atributos($atributo, $id);
			}
		}
	}

	public function delete($id) {
		$response = [];
		$response["error"] = !$this->productos->delete_producto($id);
		echo json_encode($response);
	}
}
