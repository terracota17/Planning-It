$(document).ready(function() {

    $("#titulo").change(function(){
		var url = "../comprobarNoticia.php?titulo=" + $("#titulo").val();
		$.get(url,noticiaExiste);
	});
	
	$("#cuerpo").change(function(){
        var ln = $("#cuerpo").val().length;
		
		const campo = $("#cuerpo"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (ln < 10) {
			$("#validNews").text("\u274c");
			campo[0].setCustomValidity("El cuerpo de la noticia necesita un minimo de 10 caracteres.");
		}
		else {
			$("#validNews").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});

    function noticiaExiste(data,status) {
		// tu codigo aqui
		const campo = $("#titulo"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (data == 'existe' && status == 'success') {
			$("#validTitle").text("\u274c");
			window.alert("Noticia ya existente.");
			campo[0].setCustomValidity("Noticia ya existente.");
		}
		else {
			$("#validTitle").text("\u2705");
			campo[0].setCustomValidity("");
		}
	}
})