<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Logo {
	public $order;

	public function __construct() {
		parent::__construct();

		$this->load->model('orderModel');
		$this->order = new OrderModel;
		if(!isset($_SESSION['carrito'])){
			$_SESSION['carrito']=[];
		}
	}


	public function index()
	{
		$this->output->set_template('order');
		$this->load->js("public/js/pedidos/orders.js");
		$data = [];
		$data['productos'] = $this->order->getProductos();
		$data['categorias'] = $this->order->getCategorias();
		$this->load->view('orders/index',$data);
	}

	public function checkout(){
		$this->output->set_template('order');
		$this->load->css("public/css/single_styles.css");
		$this->load->css("public/css/single_responsive.css");
		$this->load->js("public/js/pedidos/orders.js");
		$this->load->js("public/js/pedidos/checkout.js");
		$data = [];
		$data['productos'] = $this->order->getCarrito($_SESSION['carrito']);
		$data['precio_delivery'] = $this->order->getPrecioDelivery();
		$this->load->view('orders/checkout',$data);
	}


	public function get($id) {
			echo json_encode($this->categorias->find_categoria($id));
	}

	public function getProduct($id) {
			$datos=$this->order->getProducto($id);
			$datos->atributos=$this->order->find_atributos($id);
			echo json_encode($datos);
	}

	public function getEmpresa() {
			echo json_encode($this->order->find_empresa());
	}

public function setCarrito(){

	$datos= array(
		'id_producto' => $_POST['id'],
		'cantidad' => $_POST['cantidad'],
		'nota' => $_POST['nota'],
		'precio' => $_POST['precio'],
	);

	if(isset($_POST['atributo'])){
		$datos['atributos']=$_POST['atributo'];
	}else{
		$datos['atributos']=[];
	}

	array_push($_SESSION['carrito'], $datos );

	$response = [];
	$response["productos_carrito"]=[];
	$response["error"] = true;
	$response["productos_carrito"]=$this->order->getCarrito($_SESSION['carrito']);
	$response["carrito"]=sizeof($_SESSION['carrito']);
	echo json_encode($response);
}

public function delProCar(){
	$id=$_POST['id'];
	array_splice($_SESSION['carrito'], $id, 1);
	$response = [];
	$response["error"] = true;
	echo json_encode($response);
}

public function guardarPedido() {

	$total=0;
	foreach ($_SESSION['carrito'] as $producto) {
		$total+=$producto['cantidad'] * $producto['precio'];
	}
	$_POST['total']=$total;

	$res = $this->order->insert_pedido();
	$last = $this->db->order_by('id',"desc")->limit(1)->get('pedido')->row_array();
	if($res){
		$this->setDetallePedido($_SESSION['carrito'], $last['id']);
	}

	$cel=$this->order->getCelular();
	$_SESSION['carrito']=[];
	$response = [];
	$response["tel"] = $cel->telefono;
	echo json_encode($response);
}

public function editarPedido() {

	$total=0;
	foreach ($_SESSION['carrito'] as $producto) {
		$total+=$producto['cantidad'] * $producto['precio'];
	}
	$_POST['total']=$total;

	$id = $this->input->post("id");
	$res = $this->order->edit_pedido($id);
	if($res){
		$this->order->quitar_detallePedido($id);
		$this->setDetallePedido($_SESSION['carrito'], $id);
	}

	$_SESSION['carrito']=[];
	$response = [];
	$response["error"] = true;
	echo json_encode($response);
}

private function setDetallePedido($datos, $id){
	if($datos){
		foreach ($datos as $detalle) {
			$this->order->insertar_detallePedido($detalle, $id);
		}
	}
}

	public function delete($id) {
		$response = [];
		$response["error"] = !$this->categorias->delete_categoria($id);
		echo json_encode($response);
	}
}
