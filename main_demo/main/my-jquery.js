document.addEventListener("DOMCotnentLoaded", function() {
    $('.target').change;
	if( $(this).val() ) {
		window.location.href = $(this).val();
	}
    console.log($(this).val());
});