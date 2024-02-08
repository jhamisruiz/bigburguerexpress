<?php


class PedidosModel extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}


	public function insert_categoria() {
		$data = [
			'descripcion'    => $this->input->post('descripcion'),
		];
		return $this->db->insert('categoria', $data);
	}

	public function find_pedido($id) {
		$this->db->select('p.*, m.nombre, c.descripcion as condicion');
				$this->db->from('pedido p');
				$this->db->join('motorizado m','p.motorizado = m.id','left');
				$this->db->join('condicion c','p.condicion = c.id','inner');
				$this->db->where('p.id='.$id);
				$q = $this->db->get();

		return $q->row();
	}

	public function find_pedidoPrint($id){
		$this->db->select('p.*, DATE_FORMAT(p.hora_entrega, "%d-%m-%Y %H:%i") as fecha_entrega, DATE_FORMAT(p.fecha, "%d-%m-%Y %H:%i") as fecha_pedido, m.nombre');
				$this->db->from('pedido p');
				$this->db->join('motorizado m','p.motorizado = m.id','left');
				$this->db->where('p.id='.$id);
				$q = $this->db->get();

		return $q->row();
	}

	public function getEstado($id) {
		$this->db->select('id, condicion, motorizado');
				$this->db->from('pedido');
				$this->db->where('id='.$id);
				$q = $this->db->get();

		return $q->row();
	}

	public function getPedidoEdit($id){
		$this->db->select('id, cliente, telefono, direccion, metodo_pago, referencia, total, efectivo, condicion, delivery, motorizado, DATE_FORMAT(hora_entrega, "%Y-%m-%d") as fecha_entrega, DATE_FORMAT(hora_entrega, "%H:%i") as hora_entrega');
				$this->db->from('pedido');
				$this->db->where('id='.$id);
				$q = $this->db->get();

		return $q->row();
	}

	public function getAllProducts(){
		$this->db->select('*');
		$this->db->from('producto');
		$this->db->where('estado=1');
		$q = $this->db->get();

		return $q->result();
	}

	public function getProductos($id){
		$this->db->select('pp.cantidad, pp.precio, p.nombre, pp.detalles, pp.atributos');
		$this->db->from('producto_pedido pp');
		$this->db->join('producto p','pp.id_producto = p.id','inner');
		$this->db->where('pp.estado=1 and pp.id_pedido='.$id);
		$q = $this->db->get();

		return $q->result();
	}


	public function getCategorias() {
		$this->db->select('*');
				$this->db->from('categoria');
				$this->db->where('estado=1');
				$q = $this->db->get();

		return $q->result();
	}


	public function update_categoria($id) {
		$data = [
			'descripcion'    => $this->input->post('descripcion'),
		];

		if ($id == 0) {
			return $this->db->insert('categoria', $data);
		} else {
			$this->db->where('id', $id);
			return $this->db->update('categoria', $data);
		}
	}


	public function modificar_pedido($id) {
		$data = ['condicion' => $this->input->post("condicion") ];

		 if($this->input->post("motorizado") != "0"){
			 $data['motorizado'] = $this->input->post("motorizado");
		 }

		$this->db->where('id', $id);
		return $this->db->update('pedido', $data);
	}

	public function delete_pedidos($id) {
		$data = ['estado' => 0];

		$this->db->where('id', $id);
		return $this->db->update('pedido', $data);
	}


}
