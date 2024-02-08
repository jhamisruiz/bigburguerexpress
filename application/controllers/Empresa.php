<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends MY_Controller {
	public $empresa;

	public function __construct() {
		parent::__construct();

		$this->load->model('empresaModel');
		$this->empresa = new EmpresaModel;
	}


	public function index(){
		$this->output->set_template('index');
		$this->load->css("public/css/jquery.dataTables.min.css");
		$this->load->js("public/js/jquery.dataTables.min.js");
		$this->load->js("public/js/pedidos/empresa.js");
		$this->load->view('empresa/index');
	}


	public function getEmpresa() {
			echo json_encode($this->empresa->find_empresa());
	}

	public function store() {
		$this->form_validation->set_rules('nombre', 'nombre', 'required');
		try {
			if ($this->form_validation->run() === FALSE) {
				throw new \Exception(validation_errors());
			}

			//Uploading image
			$data = [];
			$_POST['imagen']="";
			$config['upload_path'] = 'public/uploads/logo/';
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
						unlink("public/uploads/logo/" . $k);//delete uploaded files beacuase an error
					}
				}
				throw new \Exception("Hubo un error en subida de archivos.");
			}
			//var_dump($data);
			if(isset($data["path"])){
				foreach ($data["path"] as $j => $k) {
					$_POST['imagen']=$data["path"][$j];
				}
			}

			$response = [];
			$res = $this->empresa->update_empresa();
			$response["error"] = $res;

			//actualizar datos en la session
				$this->db->select('logo, precio_delivery, DATE_FORMAT(hora_entrada, "%H:%i")  as hora_entrada, DATE_FORMAT(hora_salida, "%H:%i")  as hora_salida');
				$this->db->from('empresa');
				$this->db->where('id=1');
				$empresa = $this->db->get()->row();
				$this->session->set_userdata('logo_filename', $empresa->logo);
				$this->session->set_userdata('horario_entrada', $empresa->hora_entrada);
				$this->session->set_userdata('horario_salida', $empresa->hora_salida);
				$this->session->set_userdata('precio_delivery', $empresa->precio_delivery);
		//--------------

			echo json_encode($response);
		} catch (\Exception $e) {
			echo json_encode(["error" => true, "message" => $e->getMessage()]);
		}
	}



}
