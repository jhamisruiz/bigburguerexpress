<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends MY_Controller {
	public $reportes;

	public function __construct() {
		parent::__construct();

		$this->load->model('reportesModel');
		$this->reportes = new ReportesModel;
	}


	public function index()
	{
		$this->output->set_template('index');
		$this->load->css("public/css/jquery.dataTables.min.css");
		$this->load->js("public/js/jquery.dataTables.min.js");
		$this->load->js("public/js/pedidos/reportes.js");
		$this->load->js("public/js/pedidos/sum.js");
		$data = [];
		$data['grilla'] = $this->grid(1);
		$this->load->view('reportes/index',$data);

	}

  public function reportes_mensuales()
  {
    $this->output->set_template('index');
    $this->load->css("public/css/jquery.dataTables.min.css");
    $this->load->js("public/js/jquery.dataTables.min.js");
    $this->load->js("public/js/pedidos/reportes_mensuales.js");
    $data = [];
    $data['grilla'] = $this->grid(2);
    $this->load->view('reportes/ventas_mensuales',$data);
  }

	public function reporte_anual()
  {
    $this->output->set_template('index');
    $this->load->css("public/css/jquery.dataTables.min.css");
    $this->load->js("public/js/jquery.dataTables.min.js");
    $this->load->js("public/js/pedidos/reporte_anual.js");
    $data = [];
    $data['grilla'] = $this->grid(3);
    $this->load->view('reportes/ventas_anuales',$data);
  }



	public function get($id) {
			echo json_encode($this->reportes->find_categoria($id));
	}



	public function getCategorias() {
			echo json_encode($this->reportes->getCategorias());
	}

  private function grid($format) {
		if($format==1){$f="%d-%m-%Y";}
		if($format==2){$f="%m-%Y";}
		if($format==3){$f="%Y";}
		$this->load->library('datatable');
		$this->datatable->setTabla('tablaReportes');
		$this->datatable->setNroItem(true);
		$this->datatable->setAttrib('ajax', ['url' => base_url('reportes/listaGrid/'.$format)]);
		$this->datatable->setAttrib('language', ['url' => base_url("public/js/spanish.json")]);
		$this->datatable->setAttrib('select', true);
    $this->datatable->setAttrib('dom', 'frtip');
		$this->datatable->setAttrib('processing', false);
		$this->datatable->setAttrib('serverSide', true);
		$this->datatable->setAttrib('responsive', false);
		$this->datatable->setAttrib('lengthMenu', [[30,50,100,-1], [30,50,100,"Todos"]]);
		$this->datatable->setAttrib('order', [[1, 'desc']]);
		$this->datatable->setAttrib('columns', [
			['title' => 'Fecha', 'data' => "fecha", 'name' => "fecha"],
      ['title' => 'Pedidos entregados', 'data' => "pedidos_entregados", 'name' => ""],
      ['title' => 'Pedidos en proceso', 'data' => "pedidos_proceso", 'name' => ""],
      ['title' => 'Pedidos cancelados', 'data' => "pedidos_cancelados", 'name' => ""],
			['title' => 'Total de pedidos S/', 'data' => "total", 'name' => ""],
		]);
		return $this->datatable->getJsGrid();
	}


	public function listaGrid($format, $date_start = "", $date_end = "") {

		$date_cond = "";
    if($format==1){
			$f="%d-%m-%Y";
			if ($date_start !== "") {
				$date_start = date("Y-m-d", strtotime($date_start));
				$date_end = date("Y-m-d", strtotime($date_end));
				$date_cond = " and (DATE_FORMAT(fecha, '%Y-%m-%d')  between CAST('$date_start' as date) and CAST('$date_end' as date))";
			}
		}
		if($format==2){
			$f="%m-%Y";
			if ($date_start !== "") {
				$date_start = date("Y-m-01", strtotime($date_start . "-01"));
				$temp = explode("-", $date_end);
				$date_end = date("Y-m-" . cal_days_in_month(CAL_GREGORIAN, $temp[1], $temp[0]), strtotime($date_end . "-01"));
				$date_cond = " and (DATE_FORMAT(fecha, '%Y-%m-%d')  between CAST('$date_start' as date) and CAST('$date_end' as date))";
			}
		}
		if($format==3){$f="%Y";}
		$this->load->library('datatabledb');
		$this->datatabledb->setColumnaId('id');
		$this->datatabledb->setSelect("DATE_FORMAT(fecha, '".$f."') as fecha, sum( case when condicion = 2 then total else 0 end) as total, SUM( case when condicion = 0 then 1 else 0 end) as pedidos_cancelados, SUM( case when condicion = 2 then 1 else 0 end) as pedidos_entregados, SUM( case when condicion = 1 then 1 else 0 end) as pedidos_proceso");
		$this->datatabledb->setFrom("pedido");
		$this->datatabledb->setWhere("estado = 1 ".$date_cond);
    $this->datatabledb->setGroupBy("DATE_FORMAT(fecha, '".$f."')");
		$this->datatabledb->setOrder("id desc");
		$this->datatabledb->setParams($_GET);
		echo $this->datatabledb->getJson();
	}

	//		$this->datatabledb->setSelect("DATE_FORMAT(fecha, '".$f."') as fecha, SUM(total) as total, sum( case when condicion = 0 then total else 0 end) as pedidos_cancelados, sum( case when condicion = 2 then total else 0 end) as pedidos_entregados, sum( case when condicion = 1 then total else 0 end) as pedidos_proceso");


	public function store() {
		$this->form_validation->set_rules('descripcion', 'descripcion', 'required');
		try {
			if ($this->form_validation->run() === FALSE) {
				throw new \Exception(validation_errors());
			}
			$response = [];
			$id = $this->input->post("id");
			if ($id === "") {
				$res = $this->reportes->insert_categoria();
			} else {
				$res = $this->reportes->update_categoria($id);
			}
			$response["error"] = $res;
			echo json_encode($response);
		} catch (\Exception $e) {
			echo json_encode(["error" => true, "message" => $e->getMessage()]);
		}
	}

	public function delete($id) {
		$response = [];
		$response["error"] = !$this->reportes->delete_categoria($id);
		echo json_encode($response);
	}


	public function getSumDiario(){
		$inicio=$_POST['start'];
		$fin=$_POST['end'];

		if($_POST['end']!=null){
			$inicio = date("Y-m-d", strtotime($inicio));
			$fin = date("Y-m-d", strtotime($fin));
			$this->db->select('sum( case when condicion = 2 then total else 0 end) as totalPedidos');
			$this->db->from('pedido');
			$this->db->where("(DATE_FORMAT(fecha, '%Y-%m-%d') between CAST('$inicio' as date) and CAST('$fin' as date))");
			$q = $this->db->get()->result();
			echo json_encode($q[0]->totalPedidos);

		}else if($_POST['start']!=null){
			$this->db->select('sum( case when condicion = 2 then total else 0 end) as totalPedidos');
			$this->db->from('pedido');
			$this->db->where("DATE_FORMAT(fecha, '%Y-%m-%d') ='".$inicio."'");
			$q = $this->db->get()->result();
			echo json_encode($q[0]->totalPedidos);
		}else{
			$this->db->select('sum( case when condicion = 2 then total else 0 end) as totalPedidos');
			$this->db->from('pedido');
			$q = $this->db->get()->result();
			echo json_encode($q[0]->totalPedidos);
		}

	}

	public function getSumMensual(){
		$inicio=$_POST['start'];
		$fin=$_POST['end'];

		if($_POST['end']!=null){
			$inicio = date("Y-m-01", strtotime($inicio . "-01"));
			$temp = explode("-", $fin);
			$fin = date("Y-m-" . cal_days_in_month(CAL_GREGORIAN, $temp[1], $temp[0]), strtotime($fin . "-01"));

			$this->db->select('sum( case when condicion = 2 then total else 0 end) as totalPedidos');
			$this->db->from('pedido');
			$this->db->where("(DATE_FORMAT(fecha, '%Y-%m-%d') between CAST('$inicio' as date) and CAST('$fin' as date))");
			$q = $this->db->get()->result();
			echo json_encode($q[0]->totalPedidos);

		}else if($_POST['start']!=null){
			$this->db->select('sum( case when condicion = 2 then total else 0 end) as totalPedidos');
			$this->db->from('pedido');
			$this->db->where("DATE_FORMAT(fecha, '%Y-%m') ='".$inicio."'");
			$q = $this->db->get()->result();
			echo json_encode($q[0]->totalPedidos);
		}else{
			$this->db->select('sum( case when condicion = 2 then total else 0 end) as totalPedidos');
			$this->db->from('pedido');
			$q = $this->db->get()->result();
			echo json_encode($q[0]->totalPedidos);
		}

	}

}
