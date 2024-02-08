<?php


class OrderModel extends CI_Model {

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

	public function find_categoria($id) {
		return $this->db->get_where('categoria', ['id' => $id])->row();
	}

	public function getPrecioDelivery() {
		$q = $this->db->get_where('empresa', ['id' => 1])->row();
		return $q->precio_delivery;
	}

	public function find_empresa() {
		return $this->db->get_where('empresa', ['id' => 1])->row();
	}


	public function getProductos() {
		$q = $this->db->query("select p.id, p.nombre, p.precio, p.descripcion, p.imagen,
		(select GROUP_CONCAT(c.class SEPARATOR ' ') from categoria c inner join producto_categoria pc on c.id=pc.id_categoria
		where pc.id_producto=p.id) as categorias
		from producto p where p.estado=1 order by orden asc"
		);

		return $q->result();
	}


	public function getCategorias() {
		$this->db->select('*');
				$this->db->from('categoria');
				$this->db->where('estado=1');
				$this->db->order_by('orden','asc');
				$q = $this->db->get();

		return $q->result();
	}



public function getCarrito($productos){
	$pro=[];
	foreach ($productos as $producto) {
		$dat=$this->db->get_where('producto', ['id' => $producto['id_producto']])->row();
		$dat->cantidad=$producto['cantidad'];
		$dat->nota=$producto['nota'];
		$dat->atributos=$producto['atributos'];
		array_push($pro, $dat);
	}
	return $pro;
}

public function insert_pedido(){

	if($this->input->post('efectivo') == "0"){
		$_POST['efectivo']= $this->input->post('total') + $this->getPrecioDelivery();
	}

	$data = [
		'cliente'    => $this->input->post('cliente'),
		'telefono'    => $this->input->post('telefono'),
		'direccion'    => $this->input->post('direccion'),
		'metodo_pago'    => $this->input->post('pago'),
		'referencia'    => $this->input->post('referencia'),
		'delivery'    => $this->getPrecioDelivery(),
		'total'    => ($this->input->post('total') + $this->getPrecioDelivery()),
		'efectivo'    => $this->input->post('efectivo'),
		'hora_entrega'    => $this->input->post('fecha_entrega').' '.$this->input->post('hora_entrega'),
	];
	return $this->db->insert('pedido', $data);
}


public function edit_pedido($id) {

	if($this->input->post('efectivo') == "0"){
		$_POST['efectivo']= $this->input->post('total') + $this->getPrecioDelivery();
	}

	$data = [
		'cliente'    => $this->input->post('cliente'),
		'telefono'    => $this->input->post('telefono'),
		'direccion'    => $this->input->post('direccion'),
		'metodo_pago'    => $this->input->post('pago'),
		'referencia'    => $this->input->post('referencia'),
		'delivery'    => $this->getPrecioDelivery(),
		'total'    => ($this->input->post('total') + $this->getPrecioDelivery()),
		'efectivo'    => $this->input->post('efectivo'),
		'hora_entrega'    => $this->input->post('fecha_entrega').' '.$this->input->post('hora_entrega'),
	];

			$this->db->where('id', $id);
			return $this->db->update('pedido', $data);

}

public function insertar_detallePedido($datos, $pedido){
	$data = [
		'id_pedido'    => $pedido,
		'id_producto'    => $datos['id_producto'],
		'precio'    => $datos['precio'],
		'cantidad'    => $datos['cantidad'],
		'detalles'    => $datos['nota'],
		'atributos'    => implode( ",", $datos['atributos']),
	];
	return $this->db->insert('producto_pedido', $data);
}

public function quitar_detallePedido($pedido){
		$this->db->where('id_pedido', $pedido);
		return $this->db->delete('producto_pedido');
}

public function getCelular(){
	return $this->db->get_where('empresa', ['id' => 1])->row();
}


	public function getProducto($id) {
		return $this->db->get_where('producto', ['id' => $id])->row();
	}

	public function find_atributos($id) {
		$this->db->select('d.id_atributo, a.titulo, a.variables');
				$this->db->from('producto_atributo d');
				$this->db->join('atributo a','d.id_atributo=a.id');
				$this->db->where('d.id_producto = '.$id);
				$q = $this->db->get();
				return $q->result();
	}

	public function get_tipoDocumentoCliente(){
		$q=$this->db->query("SELECT DISTINCT id_tipo_documento, descripcion FROM documento  inner join tipo_documento on tipo_documento.id=documento.id_tipo_documento where documento.estado=1 and documento.id_usuario='" . $this->session->userdata('usuarioID') . "'");
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

	public function delete_categoria($id) {
		$data = ['estado' => 0];

		$this->db->where('id', $id);
		return $this->db->update('categoria', $data);
	}


}
