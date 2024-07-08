$(document).ready(function() {
	
	$("#nombre").change(function(){
        var ln = $("#nombre").val().length;
		
		const campo = $("#nombre"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (ln == 0) {
			$("#validName").text("\u274c");
			campo[0].setCustomValidity("El nombre no puede estar vacío.");
		}
		else {
			$("#validName").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});

	$("#ubicacion").change(function(){
		var ln = $("#ubicacion").val().length;
		
		const campo = $("#ubicacion"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (ln == 0) {
			$("#validPlace").text("\u274c");
			campo[0].setCustomValidity("La ubicacion no puede estar vacía.");
		}
		else {
			$("#validPlace").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});

	$("#informacion").change(function(){
		var la = $("#informacion").val().length;

		const campo = $("#informacion"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (la == 0) {
			$("#validInfo").text("\u274c");
			campo[0].setCustomValidity("La informacion no puede estar vacía.");
		}
		else {
			$("#validInfo").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});

	$("#fecha").change(function(){
		var lt = $("#fecha").val();

		const campo = $("#fecha"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (lt == NULL) {
			$("#validDate").text("\u274c");
			campo[0].setCustomValidity("Selecciona una fecha.");
		}
		else {
			$("#validDate").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});

	$("#note").change(function(){
        var ln = $("#note").val().length;
		
		const campo = $("#note"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (ln > 70) {
			$("#validNote").text("\u274c");
			campo[0].setCustomValidity("No puedes introducir más caracteres (Max. 70).");
		}
		else {
			$("#validNote").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});

	$("#precio").change(function(){
        var ln = $("#precio").val();
		
		const campo = $("#precio"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (ln <= 0) {
			$("#validPrice").text("\u274c");
			campo[0].setCustomValidity("El precio debe ser mayor a 0.");
		}
		else {
			$("#validPrice").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});

	$("#infoProd").change(function(){
        var ln = $("#infoProd").val().length;
		
		const campo = $("#infoProd"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (ln < 5) {
			$("#validInfoProd").text("\u274c");
			campo[0].setCustomValidity("La descripcion debe ser de al menos 5 caracteres.");
		}
		else {
			$("#validInfoProd").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});

	$("#telefono").change(function(){
        var ln = $("#telefono").val().length;
		
		const campo = $("#telefono"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (ln < 9 || ln > 9) {
			$("#validPhone").text("\u274c");
			campo[0].setCustomValidity("Número de telefono invalido (9 digitos).");
		}
		else {
			$("#validPhone").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});

	$("#numero").change(function(){
        var ln = $("#numero").val().length;
		
		const campo = $("#numero"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (ln < 16 || ln > 16) {
			$("#validCredit").text("\u274c");
			campo[0].setCustomValidity("La tarjeta de credito es inválida (16 digitos).");
		}
		else {
			$("#validCredit").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});

	$("#contraseña").change(function(){
        var ln = $("#contraseña").val().length;
		
		const campo = $("#contraseña"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (ln < 3 || ln > 3) {
			$("#validPass").text("\u274c");
			campo[0].setCustomValidity("La clave es invalida (3 digitos).");
		}
		else {
			$("#validPass").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});
})