$('#btn_add').click(function (e) {
	e.preventDefault();
	$('#formularioDatos')[0].reset();
	$('#categoriaModal').modal('show');
});

$('form').on('reset', function() {
  $("input[type='hidden']", $(this)).val('');
});

$('#btn_edit').click(function (e) {
	e.preventDefault();
	let indexR = tablaCategorias.row('.selected').id();
	if (indexR != null) {
		editar(indexR);
	} else {
		toastr.error('SELECCIONA UN REGISTRO PRIMERO', 'ERROR!');
	}
});

$('#btn_share').click(function (e) {
	e.preventDefault();
	let indexR = tablaCategorias.row('.selected').id();
	if (indexR != null) {
			let cat= 	tablaCategorias.row('.selected').data().descripcion;
			let url = base_url+"?cat="+cat;

			var $temp = $("<input>");
			$("body").append($temp);
			$temp.val(url).select();
			document.execCommand("copy");
			$temp.remove();

			toastr.success('ENLACE COPIADO AL PORTAPAPELES', 'EXCELENTE!');

	} else {
		toastr.error('SELECCIONA UN REGISTRO PRIMERO', 'ERROR!');
	}
});


$('#btn_delete').click(function (e) {
	e.preventDefault();
	let indexR = tablaCategorias.row('.selected').id();
	if (indexR != null) {
		eliminar(indexR);
	} else {
		toastr.error('SELECCIONA UN REGISTRO PRIMERO', 'ERROR!');
	}
});

$('#formularioDatos').submit(function (e) {
	e.preventDefault();
	$.post(base_url + 'categorias/store', $('#formularioDatos').serialize(), function (data) {
		if (data.error == 3) {
			toastr.error("N° ORDEN REPETIDO", 'ERROR!');
		} else if(data.error){
			toastr.success('SE GUARDÓ CORRECTAMENTE', 'EXCELENTE!');
			$('#categoriaModal').modal('hide');
			tablaCategorias.ajax.reload();
		}else{
			toastr.error("NO SE PUDO AGREGAR", 'ERROR!');
		}
	}, 'json');
});

function editar (id) {
	$.post(base_url + 'categorias/get/' + id, function (data) {
		$('#id').val(data.id);
		$('#descripcion').val(data.descripcion);
		$('#orden').val(data.orden);
		$('#categoriaModal').modal('show');
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
			$.post(base_url + 'categorias/delete/' + id, function (data) {
				if (!data.error) {
					toastr.success('SE ELIMINÓ CORRECTAMENTE', 'EXCELENTE!');
					tablaCategorias.ajax.reload();
				} else {
					toastr.error('NO SE PUDO ELIMINAR', 'ERROR!');
				}
			}, 'json');
		}
	});
}
