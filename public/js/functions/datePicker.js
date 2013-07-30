$(document).ready(function (){

	$('<img src="' + baseurl + '/visual/images/components/calendar.png"/ class="calendarIcon">').
		insertAfter($('.datetime'));
	$('<img src="' + baseurl + '/visual/images/components/calendar.png"/ class="calendarIcon">').
		insertAfter($('.date'));
	$('<img src="' + baseurl + '/visual/images/components/clock.png"/ class="clockIcon">').
		insertAfter($('.time'));
		
	$('.datetime').AnyTime_picker(
		{
			format: "%d/%m/%Y %H:%i:%s",
			labelTitle: "Escolha data e hora",
			labelYear: "Ano",
			labelMonth: "Mês",
			labelDayOfMonth: "Dia",
			labelHour: "Hora", 
			labelMinute: "Minuto",
			labelSecond: "Segundos"
	    });
	
	$('.date').AnyTime_picker(
		{
			format: "%d/%m/%Y",
			labelTitle: "Escolha data",
			labelYear: "Ano",
			labelMonth: "Mês",
			labelDayOfMonth: "Dia"
	    });
	
	$('.time').AnyTime_picker(
		{
			format: "%H:%i:%s",
			labelTitle: "Escolha hora",
			labelHour: "Hora", 
			labelMinute: "Minuto",
			labelSecond: "Segundos"
	    });
	
});