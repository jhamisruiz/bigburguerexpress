<?php

class Ticket extends MY_Controller {

  public $pedidos;

  public function __construct() {
    parent::__construct();

    $this->load->model('pedidosModel');
    $this->pedidos = new PedidosModel;
  }

	public function NotaPago($id) {

    $empresa = $this->db->get_where('empresa', ['id' => 1])->row();
    $datos = $this->pedidos->find_pedidoPrint($id);
    $productos = $this->pedidos->getProductos($id);

    //var_dump($productos);

    $logo= base_url()."public/uploads/logo/".$empresa->logo;

		$this->load->library("Fpdf");

    $pdf = new Fpdf($orientation='P',$unit='mm', array(45,250));
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);    //Letra Arial, negrita (Bold), tam. 20
    $textypos = 5;
    $pdf->Image($logo,14,2,15);
    $pdf->setY(18);
    $pdf->setX(2);
    $pdf->Cell(40,$textypos,utf8_decode($empresa->nombre),"",0,"C");
    $textypos += 5;
    $pdf->setX(2);
    $pdf->SetFont('Arial','B',5);
    $pdf->Cell(40,$textypos,utf8_decode($empresa->direccion),"",0,"C");
    $textypos += 5;
    $pdf->setX(2);
    $pdf->Cell(40,$textypos,$empresa->email,"",0,"C");
    $textypos += 5;
    $pdf->setX(2);
    $pdf->Cell(40,$textypos,$empresa->telefono,"",0,"C");
    $textypos += 10;
    $pdf->setX(2);
    $pdf->SetFont('Arial','',5);
    $pdf->Cell(5,$textypos,utf8_decode("N° pedido: ".sprintf("%04d", $datos->id)));
    $textypos += 5;
    $pdf->setX(2);
    $pdf->Cell(5,$textypos,"Fecha de pedido: ".$datos->fecha_pedido);
    $textypos += 5;
    $pdf->setX(2);
    $pdf->Cell(5,$textypos,utf8_decode("Cliente: ".$datos->cliente));
    $textypos += 5;
    $pdf->setX(2);
    $pdf->Cell(5,$textypos,utf8_decode("Teléfono: ".$datos->telefono));
    $textypos += 5;
    $pdf->setX(2);
    $pdf->Cell(5,$textypos,utf8_decode("Dirección: ".$datos->direccion));
    $textypos += 5;
    $pdf->setX(2);
    $pdf->Cell(5,$textypos,utf8_decode("Referencia: ".$datos->referencia));
    $textypos += 5;
    $pdf->setX(2);
    $pdf->Cell(5,$textypos,utf8_decode("Fecha de entrega: ".$datos->fecha_entrega));
    $textypos += 5;
    $pdf->setX(2);
    $pdf->Cell(5,$textypos,utf8_decode("Método de Pago: ".$datos->metodo_pago));
    $textypos += 5;
    $pdf->setX(2);
    $pdf->Cell(5,$textypos,utf8_decode("Motorizado: ".$datos->nombre));
    $pdf->SetFont('Arial','',5);    //Letra Arial, negrita (Bold), tam. 20
    $textypos+=6;
    $pdf->setX(2);
    $pdf->Cell(5,$textypos,'-------------------------------------------------------------------');
    $textypos+=6;
    $pdf->setX(2);
    $pdf->Cell(5,$textypos,'CANT.  PRODUCTO       PRECIO        SUBTOTAL');

    $total =0;
    $off = $textypos+6;


    foreach($productos as $pro){
    $esp=0;
    $pdf->SetFont('Arial','',5);
    $pdf->setX(3);
    $pdf->Cell(5,$off,$pro->cantidad);
    $pdf->setX(7);
    $pdf->Cell(35,$off, substr(utf8_decode($pro->nombre), 0,12) );
    $pdf->setX(20);
    $pdf->Cell(11,$off,  "S/ ".number_format($pro->precio,2,".",",") ,0,0,"R");
    $pdf->setX(32);
    $pdf->Cell(11,$off,  "S/ ".number_format($pro->cantidad * $pro->precio,2,".",",") ,0,0,"R");

    $pdf->SetFont('Arial','I',4);
    if($pro->atributos){
      $esp+=3;
      $pdf->setX(7);
      $pdf->Cell(35,$off+$esp,"(".$pro->atributos.")");
    }

    if($pro->detalles){
      $esp+=3;
      $pdf->setX(7);
      $pdf->Cell(35,$off+$esp,"Nota:".$pro->detalles);
    }

    $total += $pro->cantidad * $pro->precio;
    $off+=11;
    }
    $textypos=$off+2;

    $pdf->setX(2);
    $pdf->Cell(5,$textypos,"Delivery: " );
    $pdf->setX(38);
    $pdf->Cell(5,$textypos,"S/ ".number_format($empresa->precio_delivery,2,".",","),0,0,"R");
    $textypos+=5;
    $pdf->setX(2);
    $pdf->Cell(5,$textypos,"TOTAL: " );
    $pdf->setX(38);
    $pdf->Cell(5,$textypos,"S/ ".number_format($datos->total,2,".",","),0,0,"R");
    $textypos+=8;
    $pdf->setX(2);
    if($datos->metodo_pago == 'Efectivo'){
            $pdf->Cell(5,$textypos,"Efectivo: S/ ". $datos->efectivo);
    }else{
            $pdf->Cell(5,$textypos,"Efectivo: S/ 0.00");
    }
    $pdf->setX(20);
    $pdf->Cell(5,$textypos,"Vuelto: S/ ".number_format(($datos->efectivo - $datos->total),2,".",","));
    $pdf->setX(2);
    $pdf->Cell(40,$textypos+6,'GRACIAS POR TU COMPRA',"",0,"C");

    $pdf->output();
	}

}
