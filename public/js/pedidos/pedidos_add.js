var tel="";
var totalPedido=0;

$(()=>{

  drawTabla(productos_carrito);

  let to= parseFloat($("#totalPed").html());
  if(to<=0){
    $("#confirmPedido").attr('disabled', true);
  }

  toastr.options = {
      "showDuration": "1000",
    "hideDuration": "1000",
    "timeOut": "500",
    "extendedTimeOut": "500",
  }

});

$('#efectivo').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g,'');
});

$('#telefono').on('input', function () {
    this.value = this.value.replace(/[^0-9]/g,'');
});

$('#pago').on('change', function () {
    if($("#pago").val() == "Efectivo"){
      $("#divEfectivo").attr("style","display:block");
      $('#efectivo').val(0);
    }else{
        $("#divEfectivo").attr("style","display:none");
        $('#efectivo').val(0);
    }
});

$("#cantidad").on('change', function(){
  let c= parseInt($("#cantidad").val());
  let precio= parseFloat($(".subTotalPro").attr("value"));
  $('.subTotalPro').html(" "+Number(precio*c).toFixed(2));
});

$('#pro').on('change', function (e) {
	e.preventDefault();
  let id=$(this).val();
  $(".divAtributos").html("");

  $.post(base_url + 'order/getProduct/' + id, function (data) {
		$('#id').val(data.id);
    $('#precio').val(data.precio);
		$('.tituloProducto').html(data.nombre);
    $('.descripcionProducto').html(data.descripcion);
    $('.subTotalPro').html(" "+data.precio);
    $('.subTotalPro').attr("value", data.precio);
    let atributos=data.atributos;
    let html='';
    $.each(atributos, function (j, k) {
      html+='<label for="cantidad">'+k.titulo+'</label>';
      html+='<select class="form-control input-sm" name="atributo['+j+']">';
      let variables = k.variables.split(",");
        $.each(variables, function (j, k) {
          html+='<option value="'+k+'">'+k+'</option>';
        });
      html+='</select>';
      $(".divAtributos").html(html);
    });

    $('#formularioDatos')[0].reset();
  	$('#modalProducto').modal('show');

	}, 'json');

});

function drawTabla(productos){
  totalPedido=0;
  let html='';
  $.each(productos, function (j, k) {
    html+='<tr>';
    html+='<td><center>'+k.cantidad+'</center></td>';
    html+='<td>'+ k.nombre+' ';
      $.each(k.atributos, function(j, k){
        html+='<p class="atributos">'+k+'</p>';
      });
    html+='<hr><p class="notaD">'+k.nota+'</p></td>';
    html+='<td><center>S/ '+k.precio+'<button value="'+j+'" type="button" onClick="deleteP(this)" class="close deleteProduct">×</button></center></td>';
    html+='</tr>';
    totalPedido+=(k.cantidad * k.precio);
  });

    if(productos.length > 0){
      html+='<tr>';
      html+='<td></td>';
      html+='<th><center>Delivery</center></th>';
      html+='<th><center>S/<span id="">'+precioDelivery+'</span></center></th>';
      html+='</tr>';
      totalPedido+=Number(precioDelivery);
    }

    html+='<tr>';
    html+='<td></td>';
    html+='<th><center>TOTAL</center></th>';
    html+='<th><center>S/<span id="totalPed">'+Number(totalPedido).toFixed(2)+'</span></center></th>';
    html+='</tr>';
  $("#cuerpo").html(html);
}


$("#botonAgregar").click(function(e){
  	e.preventDefault();
    $.post(base_url + 'order/setCarrito', $('#formularioDatos').serialize(), function (data) {
  		if (data.error) {
  			toastr.success('SE AGREGÓ CORRECTAMENTE', 'EXCELENTE!');
  			$('#modalProducto').modal('hide');
        drawTabla(data.productos_carrito);
  		} else {
  			toastr.error(data.message, 'ERROR!');
  		}
  	}, 'json');
    $("#confirmPedido").attr('disabled', false);
});


$(".deleteProduct").on('click', function(e){
  	e.preventDefault();
    let id=$(this).attr("value");
    $.post(base_url + 'order/delProCar', {id:id}, function (data) {
  		if (data.error) {
  			location.reload();
  		} else {
  			toastr.error(data.message, 'ERROR!');
  		}
  	}, 'json');
});

function deleteP(cod){
    let id=$(cod).attr("value");
    $.post(base_url + 'order/delProCar', {id:id}, function (data) {
  		if (data.error) {
  			location.reload();
  		} else {
  			toastr.error(data.message, 'ERROR!');
  		}
  	}, 'json');
}

$('#formularioDatos').submit(function (e) {
	e.preventDefault();
		//$("#ats").val(JSON.stringify(arraydatos));

		$("#ats").val(arraydatos);
	$.post(base_url + 'atributos/store', $('#formularioDatos').serialize(), function (data) {
		if (data.error) {
			toastr.success('SE GUARDÓ CORRECTAMENTE', 'EXCELENTE!');
			$('#atributosModal').modal('hide');
			tablaAtributos.ajax.reload();
		} else {
			toastr.error(data.message, 'ERROR!');
		}
	}, 'json');
});


$("#confirmPedido").click(function(e){
  e.preventDefault();
  if(!validarCampos()){return;};
  let textProduct='';
  let cliente=$("#nombre").val();
  let telefono=$("#telefono").val();
  let direccion=$("#direccion").val();
  let referencia=$("#referencia").val();
  let pago=$("#pago").val();
  let efectivo=$("#efectivo").val();
  let fecha_entrega=$("#fecha_entrega").val();
  let hora_entrega=$("#hora_entrega").val();

  $.post(base_url + 'order/guardarPedido',{cliente:cliente, telefono: telefono, direccion:direccion, pago:pago, efectivo:efectivo, referencia:referencia, fecha_entrega:fecha_entrega, hora_entrega:hora_entrega}, function (data) {
  location.reload();

  }, 'json');

});

$("#EditPedido").click(function(e){
  e.preventDefault();
  if(!validarCampos()){return;};
  let textProduct='';
  let id=$("#idPedido").val();
  let cliente=$("#nombre").val();
  let telefono=$("#telefono").val();
  let direccion=$("#direccion").val();
  let referencia=$("#referencia").val();
  let pago=$("#pago").val();
  let efectivo=$("#efectivo").val();
  let fecha_entrega=$("#fecha_entrega").val();
  let hora_entrega=$("#hora_entrega").val();

  $.post(base_url + 'order/editarPedido',{id:id, cliente:cliente, telefono: telefono, direccion:direccion, pago:pago, efectivo:efectivo, referencia:referencia, fecha_entrega:fecha_entrega, hora_entrega:hora_entrega}, function (data) {
    if (data.error) {
      toastr.success('SE GUARDÓ CORRECTAMENTE', 'EXCELENTE!');
      setTimeout(() => { window.location = base_url + 'pedidos'; }, 2000);
    } else {
      toastr.error(data.message, 'ERROR!');
      setTimeout(() => { window.location = base_url + 'pedidos'; }, 2000);
    }

  }, 'json');

});

function validarCampos(){

  $("#nombre").attr('style','border: solid 1px #e5e5e5');
  $("#telefono").attr('style','border: solid 1px #e5e5e5');
  $("#direccion").attr('style','border: solid 1px #e5e5e5');

  if($("#nombre").val()==""){
    $("#nombre").focus();
    $("#nombre").attr('style','border: solid 1px #d62727');
    return;
  }


  if($("#telefono").val()==""){
    $("#telefono").focus();
    $("#telefono").attr('style','border: solid 1px #d62727');
    return;
  }

  if($("#direccion").val()==""){
    $("#direccion").focus();
    $("#direccion").attr('style','border: solid 1px #d62727');
    return;
  }

  return true;

}
