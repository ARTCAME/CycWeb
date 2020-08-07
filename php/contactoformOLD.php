<?php
	// Elimina los errores por defecto
	//error_reporting(0);
	//	mysqli_report(MYSQLI_REPORT_OFF); Turn off irritating default messages
	//	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); Detalle error no funciona
	
	// Log --> C:\wamp64\logs\php_log.log
	// ConfigLog --> C:\wamp64\bin\apache\apache2.4.25\bin\php.ini
	require "../recursos/PHPMailer/PHPMailerAutoload.php"; // Ver: github.com/PHPMailer/PHPMailer
	require_once "../recursos/captcha/recaptchalib.php"; // Librería para captcha

	$secret = "6LcZIygUAAAAAIrqjK9j5eFPdvpniJg0MYKaVJqO"; // Captcha clave secreta
	//$response = null; // Captcha
	//$reCaptcha = new ReCaptcha($secret); // Captcha

	if (isset($_POST["g-recaptcha-response"])) { // Si se ha establecido el captcha se verifica la respuesta
		/*$response = $reCaptcha->verifyResponse( 
			$_SERVER["REMOTE_ADDR"],
			$_POST["g-recaptcha-response"]
		);*/
		$compruebaRespuesta = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    	$response = json_decode($compruebaRespuesta,true);	
    	/*if($response->success) {
			echo("todo ok");
			return;
		} else */if ($response["success"] == false) { /* Se comprueba que el captcha sea correcto y si no lo fuera se para toda ejecución posterior y se notifica por e-mail */
			$result = "<div class='resultado'><strong>¡El contacto no se pudo enviar!</strong><br>Parece que tenemos algún problema para verificar el captcha.<br>Puedes volver a intentarlo y si el problema persiste contacta con nosotros por cualquiera de las <a href='#contacto-dire'>otras vías disponibles</a>.<br>Incencia comunicada automáticamente<span class='cerrar' onclick='cerrarMensaje()' title='Cerrar'>&times;</span></div>";
			$detalle = "Error al comprobar reCaptcha";
			enviarEmail($response["error-codes"],$response["error-codes"],$result,$detalle);
			echo($result); // Lo imprimimos para que la función .Ajax lo registre en la variable data
			return;
		}
	}


	
	// Si el captcha se rellena correctamente se podrá enviar, si no no pasará nada (por ejemplo en recargas de la página o al volver atrás)
	if ($response != null && $response["success"]) {
		// Conexiones de usuarios SQL 
		// Datos de conexión SQL comunes a todas
		$servername = "localhost";
		// $bd = "cyc"; HE
		$bd = "jxlcvuub_cyc";
		// Error de conexión común para todas
		$errorConexion = "<div class='resultado'><strong>No se ha podido crear una conexión con la base de datos.</strong><br>Puedes volver a intentarlo y si el problema persiste contacta con nosotros por cualquiera de las <a href='#contacto-dire'>otras vías disponibles</a>.<br>Incidencia registrada automáticamente<span class='cerrar' onclick='cerrarMensaje()' title='Cerrar'>&times;</span></div>";
		// Comprobación de conexión de usuario de guardado de registro, si este funciona comprobamos los demás
		// $userReg = "loggercyc"; HE
		$userReg = "jxlcvuub_logger";
		// $passReg = "charcharcucu"; HE
		$passReg = "5TqC28psXUIt";
		$conReg = new mysqli($servername,$userReg,$passReg,$bd); // Creamos y guardamos la conexión
		$conReg->set_charset("utf8"); // Usamos codificación UTF-8
		if ($conReg->connect_errno) { // Si la conexión da error generamos registro en archivo de texto y envío de e-mail
			$result = $errorConexion;
			$detalle = "Error en conexión inicial con usuario REGISTRO";
			enviarEmail($conReg->connect_error,$conReg->connect_errno,$result,$detalle); // ERROR GRAVE: Envío de e-mail con el error
			echo($result); // Lo imprimimos para que la función .Ajax lo registre en la variable data
			return;
		} else {
			// Comprobación de conexión de usuario de consulta 
			// $userSelect = "consultercyc"; HE
			$userSelect = "jxlcvuub_consult";
			// $passSelect = "carchuchucar"; HE
			$passSelect = "TqqwxwIh8KB5";
			$conSelect = new mysqli($servername,$userSelect,$passSelect,$bd); // Creamos y guardamos la conexión
			$conSelect->set_charset("utf8"); // Usamos codificación UTF-8
			if ($conSelect->connect_errno) { // Si la conexión da error se muestra mensaje y código de error
				$result = $errorConexion;
				$detalle = "Error en conexión inicial con usuario SELECT";
				enviarEmail($conSelect->connect_error,$conSelect->connect_errno,$result,$detalle); // ERROR GRAVE: Envío de e-mail con el error
				creacionRegistroEnBD($conReg,$conSelect->connect_error,$conSelect->connect_errno,$result,NULL); // Guardado de registro en base de datos
				echo($result); // Lo imprimimos para que la función .Ajax lo registre en la variable data
				return;
			}
			// Comprobación de conexión de usuario de inserción 
			// $userInsert = "insertercyc"; HE
			$userInsert = "jxlcvuub_insert";
			// $passInsert = "charcucharcu"; HE
			$passInsert = "3nS3S8W0hseT";
			$conInsert = new mysqli($servername,$userInsert,$passInsert,$bd); // Creamos y guardamos la conexión
			$conInsert->set_charset("utf8"); // Usamos codificación UTF-8
			if ($conInsert->connect_errno) { // Si la conexión da error se muestra mensaje y código de error 
				$result = $errorConexion;
				$detalle = "Error en conexión inicial con usuario INSERT";
				enviarEmail($conInsert->connect_error,$conInsert->connect_errno,$result,$detalle); // ERROR GRAVE: Envío de e-mail con el error
				creacionRegistroEnBD($conReg,$conInsert->connect_error,$conInsert->connect_errno,$result,NULL); // Guardado de registro en base de datos
				echo($result); // Lo imprimimos para que la función .Ajax lo registre en la variable data
				return;
			}
		}	
			
		/* Lógica para comprobación del formulario: para iniciarla se comprueba que el botón de envío haya sido pulsado, siendo así se recogen los datos introducidos en los campos y los que pueden tener valores vacíos, si lo estuvieran, se les asigna valor NULL. Seguido se comprueba el número de consultas con el correo electrónico y se informa del error si fuera de uso reiterado. Finalmente mostraremos si el e-mail ha tenido un uso reiterado o si no lo ha tenido ejecutaremos la inserción del registro */	
		if (isset($_POST["boton"]) && isset($_POST["termycond"]) && $conReg && $conSelect && $conInsert) {
		// Si se obtiene por post el botón quiere decir que se ha enviado el formulario y se leen el resto de elementos por post, las conexiones $conReg, $conInsert y $conSelect deberán ser correctas para poder registrar en la base de datos la consulta
			$nombre = $_POST["nombre"]; // HTML5 nunca lo enviará vacío 
			$apellidos = !empty($_POST["apellidos"]) ? "" . $_POST["apellidos"] . "" : NULL; // Puede venir vacío, lo comprobamos y asignamos NULL si así fuera
			$email = $_POST["email"]; // HTML5 nunca lo enviará vacío 

			$telefono = !empty($_POST["telefono"]) ? "" . $_POST["telefono"] . "" : NULL; // Puede venir vacío, lo comprobamos y asignamos NULL si así fuera
			$consulta = $_POST["consulta"];	// HTML5 nunca lo enviará vacío 
			$publicidad = $_POST["aceptpubli"] == "false" ? "" . 0 . "" : "" . 1 . ""; // JS le asigna true si se acepta y false si no
			
			// Prevención de inyección SQL
			$stmt = $conSelect->prepare("SELECT COUNT(id_consulta) FROM `jxlcvuub_cyc`.`consultas` WHERE email=? AND CURDATE() = DATE(fecha_creacion);");
			if ($conSelect->error) { // Si la consulta produce error
				$result = "<div class='resultado'><strong>No se ha podido comprobar la base de datos y el envío del formulario ha fallado.</strong><br>Puedes volver a intentarlo y si el problema persiste contacta con nosotros por cualquiera de las <a href='#contacto-dire'>otras vías disponibles</a>.<br>Incencia registrada automáticamente<span class='cerrar' onclick='cerrarMensaje()' title='Cerrar'>&times;</span></div>";
				$detalle = "Error de ejecución de consulta SELECT";
				enviarEmail($conSelect->error,$conSelect->errno,$result,$detalle); // ERROR: Envío de e-mail con el error
				creacionRegistroEnBD($conReg,$conSelect->error,$conSelect->errno,$result,NULL); // Guardado de registro en base de datos
				echo($result);
				return;
			} 
			$stmt->bind_param("s",$email);
			$stmt->execute();
			$resultSelect = $stmt->get_result(); // Asignación del resultado
			$row = mysqli_fetch_row($resultSelect); // Guardado de los valores de la consulta
			$cont = $row[0]; // Cuenta de los valores

			if ($cont > 5) { // Si se ha utilizado el correo electrónico más de 5 veces el mismo día se muestra error
				$result = "<div class='resultado'><strong>Hoy tenemos registradas demasiadas consultas para el correo electrónico:</strong> " . $email . ".<br>Por favor, inténtalo de nuevo modificando la dirección de correo electrónico o utiliza cualquiera de las <a href='#contacto-dire'>otras vías disponibles</a> para contactar con nosotros.<span class='cerrar' onclick='cerrarMensaje()' title='Cerrar'>&times;</span></div>";
				creacionRegistroEnBD($conReg,"Consultas reiteradas con el mismo correo electrónico","5",$result,NULL); // Guardado de registro en base de datos
				echo($result);
				return;
			} else if ($resultSelect && $cont <= 5) { // Si el correo se ha usado 5 o menos veces y esa consulta ha podido ser resulta en $resultSelect (sin esta comprobación, si $resultSelect no tiene valor siempre será <= 5..)
				// Prevención de inyección SQL
				$stmt = $conInsert->prepare("INSERT INTO `jxlcvuub_cyc`.`consultas` (`id_consulta`,`nombre`,`apellidos`,`telefono`,`email`,`consulta`,`fecha_creacion`,`publicidad`) VALUES (NULL,?,?,?,?,?,DEFAULT,?);");
				if ($conInsert->error) { // Si la consulta produce error
					$result = "<div class='resultado'><strong>El contacto no se pudo enviar.</strong><br>Puedes volver a intentarlo y si el problema persiste contacta con nosotros por cualquiera de las <a href='#contacto-dire'>otras vías disponibles</a>.<br>Incencia registrada automáticamente<span class='cerrar' onclick='cerrarMensaje()' title='Cerrar'>&times;</span></div>";
					$detalle = "Error de ejecución de consulta INSERT";
					enviarEmail($conInsert->error,$conInsert->errno,$result,$detalle); // ERROR: Envío de e-mail con el error
					creacionRegistroEnBD($conReg,$conInsert->error,$conInsert->errno,$result,NULL); // Guardado de registro en base de datos
					echo($result);
					return;
				} else {
					$stmt->bind_param('ssssss',$nombre,$apellidos,$telefono,$email,$consulta,$publicidad);
					$stmt->execute();		
					$ultimoId = $stmt->insert_id; // Guardamos el último id que se ha insertado en la base de datos con la consulta previa
					$result = "<div class='resultado-correcto'><strong>Contacto enviado correctamente.</strong><br>En breve gestionaremos tu consulta.<br>¡Muchas gracias!<span class='cerrar' onclick='cerrarMensaje()' title='Cerrar'>&times;</span></div>";
					creacionRegistroEnBD($conReg,NULL,NULL,$result,$ultimoId); // Guardado de registro en base de datos
				}
			}
		} 
		$conInsert->close(); // Cierre de conexión
		$conSelect->close(); // Cierre de conexión
		$conReg->close(); // Cierre de conexión
	} else if (isset($_POST["boton"]) && empty($_POST["g-recaptcha-response"])) { // Si se vuelve a atrás y el botón queda habilitado verificamos que captcha no es correcto y mostramos error a usuario; es muy poco probable que suceda aunque se mantiene
		$result = "<div class='resultado'><strong>El contacto no se pudo enviar.</strong><br>Puedes volver a intentarlo y si el problema persiste contacta con nosotros por cualquiera de las <a href='#contacto-dire'>otras vías disponibles</a>.<br>Incencia comunicada automáticamente<span class='cerrar' onclick='cerrarMensaje()' title='Cerrar'>&times;</span></div>";
		enviarEmail("Captcha vacío",$response->errorCodes,$result,NULL); // Envío de e-mail para contabilizar respuestas
	}

	if (isset($result)) echo $result;

	// Función para la creación de un archivo de registro cuando no funcione el envío de e-mail 
	function creacionRegistroEnTXT($enviarError,$codigoError,$result,$detalle) {
		date_default_timezone_set("Europe/Madrid"); // Zona horaria predeterminada
		$registro = "Fecha: " . date("F j, Y, g:i a") . "\r\n" .
					"IP: " . $_SERVER["REMOTE_ADDR"] . "\r\n" .
					"Código de error: " . $codigoError . "\r\n" .
					"Descripción del error: " . $enviarError . "\r\n" .
					"Detalle del error: " . $detalle . "\r\n" .
					"Resultado mostrado: " . $result . "\r\n" .
					"Nombre: " . $_POST["nombre"] . "\r\n" .
					"Email: " . $_POST["email"] . "\r\n" .
					"Teléfono: " . $_POST["telefono"] . "\r\n" .
					"Consulta: " . $_POST["consulta"] . "\r\n\r\n" .
					"..................................................." . "\r\n\r\n";
		file_put_contents("./registro_".date("j.n.Y").".txt", $registro, FILE_APPEND);	// Guardado en archivo
	}

	// Función para el guardado de todos los movimientos de la base de datos
	function creacionRegistroEnBD($conReg,$enviarError,$codigoError,$result,$ultimoId) {
		$ip = $_SERVER["REMOTE_ADDR"];
		$nombre = !empty($_POST["nombre"]) ? "" . $_POST["nombre"] . "" : NULL; 
		$telefono = !empty($_POST["telefono"]) ? "" . $_POST["telefono"] . "" : NULL; 
		$email = !empty($_POST["email"]) ? "" . $_POST["email"] . "" : NULL; 
		$consulta = !empty($_POST["consulta"]) ? "" . $_POST["consulta"] . "" : NULL; 
		// Prevención de inyección SQL
		$stmt = $conReg->prepare("INSERT INTO `jxlcvuub_cyc`.`registro` (`id_registro`,`fecha_creacion`,`IP`,`codigoerror`,`descripcionerror`,`resultado`,`nombre`,`telefono`,`email`,`consulta`) VALUES (NULL,DEFAULT,?,?,?,?,?,?,?,?);");
		if ($conReg->error) { // Si la consulta produce error
			$detalle = "No se ha podido crear un registro en la tabla cyc.registro";
			enviarEmail($conReg->connect_error,$conReg->connect_errno,$result,$detalle); // ERROR GRAVE: Envío de e-mail con el error
		} 
		$stmt->bind_param("sissssss",$ip,$codigoError,$enviarError,$result,$nombre,$telefono,$email,$consulta);
		$stmt->execute();	
		$registroId = $stmt->insert_id; // Guardamos el último id que se ha insertado en la base de datos con la consulta previa
		if ($codigoError == NULL && $ultimoId != NULL) { // Si la variable $codigoError está vacía y se ha pasado valor en $ultimoId se modifica la última inserción para añadir la FK que nos da $ultimoId
			// Prevención de inyección SQL
			$stmt = $conReg->prepare("UPDATE `jxlcvuub_cyc`.`registro` SET id_consulta=? WHERE id_registro=?;");
			if ($conReg->error) { // Si la consulta produce error
				$detalle = "Registro incompleto - No se ha podido crear el vínculo con la FK en la tabla cyc.registro";
				enviarEmail($conReg->connect_error,$conReg->connect_errno,$result,$detalle); // ERROR GRAVE: Envío de e-mail con el error
			} else {
				$stmt->bind_param("ii",$ultimoId,$registroId);
				$stmt->execute();
				$detalle = "Registro completado correctamente";
				enviarEmail("No error","No error",$result,$detalle); // Envío de e-mail confirmando todo ok
			}
		}	
	}	
	
	// Función para enviar un e-mail
	function enviarEmail($enviarError,$codigoError,&$result,$detalle) {
		$mail = new PHPMailer;
		$mail->CharSet = "utf-8"; 
		//+ini_set("default_charset", "UTF-8"); 
		$mail->isSMTP();                        // Set mailer to use SMTP
		$mail->Host = "hl319.hosteurope.es";	// Specify main and backup SMTP servers
		$mail->Host = gethostbyname("hl319.hosteurope.es");
		$mail->SMTPAuth = true;                 // Enable SMTP authentication
		$mail->Username = "contacto@charcuteriacyc.es";         // SMTP username
		$mail->Password = "ZIui4KpitcWv";	// SMTP password
		$mail->SMTPSecure = "tls";              // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                      // TCP port to connect to
		$mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);										// Correct certificate verification
		$mail->setLanguage("es", "../recursos/PHPMailer/");	// Error language
		$mail->setFrom("contacto@charcuteriacyc.es");
		$mail->addAddress("contacto@charcuteriacyc.es"); // Add a recipient
		$mail->Subject = "". $detalle . "";
		$mail->Body = "Detalles del formulario de contacto:\n\n";	
		$mail->Body .= "Nombre: " . $_POST["nombre"] . "\n";
		$mail->Body .= "Apellidos: " . $_POST["apellidos"] . "\n";
		$mail->Body .= "E-mail: " . $_POST["email"] . "\n";
		$mail->Body .= "Teléfono: " . $_POST["telefono"] . "\n";
		$mail->Body .= "Consulta: " . $_POST["consulta"] . "\n\n";
		$mail->Body .= "Código del error: " . $codigoError . "\n";
		$mail->Body .= "Detalle del error: " . $enviarError . "\n\n";
		$mail->Body .= "Mensaje mostrado al usuario: ". $result . "\n\n";
		//$mail->SMTPDebug = 2;
		if (!$mail->send()) { // Si el e-mail no se envía se cambia el valor de $detalle para generar el log de error de envíos de e-mail, aún así el registro en la base de datos se podría hacer correctamente
			$detalle .= " // PHPMailer no pudo enviar el contacto. Error: " . $mail->ErrorInfo;
			//$detalle = '<div class="result_fail">El contacto no se pudo enviar</br>Error: ' . $mail->ErrorInfo . '</div>'; Este mensaje se le mostraría al usuario de ahí el código html
			//$result = "<div class='resultado-grave'>La conexión con la base de datos ha fallado y el reporte automático de incidencias también.<br>Por favor, contacta con nosotros por cualquiera de las otras vías disponibles. Disculpa las molestias.<br><a href='mailto:contacto.charcuteriacyc@gmail.com?Subject=Error de conexión y reporte de incidencias en charcuteriacyc.com' target='_top'>Reportar incidencia manualmente al administrador</a><span class='cerrar' onclick='cerrarMensaje()' title='Cerrar'>&times;</span></div>"; Este valor se usó para mostrar al usuario una ocurrencia grave en el sistema de reporte de incidencias, el sistema envía e-mail y si no registra
			creacionRegistroEnTXT($enviarError,$codigoError,$result,$detalle);
		}
	}
?>