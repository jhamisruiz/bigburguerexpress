$(()=>{


});

$('#btn_add').click(function (e) {
	e.preventDefault();
	$('#formularioDatos')[0].reset();
	$('#usuarioModal').modal('show');
});

$('form').on('reset', function () {
	$('input[type=\'hidden\']', $(this)).val('');
});

$('#btn_edit').click(function (e) {
	e.preventDefault();
	let indexR = tablaUsuarios.row('.selected').id();
	if (indexR != null) {
		editar(indexR);
	} else {
		toastr.error('SELECCIONA UN REGISTRO PRIMERO', 'ERROR!');
	}
});

$('#btn_delete').click(function (e) {
	e.preventDefault();
	let indexR = tablaUsuarios.row('.selected').id();
	if (indexR != null) {
		eliminar(indexR);
	} else {
		toastr.error('SELECCIONA UN REGISTRO PRIMERO', 'ERROR!');
	}
});


$('#formularioDatos').submit(function (e) {
	e.preventDefault();
	$.post(base_url + 'usuarios/store', $('#formularioDatos').serialize(), function (data) {
		if (data.error) {
			toastr.success('SE GUARDÓ CORRECTAMENTE', 'EXCELENTE!');
			$('#usuarioModal').modal('hide');
			tablaUsuarios.ajax.reload();
		} else {
			toastr.error(data.message, 'ERROR!');
		}
	}, 'json');
});


function editar (id) {
	$.post(base_url + 'usuarios/get/' + id, function (data) {
		$('#id').val(data.id);
		$('#nombre').val(data.nombre);
		$('#usuario').val(data.usuario);
		$('#telefono').val(data.telefono);
		$('#email').val(data.email);
		$('#usuarioModal').modal('show');
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
			$.post(base_url + 'usuarios/delete/' + id, function (data) {
				if (!data.error) {
					toastr.success('SE ELIMINÓ CORRECTAMENTE', 'EXCELENTE!');
					tablaUsuarios.ajax.reload();
				} else {
					toastr.error('NO SE PUDO ELIMINAR', 'ERROR!');
				}
			}, 'json');
		}
	});
}
