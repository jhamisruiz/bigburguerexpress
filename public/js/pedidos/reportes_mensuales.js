$(()=>{
  current_url = tablaReportes.ajax.url();
  getSum();
});

function getSum(start = null, end = null) {
	$.post(base_url + 'reportes/getSumMensual', {start:start, end:end}, function (data) {
    $("#total").html("");
    if(data!=null){
          $("#total").html("Total: "+ data);
    }
	}, 'json');
}

//filter date picker
let lastpicker = null;
let selection = null;
$('input[type=radio][name=rango]').change(function () {
	if (lastpicker !== null) {
		lastpicker.datepicker('remove');
		$('.actual_range').val('');
	}
	selection = this.value;
	if (this.value === 'single') {
		$('#event_period').show();
		lastpicker = $($('.actual_range')[0]).datepicker({
			format: 'mm-yyyy',
			startView: 'months',
			minViewMode: 'months',
		});
		$($('.actual_range')[0]).val('seleccione');
		$($('.actual_range')[1]).hide();
	}
	if (this.value === 'range') {
		$('#event_period').show();
		$($('.actual_range')[1]).show();
		$($('.actual_range')[0]).val('desde');
		$($('.actual_range')[1]).val('hasta');
		lastpicker = $('#event_period').datepicker({
			inputs: $('.actual_range'),
			format: 'mm-yyyy',
			startView: 'months',
			minViewMode: 'months',
		});
	}
});

$('#btn_date_apply').click((e) => {
	e.preventDefault();
	if (selection === 'single') {
		let date = $($('.actual_range')[0]).datepicker('getDate');
		let year = date.getFullYear();
		let month = (date.getMonth() + 1).toString();
    tablaReportes.columns([1]).search(year + "-" + month.padZero(2, '0')).draw();
    getSum(year + "-" + month.padZero(2, '0'));
	}
	if (selection === 'range') {
		let date_start = $($('.actual_range')[0]).datepicker('getDate');
		date_start = date_start.getFullYear() + '-' + (date_start.getMonth() + 1).toString().padZero(2, '0');
		let date_end = $($('.actual_range')[1]).datepicker('getDate');
		date_end = date_end.getFullYear() + '-' + (date_end.getMonth() + 1).toString().padZero(2, '0');
		tablaReportes.ajax.url(current_url + '/' + date_start + '/' + date_end).load();
    getSum(date_start, date_end);
	}
});

$('#btn_date_clear').click((e) => {
	tablaReportes.ajax.url(current_url).load();
	tablaReportes.columns([1]).search('').draw();
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
