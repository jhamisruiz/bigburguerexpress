$(()=>{

  $.post(base_url + 'order/getEmpresa', function (data) {
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

    var hour = ("0" + now.getHours()).slice(-2);
    var minutes = ("0" + now.getMinutes()).slice(-2);
    var currentTime = hour + ':' + minutes;

    var minHour= contador(Number(data.tiempo_espera));

    $("#hora_entrega").val(minHour);
    $("#hora_entrega").attr("max",data.hora_salida);
    $("#hora_entrega").attr("min",minHour);

    $("#fecha_entrega").val(today);
    $("#fecha_entrega").attr("min",today);

	}, 'json');

});

function contador(sum) {
    var fecha = new Date();
    var minutes = fecha.getMinutes();
    fecha.setMinutes(minutes + sum);
    return ("0" + fecha.getHours()).slice(-2) + ':' + ("0" + fecha.getMinutes()).slice(-2)
}
