var tel="";
var totalPedido=0;
var start,end, esp;

$(()=>{
  let to= parseFloat($("#totalPed").html());
  if(to<=0){
    $("#confirmPedido").attr('disabled', true);
  }

  $.post(base_url + 'order/getEmpresa', function (data) {
    esp=data.tiempo_espera;
    end= data.hora_salida;
    start= data.hora_entrada;

  }, 'json');


//setting the first category as active

let params = new URLSearchParams(location.search);
var cat = params.get('cat');

if(cat == null){
  var selector=$(".grid_sorting_button").first().text();
  $("#tableTittle").text(selector.toUpperCase());
  selector = selector.replace(/ /g, "")
  $(".grid_sorting_button").first().addClass("active");
}else{

  var selector = cat;
  $("#tableTittle").text(selector.toUpperCase());
  selector = selector.replace(/ /g, "")
}

  $('.product-grids').isotope({
      filter: "."+selector,
      animationOptions: {
      duration: 750,
      easing: 'linear',
      queue: false
      }
  });


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

$('.btn_add').click(function (e) {
	e.preventDefault();
  let id=$(this).attr("value");
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


$("#botonAgregar").click(function(e){
  	e.preventDefault();
    $.post(base_url + 'order/setCarrito', $('#formularioDatos').serialize(), function (data) {
  		if (data.error) {
  			toastr.success('SE AGREGÓ CORRECTAMENTE', 'EXCELENTE!');
  			$('#modalProducto').modal('hide');
        $("#checkout_items").html(data.carrito);
  		} else {
  			toastr.error(data.message, 'ERROR!');
  		}
  	}, 'json');
});

$(".deleteProduct").click(function(e){

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
  if(!validarHora()){return;};
  let textProduct='';
  let end='';
  let cliente=$("#nombre").val();
  let telefono=$("#telefono").val();
  let direccion=$("#direccion").val();
  let referencia=$("#referencia").val();
  let pago=$("#pago").val();
  let efectivo=$("#efectivo").val();
  let fecha_entrega=$("#fecha_entrega").val();
  let hora_entrega=$("#hora_entrega").val();

    $.when($.post(base_url + 'order/guardarPedido',{cliente:cliente, telefono: telefono, direccion:direccion, pago:pago, efectivo:efectivo, referencia:referencia, fecha_entrega:fecha_entrega, hora_entrega:hora_entrega}, function (data) {
      tel=data['tel'];
      $.each(arrayProductos, function (j, k) {
        textProduct+=k.cantidad+' | '+k.nombre+' | S/  '+Number(k.precio*k.cantidad).toFixed(2);
        totalPedido+=(k.precio*k.cantidad);
        if(k.atributos.length > 0){
          let x= k.atributos.join(" | ");
          textProduct+="%0A("+x+")";
        }
        if(k.nota!=""){textProduct+="%0A_[Nota]: "+k.nota+"_";}
        textProduct+="%0A%0A";

      });

      totalPedido+=Number(precioDelivery);
      if(pago=='Efectivo'){
        end="%0A*Efectivo:* S/ "+Number(efectivo).toFixed(2)+" *Vuelto:* S/ " + Number((efectivo-totalPedido)).toFixed(2);
      }else{
        end="%0A*Efectivo:* S/ 0.00  *Vuelto:* S/ 0.00";
      }


    }, 'json')).then(function(){

      var d = new Date(fecha_entrega+"T"+hora_entrega);
      var a= new Date();
      let url= "https://api.whatsapp.com/send?phone=51"+tel+"&text=*_Pedido Delivery_*%0A%0A*Nombre:*%0A"+cliente+"%0A*Dirección:*%0A"+direccion+"%0A*Referencia:*%0A"+referencia+"%0A*Método de Pago:*%0APago en "+pago+"%0A*Teléfono:*%0A"+telefono+"%0A%0A*Fecha Pedido:*%0A"+a.toLocaleString("en-GB")+"%0A*Fecha Entrega:*%0A"+d.toLocaleString("en-GB")+"%0A%0A*Detalles:*%0A"+textProduct+"*Precio Delivery:* S/ "+Number(precioDelivery).toFixed(2)+"%0A%0A*TOTAL:* S/ "+Number(totalPedido).toFixed(2)+end;
      window.open(url);
      window.location.href = base_url+"order";
    });

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


function validarHora(){

    var now = new Date();

    now.setMinutes(now.getMinutes() + Number(esp));
    var hora_entrega= ("0" + now.getHours()).slice(-2)+":"+("0" + now.getMinutes()).slice(-2);

    var dato=$("#hora_entrega").val();
    var maxHour= end;
    var minHour= start;

    var fechaInput=$("#fecha_entrega").val();
    var fechaHoy= now.getFullYear()+"-"+("0" + (now.getMonth() + 1)).slice(-2)+"-"+("0" + now.getDate()).slice(-2);

    var a = new Date(fechaInput);
    var b = new Date(fechaHoy);

    if(a.getTime() == b.getTime()){
      if(dato>= minHour && dato<=maxHour){
        if(dato>=hora_entrega){
          return true;
        }else{
          let mensaje= "Considere un tiempo minino de "+esp+ " minutos";
          toastr.error(mensaje, 'ERROR!');
          $("#hora_entrega").focus();
          return false;
        }
      }else{
        toastr.error('Hora fuera del horario de reparto', 'ERROR!');
        $("#hora_entrega").focus();
        return false;
      }
    }else{
      if(dato>= minHour && dato<=maxHour){
        return true;
      }else{
        toastr.error('Hora fuera del horario de reparto', 'ERROR!');
        $("#hora_entrega").focus();
        return false;
      }
    }

}
