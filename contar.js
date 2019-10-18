function contar() {
	     var max = "120";
	     var cadena = document.getElementById("smsMessage").value;
	     var longitud = cadena.length;

		     if(longitud <= max) {
		          document.getElementById("contador").value = max-longitud;
		     } else {
		          document.getElementById("smsMessage").value = cadena.substr(0, max);
		     }
	}