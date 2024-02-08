$(()=>{
		setCategorias();
		$('#selectAtributos').multiSelect();
		$('#id_categoria').multiSelect();

});

$("#categories").on("change", function(){
		let val=$("#categories option:selected").text();
	  tablaProductos.columns( 4 ).search(val).draw();
});

$('#btn_add').click(function (e) {
	e.preventDefault();
	$('#formularioDatos')[0].reset();
	$('#productoModal').modal('show');
});

$('form').on('reset', function() {
  $("input[type='hidden']", $(this)).val('');
});

$('#btn_edit').click(function (e) {
	e.preventDefault();
	let indexR = tablaProductos.row('.selected').id();
	if (indexR != null) {
		editar(indexR);
	} else {
		toastr.error('SELECCIONA UN REGISTRO PRIMERO', 'ERROR!');
	}
});

function setCategorias(){
		$.post(base_url + 'categorias/getCategorias/', function (data) {
			var html = '<option value="0">--Filtrar Categoría--</option>';
			$.each(data, function (j, k) {
				html += `<option value='${k.id}'>${k.descripcion}</option>`;
			});
			$('#categories').html(html);
		}, 'json');
}



function setAtributosEdit(atributos){
	$('#selectAtributos').multiSelect('deselect_all');
	$('#selectAtributos').multiSelect('refresh');

	var datos=[];
	$.each( atributos, function( key, value ) {
		datos[key]=""+value['id_atributo'];
	});
	$('#selectAtributos').multiSelect('select', datos);
}

function setCategoriesEdit(categorias){
	$('#id_categoria').multiSelect('deselect_all');
	$('#id_categoria').multiSelect('refresh');

	var datos=[];
	$.each( categorias, function( key, value ) {
		datos[key]=""+value['id_categoria'];
	});
	$('#id_categoria').multiSelect('select', datos);

}

$('#btn_delete').click(function (e) {
	e.preventDefault();
	let indexR = tablaProductos.row('.selected').id();
	if (indexR != null) {
		eliminar(indexR);
	} else {
		toastr.error('SELECCIONA UN REGISTRO PRIMERO', 'ERROR!');
	}
});

$('#formularioDatos').submit(function (e) {
	e.preventDefault();
	let parametros = new FormData($('#formularioDatos')[0]);
	$.ajax({
		url: base_url + 'productos/store',
		type: 'POST',
		data: parametros,
		dataType: 'json',
		cache: false,
		contentType: false,
		processData: false,
		success: function (data) {
			if (data.error  == 3) {
				toastr.error('N° DE ORDEN REPETIDO', 'ERROR!');
			} else if(data.error){
				toastr.success('SE GUARDÓ CORRECTAMENTE', 'EXCELENTE!');
				$('#productoModal').modal('hide');
				tablaProductos.ajax.reload();
			}else{
				toastr.error('NO SE PUDO AGREGAR', 'ERROR!');
			}
		},
	});

});

function editar (id) {
	$.post(base_url + 'productos/get/' + id, function (data) {
		$('#id').val(data.id);
		$('#nombre').val(data.nombre);
		$('#precio').val(data.precio);
		$('#descripcion').val(data.descripcion);
		$('#orden').val(data.orden);
		setAtributosEdit(data['atributos']);
		setCategoriesEdit(data['categories']);
		$('#productoModal').modal('show');
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
			$.post(base_url + 'productos/delete/' + id, function (data) {
				if (!data.error) {
					toastr.success('SE ELIMINÓ CORRECTAMENTE', 'EXCELENTE!');
					tablaProductos.ajax.reload();
				} else {
					toastr.error('NO SE PUDO ELIMINAR', 'ERROR!');
				}
			}, 'json');
		}
	});
}
