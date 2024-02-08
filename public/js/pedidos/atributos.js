
var arraydatos;

$('#btn_add').click(function (e) {
	e.preventDefault();
	$('#formularioDatos')[0].reset();
	$('.list-group').html("");
	arraydatos=[];
	$('#atributosModal').modal('show');
});

$('#btn_at').click(function (e) {
	e.preventDefault();
	let h='<li class="list-group-item">'+$('#texto').val()+'</li>';
	if($('#texto').val()!=""){
		$('.list-group').append(h);
		arraydatos.push($('#texto').val());
	}else{
		$('#texto').focus();
	}
	$('#texto').val('');
});

$('form').on('reset', function() {
  $("input[type='hidden']", $(this)).val('');
});

$('#btn_edit').click(function (e) {
	e.preventDefault();
	$('.list-group').html("");
	arraydatos=[];
	let indexR = tablaAtributos.row('.selected').id();
	if (indexR != null) {
		editar(indexR);
	} else {
		toastr.error('SELECCIONA UN REGISTRO PRIMERO', 'ERROR!');
	}
});


$('#btn_delete').click(function (e) {
	e.preventDefault();
	let indexR = tablaAtributos.row('.selected').id();
	if (indexR != null) {
		eliminar(indexR);
	} else {
		toastr.error('SELECCIONA UN REGISTRO PRIMERO', 'ERROR!');
	}
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

function editar (id) {
	$.post(base_url + 'atributos/get/' + id, function (data) {
		$('#id').val(data.id);
		$('#titulo').val(data.titulo);

		var variables = data.variables.split(",");

		$.each(variables, function (j, k) {
			$('.list-group').append('<li class="list-group-item">'+k+'</li>');
			arraydatos.push(k);
		});

		$('#variables').val(data.variables);
		$('#atributosModal').modal('show');
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
			$.post(base_url + 'atributos/delete/' + id, function (data) {
				if (!data.error) {
					toastr.success('SE ELIMINÓ CORRECTAMENTE', 'EXCELENTE!');
					tablaAtributos.ajax.reload();
				} else {
					toastr.error('NO SE PUDO ELIMINAR', 'ERROR!');
				}
			}, 'json');
		}
	});
}
