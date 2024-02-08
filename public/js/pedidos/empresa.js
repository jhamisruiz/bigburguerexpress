$(() => {

  cargarDatos();
});



$('#btn_edit').click(function (e) {
	e.preventDefault();
  let parametros = new FormData($('#formularioDatos')[0]);

  $.ajax({
    url: base_url + 'empresa/store',
    type: 'POST',
    data: parametros,
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.error) {
        toastr.success('SE GUARDÓ CORRECTAMENTE', 'EXCELENTE!');
      } else {
        toastr.error(data.message, 'ERROR!');
      }
    },
  });

});

function cargarDatos() {
	$.post(base_url + 'empresa/getEmpresa', function (data) {
		$('#nombre').val(data.nombre);
    $('#email').val(data.email);
    $('#telefono').val(data.telefono);
    $('#direccion').val(data.direccion);
    $('#delivery').val(data.precio_delivery);
    $('#horario_entrada').val(data.hora_entrada);
    $('#horario_salida').val(data.hora_salida);
    $('#tiempo_espera').val(data.tiempo_espera);
	}, 'json');
}
