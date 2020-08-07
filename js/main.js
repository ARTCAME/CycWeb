/*---------------------------------------------------------------------- 
 *	Autor: Arturo Casas
 *----------------------------------------------------------------------*/

/*---------------------------------------------------------------------- 
POLYFILL */

/* Para startsWith() */
if (!String.prototype.startsWith) {
	String.prototype.startsWith = function(stringBuscada, posicion) {
    	posicion = posicion || 0;
    	return this.indexOf(stringBuscada, posicion) === posicion;
  	};
}

/*---------------------------------------------------------------------- 
FIN POLYFILL */

/* Previene que los elementos arrastrados rellenen con us url otros ** Actúa en todo */
window.addEventListener("dragover",function(e){
  e = e || event;
  e.preventDefault();
},false);
window.addEventListener("drop",function(e){
  e = e || event;
  e.preventDefault();
},false);
/* Función para mostrar/modificar elementos si existe Javascript habilitado ** Actúa en: galeria.html, inicio.html */
function noscriptHack() {
	var elem = document.getElementsByClassName("noscript");
	for (var x = 0; x < elem.length; x++) { 
		if (elem[x].id == "inicio-aside") {
			elem[x].className = ""; /* Elimina la clase noscript para que no muestre fondo */
		} else if (elem[x].id == "main-galeria") {
			elem[x].className = ""; /* Elimina la clase noscript para que no muestre fondo */
		} 
		elem[x].style.display = "inline";
		//if (elem[x].id == "mostrar-term")  elem[x].style.display = "inline";
		//elem[x].id == "cobertura-mapa-estatico" ? elem[x].style.display = "block" : elem[x].style.display = "inline";
	}
	var elemProd = document.getElementsByClassName("productoNoJs");
	for (var i = 0; i < elemProd.length; i++) {
		elemProd[i].className = "productos-texto-especifico";
	}
}
/* Función para centrar mapa al pulsar sobre botón ** Actúa en: cabecera.html, contacto.html*/
function centrarMapa(pagina) {
	var mapaUsado;
	pagina == "contacto" ? mapaUsado = document.getElementById("mapa-contacto") : mapaUsado = document.getElementById("mapa-flotante");
	mapaUsado.src = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2981.176861973346!2d-0.9128200842775155!3d41.65192058751639!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd596b315713182b%3A0x9493e993b3120e77!2sCharcuter%C3%ADa+C%26C!5e0!3m2!1ses!2ses!4v1513344303791";
}
/* Función para prevenir el scroll sobre el fondo al haberse abierto un elemento flotante sobre el fondo ** Actúa en: contacto.html, galeria.html, pie.html */
var esTactil = "ontouchstart" in window || navigator.msMaxTouchPoints; /* Confirma si el dispositivo es o no táctil */
var k = {} 
function gestionPopUps(el) {
	var elementoPopUpper;
	if (el == "galeria") {
		elementoPopUpper = document.getElementById("contenedor-ampli") || "undefined";
		var stupidSafariNeedsThisAssignationAndItHasNotMoreUtilities = document.getElementsByClassName("trans-galeria")[0].clientHeight;
		/* ¿BUG en Safari? - Al ejecutar las siguientes líneas se ¿provoca? que, la capa que tiene que superponerse al resto (#contenedor-ampli.trans-galeria), no adquiera altura ni anchura cuando el scroll de la página es 0 y en la primera vez que se accede. Si la página es redimensionada el elemento adquiere altura y anchura 100% como está establecido en CSS para #contenedor-ampli.trans-galeria. Si se cierra con la función cerrarEsc(), es decir, pulsando tecla esc, y se vuelve a abrir elemento entonces sí adquiere altura y anchura. El error parece producirlo cambiar la propiedad "position" fijada en la siguientes líneas pero... */
	}
	if (el == "pie" || el == "contacto") {
		elementoPopUpper = document.getElementById("contenedorifr-pie") || "undefined";
	}
	if (elementoPopUpper) {
    	k.scrollX = window.pageXOffset; /* Guardamos para luego volver a esta posición */
		k.scrollY = window.pageYOffset; /* Guardamos para luego volver a esta posición */
		document.body.style.position = "fixed";
		document.documentElement.style.position = "fixed";
    	document.body.style.top = "-" + k.scrollY + "px";
	}
}
function reseteaScroll() {
	document.documentElement.style.position = "static";
	document.body.style.position = "static";
	document.body.style.top = "unset";
	window.scrollTo(k.scrollX, k.scrollY); /* Restablecemos el scroll */	
	if (document.getElementById("header-logo").className === "pegar menus-fijo") { floto = true; }
}
/* Función para cerrar pop ups al pulsar ESC ** Actúa en: pie.html - contacto.html - galeria.html y el menú principal y mapa desplegable de cabecera.html */
function cerrarEsc(ev) {
	/*reseteaScroll();*/
    var tecla;
    if (window.event) {
    	tecla = window.event.keyCode;
    } else if (ev) { 
    	tecla = ev.which;
    }
    if (tecla == 27) { /* Si se ha pulsado la tecla escape... */
    	if (usado) {
    		usado.style.display = "none"; /* Oculta <iframe> que contiene terminos.html en contacto.html y pie.html */
			/*document.documentElement.style.overflow = "auto";  Resetea el overflow: hidden que le otorga gestionPopUps() */
			usado = undefined; /* Limpiamos valor */
			reseteaScroll();
		}
    	if (document.getElementById("contenedor-ampli") && document.getElementById("contenedor-ampli").className == "trans-galeria") {
    		document.getElementById("contenedor-ampli").className = ""; /* Oculta contenedor de la imagen ampliada en galeria.html */
			document.getElementsByClassName("imagen-ampli")[0].src = "";
			clearTimeout(t); /* Previene que la función navegacionDinamica de galeria.html ejecute cuando se cierra galería ampliada */
			reseteaScroll();
    	}
    	if (document.getElementById("boton-control").checked == true) { /* Oculta menú */
    		document.getElementById("boton-control").checked = false; 
    	}
		if (document.getElementById("boton-mapa").checked == true) { /* Oculta mapa cabecera */
			document.getElementById("boton-mapa").checked = false; 
		}
    }
}
/* Función para cerrar <iframe> que contiene terminos.html cuando es un elemento flotante ** Actúa en: contacto.html (llamado en verEscapeIframe()), galeria.html (llamado en muestraDiv()) y pie.html (llamado en verEscapeIframe()) */
function cerrarAspa() {
	reseteaScroll();
	if (usado) { /* Si se ha abierto términos en contacto.html o pie.html existirá y se ocultará */
		usado.style.display = "none"; 
		/*document.documentElement.style.overflow = "auto";  Resetea el overflow: hidden que le otorga gestionPopUps() */
		usado = undefined; /* Limpiamos valor */
	} else {
		document.getElementById("contenedor-ampli").className = " "; /* Oculta contenedor de la imagen ampliada en galeria.html */
		document.getElementsByClassName("imagen-ampli")[0].src = " ";
		clearTimeout(t); /* Previene que la función navegacionDinamica de galeria.html ejecute cuando se cierra galería ampliada */
		/*if (esTactil) { document.documentElement.style.overflow = "scroll"; }*/
	}
}
/* Función para mostrar u ocultar los elementos de navegación que acompañan a las imágenes ampliadas ** Actúa en galeria.html */
var ocultable = document.getElementsByClassName("ocultable");
var t;
function navegacionDinamica() {
	for (var i = 0; i < ocultable.length; i++) {
		ocultable[i].style.opacity = "1";
		document.getElementById("cerrar").style.opacity = "1";
	}
	if (document.getElementById("contenedor-ampli")) {
		document.getElementById("contenedor-ampli").onmousemove = function() { ratonDinamico(); }
		document.getElementById("contenedor-ampli").onclick = function() { ratonDinamico(); }
		document.getElementById("contenedor-ampli").ontouchend = function() { tactilDinamico(); }
	}
	function ratonDinamico() {
		clearTimeout(t);
		t = setTimeout(function() { 
			for (var i = 0; i < ocultable.length; i++) {
				ocultable[i].style.opacity = "0";
			}
			document.getElementById("cerrar").style.opacity = ".5";
		},5000);
		for (var i = 0; i < ocultable.length; i++) {
			ocultable[i].style.opacity = "1";
			document.getElementById("cerrar").style.opacity = "1";
		}
	}
	function tactilDinamico() {
		clearTimeout(t);
		t = setTimeout(function() { 
			for (var i = 0; i < ocultable.length; i++) {
				ocultable[i].style.opacity = "0";
			}
			document.getElementById("cerrar").style.opacity = ".5";
		},5000);
		for (var i = 0; i < ocultable.length; i++) {
			ocultable[i].style.opacity = "1";
			document.getElementById("cerrar").style.opacity = "1";
		}
	}
}
/* Funciones que mostrarán en grande la imagen clicada ** Actúa en: galeria.html */
var indiceImagen = 1; /* Variable que identifica la diapositiva actual en galeria.html*/
function compruebaDiap(indiceImagen) {
	var x = document.getElementsByClassName("imagen-mini"); /* Guardamos elemento imagen-mini */
	if (indiceImagen > x.length) { indiceImagen = 1; } /* Se vuelve al principio si estamos en el final */
	if (indiceImagen < 1) { indiceImagen = x.length; } /* Si estamos al principio y se quiere ir al final */	
	return indiceImagen;
}
function actualDiap(n) { 
	muestraDiap(indiceImagen = n); 
	gestionPopUps("galeria"); /* Llamada a función para prevenir scroll sobre el fondo */
}
function sumaDiap(n) { 
	indiceImagen += n;
	var errImg = document.getElementsByClassName("img-error");
	var indiceImagenAux = indiceImagen;
	indiceImagen = compruebaDiap(indiceImagen);
	if (document.getElementById("miImg" + indiceImagen).classList.contains("img-error")) { /* Si la imagen no se cargó correctamente la saltamos */
		indiceImagen += n;
		indiceImagen = compruebaDiap(indiceImagen);
		if (errImg.length > 1) { /* Si en total hay más de una imagen incorrecta comprobamos las siguientes para verificar la cantidad de imágenes que hace falta saltar */
			for (var v = 1; v <= errImg.length; v++) {
				if (document.getElementById("miImg" + indiceImagen).classList.contains("img-error")) {
					indiceImagen += n;
					indiceImagen = compruebaDiap(indiceImagen);
				}
			}
		}
	}
	muestraDiap(indiceImagen); 
}
var cerrar;
function muestraDiap(n) {
	var x = document.getElementsByClassName("imagen-mini"); /* Guardamos elemento imagen-mini */
	var caption = document.getElementById("caption");
	var cual = document.getElementById("cual");
	var imgNoFadder = document.getElementsByClassName("imagen-ampli")[0]; 
	var imgFadder = document.getElementsByClassName("fadder")[0];
	if (!imgFadder) { /* Condición para añadir clase que aplica animación para aparecer las imágenes */
		imgNoFadder.className += " fadder";
	} else if (imgFadder) {
		imgFadder.className = "imagen-ampli";
	}
	var img = document.getElementById("miImg" + n);  /* Guardamos imagen apuntada por n */
	var imgHD = img.src.slice(0,-4) + "HD" + img.src.slice(-4); /* Asignamos atributo src según el src de la imagen clicada */
	document.getElementsByClassName("imagen-ampli")[0].src = "";
	document.getElementsByClassName("imagen-ampli")[0].src = imgHD;
	document.getElementById("contenedor-ampli").className = "trans-galeria"; /* Anadimos clase para mostrar el contenedor oculto */
	navegacionDinamica(); /* Función en galeria.html que borra o muestra los elementos de navegación */
	cerrar = document.getElementById("cerrar"); /* Guardamos el contenedor que contiene el aspa de cerrar */
	cerrar.onclick = function() { cerrarAspa(); }
	caption.innerHTML = x[n-1].alt; /* Muestra el texto descriptivo de cada imagen */
	cual.innerHTML = n + "/" + x.length; /* Muestra la imagen actual */
}
/* Función para mostrar el <iframe> oculto por defecto que contiene terminos.html y para cerrar si se pulsa escape ** Actúa en: contacto.html, pie.html */
var usado; /* Variable usada para verEscapeIframe(), cerrar() y cerrarAspa() */ 
function verEscapeIframe(e) {
	var iOS = !!navigator.platform && /iPad|iPhone|iPod|iPad Simulator|iPhone Simulator|iPod Simulator/.test(navigator.platform);
	if (iOS) {
		document.getElementById("ios-scroller").className = "si-ios";
	} 
	usado = document.getElementById("contenedorifr-pie");
	usado.style.display = "block"; 
}
/* Función que establece los campos requeridos en el formulario y comprueba los correctos, modifica el mensaje de validación ** Actúa en: contacto.html */
function requeridoInicial() {
	var captcha = document.getElementsByClassName("g-recaptcha")[0];
	var requeridos = document.getElementsByClassName("reque");
	var respCaptcha = grecaptcha.getResponse();
	respCaptcha == 0 ? captcha.className = "g-recaptcha requerido" : captcha.className = "g-recaptcha"; /* Comprobamos si se ha marcado el captcha */
	//respCaptcha == 0 && captcha.className == "g-recaptcha" ? captcha.className += " requerido" : captcha.className;	
	if (document.getElementById("termycond").checked == false) { /* Comprobamos si está marcado el input */
		document.getElementById("termycond").className == "reque requerido" ? document.getElementById("termycond").className : document.getElementById("termycond").className += " requerido";		
	}
	for (var x = 0; x < requeridos.length; x++) {
		if (requeridos[x].value == "" || /^\s*$/.test(requeridos[x].value)) { /* Comprobamos vacío o espacios en blanco */
			requeridos[x].className == "reque requerido" ? requeridos[x].className : requeridos[x].className += " requerido";
			requeridos[x].setCustomValidity("Rellena este campo correctamente"); /* Esto lo marca como inválido */
		} else {
			/*requeridos[x].setCustomValidity("");  Esto lo marca como válido */
			requeridoIndividual(requeridos[x]);
		}
	}
}
/* Función que comprueba lo que el usuario introduce mientras lo introduce ** Actúa en: contacto.html */
function requeridoIndividual(e) {
	if (/^\s*$/.test(e.value)) { /* Comprobamos vacío o espacios en blanco */
		if (e.value == "" || e.value == null) { /* Comprobamos si está vacío */
			e.className == "reque requerido" ? e.className = "reque" : e.className;
			e.setCustomValidity(""); /* Esto lo marca como válido */
		} else {
			e.className == "reque requerido" ? e.className : e.className += " requerido";
			e.setCustomValidity("Solamente hay espacios en blanco"); /* Esto lo marca como inválido */
		}
	} else {
		e.setCustomValidity(""); /* Esto lo marca como válido */
		if (!e.validity.valid) { /* Si es inválido */
			e.setCustomValidity("");
			if (e.type == "email") {
				e.setCustomValidity("Introduce una dirección válida");
				e.className == "reque requerido" ? e.className : e.className += " requerido";
			} else {
				e.setCustomValidity("Rellena este campo correctamente");
			}
		} else { /* Si es válido */
			e.className == "reque requerido" ? e.className = "reque" : e.className;
		}
	}
}
/* Función que activa el botón de envío del formulario cuando se ha respondido correctamente el captcha y se produce evento checked y el resto de campos del formulario han sido rellenados ** Actúa en: contacto.html */
function activarBoton() {
	var respCaptcha = grecaptcha.getResponse();
	if (respCaptcha != 0) { document.getElementsByClassName("g-recaptcha")[0].className = "g-recaptcha"; }
	if(document.getElementById("termycond").checked == true && respCaptcha.length != 0 && document.getElementById("nombre").checkValidity() == true && document.getElementById("email").checkValidity() == true && document.getElementById("consulta").checkValidity() == true) {
		document.getElementById("botonEnviar").disabled = false;			
		document.getElementById("insiste").style.display = "none";	
		document.getElementsByClassName("g-recaptcha")[0].className = "g-recaptcha";
	} else if (document.getElementById("termycond").checked == false || respCaptcha.length == 0 || document.getElementById("nombre").checkValidity() == false || document.getElementById("email").checkValidity() == false || document.getElementById("consulta").checkValidity() == false) {
		document.getElementById("botonEnviar").disabled = true;
		document.getElementById("insiste").style.display = "block";	
		if (document.getElementById("termycond").checked == false) {
			//document.getElementById("insiste").style.display = "block";	
		}
	}
} 
/* Función que deshabilita el boton de envío ** Actúa en: contacto.html */
function expirarBoton() {
	document.getElementById("botonEnviar").disabled = true;
	document.getElementById("insiste").style.display = "block";

	document.getElementById("captcha").className += " requerido"; // Añadido de clase requerido
	document.getElementById("termycond").className += " requerido"; // Añadido de clase requerido
}
/* Función que oculta mensaje de resultado de envío de formulario ** Actúa en: contacto.html */
function cerrarMensaje() {
	document.getElementById("resultado-formu").style.display = "none";
	document.getElementById("resultado-formu").innerHTML = "<div id='cargante-uno'></div><div id='cargante-dos'></div>"; /* Restablece el contenido ya que lo modificamos para mostrar el resultado de la consulta a la bdd */
}
/* Función para mostrar un aviso al pulsar reiteradas veces sobre el botón de envío cuando se encuentra deshabilitado ** Actúa en: contacto.html */
var cont = 0;
function insisteClic() {
	cont++;
	if (cont > 5) {
		alert("¡Revisa los campos marcados!");
		cont = 0;
	}
}
/* Función que comprueba si el usuario utiliza iOS ** Actúa onload en pie.html ---- METIDO EN verEscapeIframe()
function esIos() {
	var iOS = !!navigator.platform && /iPad|iPhone|iPod|iPad Simulator|iPhone Simulator|iPod Simulator/.test(navigator.platform);
	if (iOS) {
		document.getElementById("ios-scroller").className = "si-ios";
	} 
}*/