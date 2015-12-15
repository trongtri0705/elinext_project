$(document).ready(function(){
	$('.nav a').each(function () {
		if (location.href.indexOf($(this).attr('href')) != -1) {
			$(this).parent().addClass('active');
			$(this).parent().parent().parent().addClass('active');
		}
	});
});
