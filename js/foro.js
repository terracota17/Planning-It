$(document).ready(function() {

    $("#tema").change(function(){
		var url = "../comprobarForo.php?tema=" + $("#tema").val();
		$.get(url,foroExiste);
	});
	
	$("#contenido").change(function(){
        var ln = $("#contenido").val().length;
		
		const campo = $("#contenido"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (ln > 1000) {
			$("#validInfo").text("\u274c");
			campo[0].setCustomValidity("Maximo numero de caracteres superado (Max. 1000).");
		}
		else {
			$("#validInfo").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});

    function foroExiste(data,status) {
		// tu codigo aqui
		const campo = $("#tema"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (data == 'existe' && status == 'success') {
			$("#validTheme").text("\u274c");
			window.alert("Tema del foro existente.");
			campo[0].setCustomValidity("Tema del foro existente.");
		}
		else {
			$("#validTheme").text("\u2705");
			campo[0].setCustomValidity("");
		}
	}
})