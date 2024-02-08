<?php


class ProductosModel extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}



	public function insert_producto() {

			$data = [
				'nombre'    => $this->input->post('nombre'),
				'precio'    => $this->input->post('precio'),
				'descripcion'    => $this->input->post('descripcion'),
				'imagen'    => $this->input->post('imagen'),
				'orden'    => $this->input->post('orden'),
			];
			return $this->db->insert('producto', $data);

	}

	public function insertar_atributos($atributo, $producto){
		$data = [
			'id_producto'    => $producto,
      'id_atributo'    => $atributo,
		];
		return $this->db->insert('producto_atributo', $data);
	}

	public function insertar_categories($categorie, $producto){
		$data = [
			'id_producto'    => $producto,
			'id_categoria'    => $categorie,
		];
		return $this->db->insert('producto_categoria', $data);
	}

	public function quitar_atributos($producto){
		$this->db->where('id_producto', $producto);
		return $this->db->delete('producto_atributo');
	}

	public function quitar_categories($producto){
		$this->db->where('id_producto', $producto);
		return $this->db->delete('producto_categoria');
	}

	public function find_producto($id) {
		return $this->db->get_where('producto', ['id' => $id])->row();
	}

	public function find_atributos($id) {
		$this->db->select('*');
				$this->db->from('producto_atributo');
				$this->db->where('id_producto = '.$id);
				$q = $this->db->get();
				return $q->result();
	}

	public function find_categories($id) {
		$this->db->select('*');
				$this->db->from('producto_categoria');
				$this->db->where('id_producto = '.$id);
				$q = $this->db->get();
				return $q->result();
	}



public function validar($orden, $id=null){
	$this->db->select('orden');
	$this->db->from('producto');
	if($id==null){
			$this->db->where('orden ='.$orden);
	}else{
			$this->db->where('orden ='.$orden.' and id !='.$id);
	}
	$query = $this->db->get();
	return $query->num_rows();
}

	public function update_producto($id) {

				$data = [
					'nombre'    => $this->input->post('nombre'),
					'precio'    => $this->input->post('precio'),
					'descripcion'    => $this->input->post('descripcion'),
					'orden'    => $this->input->post('orden'),
				];

				if($this->input->post('imagen') != ""){
						$data['imagen'] = $this->input->post('imagen');
				}

				if ($id == 0) {
						return $this->db->insert('producto', $data);
				} else {
						$this->db->where('id', $id);
						return $this->db->update('producto', $data);
				}

	}

	public function delete_producto($id) {
		$data = ['estado' => 0];

		$this->db->where('id', $id);
		return $this->db->update('producto', $data);
	}

	public function getCategorias() {
		$this->db->select('*');
				$this->db->from('categoria');
				$this->db->where('estado=1');
				$q = $this->db->get();

		return $q->result();
	}

	public function getAtributos() {
		$this->db->select('*');
				$this->db->from('atributo');
				$this->db->where('estado=1');
				$q = $this->db->get();

		return $q->result();
	}


}
