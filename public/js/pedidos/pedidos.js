$(()=>{
	setMotorizados();

	 var datepicker= $('#filtroFecha').datepicker({
		 format: 'dd-mm-yyyy',
	 });
	 datepicker.datepicker('setDate', new Date());
	 $('#button-addon2').click();
});

setInterval(function() {
		tablaPedidos.ajax.reload();
}, 10000);

	function setMotorizados(){
			$.post(base_url + 'motorizados/getMotorizados/', function (data) {
				var html = '<option value="0">-- Seleccionar --</option>';
				$.each(data, function (j, k) {
					html += `<option value='${k.id}'>${k.nombre}</option>`;
				});
				$('#motorizado').html(html);
			}, 'json');
	}


$('#btn_adds').click(function (e) {
	e.preventDefault();
	$('#formularioDatos')[0].reset();
	$('#categoriaModal').modal('show');
});

$('form').on('reset', function() {
  $("input[type='hidden']", $(this)).val('');
});

$('#btn_edit').click(function (e) {
	e.preventDefault();
	let rowID = tablaPedidos.row('.selected').id();
  if (rowID != null) {
    let url = base_url + 'pedidos/edit/' + rowID;
  	$(location).attr('href', url);
  }

});

$('#btn_estado').click(function (e) {
	e.preventDefault();
	let indexR = tablaPedidos.row('.selected').id();
	if (indexR != null) {
		cambiarEstado(indexR);
	} else {
		toastr.error('SELECCIONA UN REGISTRO PRIMERO', 'ERROR!');
	}
});

$('#btn_imprimir').click(function (e) {
	e.preventDefault();
	let indexR = tablaPedidos.row('.selected').id();
	if (indexR != null) {
			let mot= 	tablaPedidos.row('.selected').data().nombre;
			if(mot != null){
					imprimir(indexR);
			}else{
				toastr.error('PRIMERO ASIGNA UN MOTORIZADO', 'ERROR!');
			}
	} else {
		toastr.error('SELECCIONA UN REGISTRO PRIMERO', 'ERROR!');
	}
});

$('#btn_view').click(function (e) {
	e.preventDefault();
	let indexR = tablaPedidos.row('.selected').id();
	if (indexR != null) {
		ver(indexR);
	} else {
		toastr.error('SELECCIONA UN REGISTRO PRIMERO', 'ERROR!');
	}
});


$('#btn_delete').click(function (e) {
	e.preventDefault();
	let indexR = tablaPedidos.row('.selected').id();
	if (indexR != null) {
		eliminar(indexR);
	} else {
		toastr.error('SELECCIONA UN REGISTRO PRIMERO', 'ERROR!');
	}
});

$('#formularioDatos').submit(function (e) {
	e.preventDefault();
	$.post(base_url + 'categorias/store', $('#formularioDatos').serialize(), function (data) {
		if (data.error) {
			toastr.success('SE GUARDÓ CORRECTAMENTE', 'EXCELENTE!');
			$('#categoriaModal').modal('hide');
			tablaCategorias.ajax.reload();
		} else {
			toastr.error(data.message, 'ERROR!');
		}
	}, 'json');
});


$('#formularioEstado').submit(function (e) {
	e.preventDefault();
	$.post(base_url + 'pedidos/modificar', $('#formularioEstado').serialize(), function (data) {
		if (data.error) {
			toastr.success('SE GUARDÓ CORRECTAMENTE', 'EXCELENTE!');
			$('#estadoModal').modal('hide');
			tablaPedidos.ajax.reload();
		} else {
			toastr.error("NO SE PUDO CAMBIAR", 'ERROR!');
		}
	}, 'json');
});


function imprimir (id) {
	let url=base_url + 'ticket/NotaPago/' + id;
	var myWindow=window.open(url);
	myWindow.focus();
	myWindow.print();
}

function cambiarEstado (id) {
	$.post(base_url + 'pedidos/getEstado/' + id, function (data) {
		$('#cod').val(data.id);
		$('#condicion').val(data.condicion);
		$('#motorizado').val(data.motorizado);
		$('#estadoModal').modal('show');
	}, 'json');
}

function ver (id) {
	$.post(base_url + 'pedidos/get/' + id, function (data) {
		$('#cliente').text(data.cliente);
		$('#telefono').text(data.telefono);
		$('#fecha_pedido').text(data.fecha);
		$('#fecha_entrega').text(data.hora_entrega);
		$('#direccion').text(data.direccion);
		$('#referencia').text(data.referencia);
		$('#importe').text(data.total);
		$('#efectivo').text(data.efectivo);
		$('#vuelto').text((data.efectivo - data.total).toFixed(2));
		$('#estado').text(data.condicion);

			html='';
			total=0;

		$.each(data.productos, function (j, k) {
			html+='<tr>';
			html+='<td>'+k.cantidad+'</td>';
			html+='<td>'+k.nombre+'</td>';
			html+='<td>S/ '+k.precio+'</td>';
			html+='<td>S/ '+Number(k.cantidad * k.precio).toFixed(2) +'</td>';
			html+='</tr>';
			total+=(k.cantidad * k.precio);
		});
				html+='<tr><td colspan="3" style="text-align:right">Delivery</td><td>S/ '+data.delivery+'</td></tr>';
				html+='<tr><td colspan="3" style="text-align:right">TOTAL</td><td>S/ '+(total + Number(data.delivery)).toFixed(2)+'</td></tr>';
			$("#cuerpo").html(html);

		$('#verModal').modal('show');
	}, 'json');
}

function eliminar (id) {
	swal({
		title: '¿Estás seguro?',
		text: 'No se podrá recuperar los datos eliminados!',
		icon: 'warning',
		buttons: true,
		dangerMode: true,
		showLoaderOnConfirm: true,
	}).then((willDelete) => {
		if (willDelete) {
			$.post(base_url + 'pedidos/delete/' + id, function (data) {
				if (!data.error) {
					toastr.success('SE ELIMINÓ CORRECTAMENTE', 'EXCELENTE!');
					tablaPedidos.ajax.reload();
				} else {
					toastr.error('NO SE PUDO ELIMINAR', 'ERROR!');
				}
			}, 'json');
		}
	});
}


//filter date picker
let lastpicker = null;

$('#button-addon2').click((e) => {
	e.preventDefault();
		let date = $('#filtroFecha').datepicker('getDate');
		let year = date.getFullYear();
		let month = (date.getMonth() + 1).toString();
    let day = date.getDate().toString();
		tablaPedidos.columns([1]).search(year + "-" + month.padZero(2, '0') + "-" + day.padZero(2, '0')).draw();
});

$('#btn_date_clear').click((e) => {
	tablaPedidos.ajax.url(current_url).load();
	tablaPedidos.columns([1]).search('').draw();
	$('#event_period').hide();
	$('input[type=radio][name=rango]').prop('checked', false);
});

String.prototype.padZero = function (len, c) {
	var s = this, c = c || '0';
	while (s.length < len) {
		s = c + s;
	}
	return s;
};


$('#tablaPedidos').on('click', 'tr', function (e) {
	e.stopPropagation();
	let rowID = $(this).attr('id');
	tablaPedidos.rows().deselect();
	tablaPedidos.rows('#' + rowID).select();
});

$('#tablaPedidos').on('dblclick', 'tr', function (e) {
	e.stopPropagation();
	let rowID = $(this).attr('id');
  if (rowID != null) {
    let url = base_url + 'pedidos/edit/' + rowID;
  	$(location).attr('href', url);
  }
});
