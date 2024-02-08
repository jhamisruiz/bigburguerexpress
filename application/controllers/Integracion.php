<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Integracion extends CI_Controller {
	public $ntegracion;

	public function __construct() {
		parent::__construct();

		$this->load->model('pedidosModel');
		$this->pedidos = new PedidosModel;
		$this->load->model('orderModel');
		$this->order = new OrderModel;

	}


	public function add() {

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $datos = json_decode(file_get_contents("php://input"), true);

		$data = [
			'nombre'    => $datos['name'],
			'telefono'    => $datos['phone'],
		];

		$res['estado']=$this->db->insert('integracion', $data);

    if($res['estado']==1){
      $res['mensaje']="Insertado correctamente";
    }else{
      $res['mensaje']="Mo se pudo insertar";
    }

    echo json_encode($res);
	}


}
