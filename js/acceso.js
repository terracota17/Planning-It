$(document).ready(function() {

	$("#correoOK").hide();
	$("#userOK").hide();

	$("#correo").change(function(){
		const campo = $("#correo"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		// validación html5, porque el campo es <input type="email" ...>
		const esCorreoValido = campo[0].checkValidity();
		if (esCorreoValido && correoValido(campo.val())) {
			// el correo es válido y acaba por @ucm.es: marcamos y limpiamos quejas
		
			// tu código aquí: coloca la marca correcta
			$("#validEmail").text("\u2705");

			campo[0].setCustomValidity("");
		} else {			
			// correo invalido: ponemos una marca y nos quejamos

			// tu código aquí: coloca la marca correcta
			$("#validEmail").text("\u274c");

			campo[0].setCustomValidity(
				"El correo debe ser válido.");
		}
	});

	var $log = $("#user, #pass");
	$log.change(function(){
		var url = "comprobarLogin.php?user=" + $("#user").val() + "&pass=" + $("#pass").val();
		$.get(url,loginCorrecto);
	});

	$("#nombreUsuario").change(function(){
		var url = "comprobarUsuario.php?user=" + $("#nombreUsuario").val();
		$.get(url,usuarioExiste);
	});

	var $els = $("#password, #password2");
	$els.change(function(){
		var p1 = $("#password").val();
		var l1 = $("#password").val().length;
		var p2 = $("#password2").val();

		const campo = $("#password2"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (p1 != p2 || l1 < 5) {
			$("#validPassword").text("\u274c");
			campo[0].setCustomValidity("Las contraseñas no coinciden o no tienen una longitud valida.");
		}
		else {
			$("#validPassword").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});

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

	$("#apellido").change(function(){
		var la = $("#apellido").val().length;

		const campo = $("#apellido"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (la == 0) {
			$("#validApellido").text("\u274c");
			campo[0].setCustomValidity("El apellido no puede estar vacío.");
		}
		else {
			$("#validApellido").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});

	$("#telefono").change(function(){
		var lt = $("#telefono").val().length;

		const campo = $("#telefono"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (lt < 9 || lt > 9) {
			$("#validPhone").text("\u274c");
			campo[0].setCustomValidity("El telefono tiene que tener al menos 9 digitos.");
		}
		else {
			$("#validPhone").text("\u2705");	
			campo[0].setCustomValidity("");
		}
	});

	function correoValido(correo) {
		// tu codigo aqui (devuelve true ó false)
		if (correo.indexOf("@", 0) == -1) {
			return false;
		}
		else {
			return true;
		}
	}

	function usuarioExiste(data,status) {
		// tu codigo aqui
		const campo = $("#nombreUsuario"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (data == 'existe' && status == 'success') {
			$("#validUser").text("\u274c");
			window.alert("Nombre de usuario reservado.");
			campo[0].setCustomValidity("Nombre de usuario en uso.");
		}
		else {
			$("#validUser").text("\u2705");
			campo[0].setCustomValidity("");
		}
	}

	function loginCorrecto(data,status) {
		// tu codigo aqui
		const campo = $("#pass"); // referencia jquery al campo
		campo[0].setCustomValidity(""); // limpia validaciones previas

		if (data == 'error' && status == 'success') {
			campo[0].setCustomValidity("Datos incorrectos.");
		}
		else {
			campo[0].setCustomValidity("");
		}
	}
})