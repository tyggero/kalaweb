// Offset for Site Navigation
$('#siteNav').affix({
	offset: {
		top: 100
	}
})

//Air Datepicker
stringToDate = function (element) {
    var pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
    return new Date(element.replace(pattern,'$3-$2-$1'));
}

var dpInput = $('.datepicker-here');
$('.datepicker-here').datepicker().data('datepicker').selectDate(dpInput.val().split(" - ").map(stringToDate));

