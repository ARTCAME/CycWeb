<!DOCTYPE html>
<!--[if lte IE 9]>
    <script type="text/javascript"> 
        window.location = "html/auxiliar/precursorbrowser.html";
    </script>
    <?php
        // Si no hay Javascript
        /* HOLA XOXO */
        if (preg_match("/MSIE/",$_SERVER['HTTP_USER_AGENT'])) header("Location: html/auxiliar/precursorbrowser.html");
    ?>
<![endif]-->
<html>  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="rgba(0,0,0,1)"> <!-- Para teñir el encabezado y barra de búsqueda en android -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Somos una empresa familiar que desde siempre buscamos ofrecer la mejor calidad en todos nuestros productos. Situados en el corazón del barrio de las Delicias en Zaragoza, nos especializamos en productos de la zona de Aragón y de todo el ámbito nacional como son el jamón de Teruel, de Teruel con denominación de origen (D.O.), jamón ibérico de cebo, jamón ibérico de bellota, espárragos con denominación de origen Navarra, entre otros muchos productos.">
    <!-- Prevenimos zoom -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><!--, user-scalable=no"-->
    <link id="favicon" rel="shortcut icon" href="img/logos/favicon.png" type="image/png">
    <title>Xarcutería C&amp;C - Tienda de jamones, charcutería en Zaragoza</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="css/imprimir.css" media="print">
    <script src="js/main.js"></script>
    <script>
        /* Google Analytics */
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-106300288-1', 'auto');
        ga('send', 'pageview');
    </script>
    <style type="text/css">
        /*---------------------------------------------------------------------- 
        NO JAVASCRIPT */

        /*
         * NOTA: Internet Explorer no aplica estilos a los elementos especificándolos como anidados por lo que se rompe 
         * la norma de indicar toda la anidación para los elementos dentro de <noscript>
         */

        /* COMUNES */

        /* Estilos para los botones checkbox que hacen de control para mover el mensaje flotante de <noscript>; oculto siempre */
        input#boton-nojs-cabe { display: none; } /* cabecera.html */

        /* Estilos que se aplican a los elementos <span> contenidos por <label> cuando se produce el evento checked */
        input#boton-nojs-cabe:checked + label span { position: fixed; top: 80%; } /* cabecera.html */

        /* Estilos para el mensaje flotante */
        span.mensaje-nojs { /* Todos */
            background-color: rgba(255, 255, 255,.9);
            border-bottom: 1px solid rgba(0,0,0,1);
            border-top: 1px solid rgba(0,0,0,1);
            -webkit-box-shadow: 0 0 15px 0 rgba(0,0,0,.75); 
            box-shadow: 0 0 15px 0 rgba(0,0,0,.75);
            color: black;
            font-family: "pt_serifitalic";
            font-size: 14px;
            height: auto;
            padding: 10px 0;
            position: fixed; left: 0; top: 290px;
            text-align: center;
            transition: all .5s;
            width: 100%;
            z-index: 999999998; 
        }

        /* FIN COMUNES */

        /* contacto.html */

        /* Mapa sin Javascript */
        /* Estilos para el elemento contenedor */
        noscript#ns-mapa {
            margin: 0 auto;
            max-width: 640px;
            max-height: 640px;
        }

        a#ircontacto { padding: 0!important; }

        /* Estilos para el elemento <a> que dirige a Google Maps al clicar sobre mapa, contiene <img> del mapa */
        a#link-imgmapa {
            background-size: cover;
            display: block;
            height: 0;
            overflow: hidden;
            padding-bottom: 50%;
            position: relative;
            width: 100%;
        }

        /* Estilos para la imagen estática del mapa */
        a#link-imgmapa img#imgmapa {
            height: 640px;
            margin-left: -320px; /* La mitad del ancho */
            margin-top: -320px; /* La mitad de la altura */
            position: absolute; left: 50%; top: 50%;
            width: 640px;
        }

        /* Formulario sin Javascript */
        /* Estilos de fuente comunes */
        div#avisonojs,
        div#avisonojs a { 
            font-family: "pt_serifitalic"!important;
            font-size: 14px!important;  
            line-height: 18px;
            padding: 0 10px;
        }

        /* Estilos para el mensaje en texto */
        div#avisonojs { 
            background-color: rgba(255,255,255,1);
            border-bottom: 1px solid rgba(0,0,0,1);
            border-top: 1px solid rgba(0,0,0,1);
            color: rgba(0,0,0,1);
            height: auto;
            padding: 10px 0;
            position: absolute; bottom: 25%;
            text-align: center;
            width: 100%;
        }

        /* Estilos para el elemento contenedor que se posicionará por encima del formulario "desactivándolo" */
        div#ns-form {
            background-color: rgba(255,255,255,.3);
            -webkit-box-shadow: 0 0 50px 5px rgba(255,255,255,.2) inset; 
            box-shadow: 0 0 50px 5px rgba(255,255,255,.2) inset;
            box-sizing: border-box;
            height: 100%;
            position: absolute; bottom: 0; left: 0; right: 0; top: 0;
            width: 100%;
            z-index: 1;
        }

        /* FIN contacto.html */

        /*---------------------------------------------------------------------- 
        FIN NO JAVASCRIPT */
        /* Estilos para el contenedor de mensaje de cookies */
        #cookies-contenedor {
            background-color: rgba(255,255,255,.9);
            border-bottom: 1px solid rgba(0,0,0,1);
            border-top: 1px solid rgba(0,0,0,1);
            -webkit-box-shadow: 0 0 15px 0 rgba(0,0,0,.75); 
            box-shadow: 0 0 15px 0 rgba(0,0,0,.75);
            display: none; 
            color: black;
            font-family: "pt_serifitalic";
            font-size: 14px;
            height: auto;
            padding: 10px 0;
            position: fixed; left: 0; bottom: 90px;
            text-align: center;
            transition: all .5s;
            width: 100%;
            z-index: 999999998; 
        }
    </style>
</head>
<body>
    <!-- Facebook -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.11';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>  
    <div id="pega-footer">
        <?php
            // Si se ha pedido una página se obtiene y muestra, si no es así se muestra la página inicio.html
            $pagina = isset($_GET["p"]) ? strtolower($_GET["p"]) : "inicio";
            // El fragmento de html que contiene la cabecera de nuestra web
            // require_once(html/"cabecera.html");
            include "html/cabecera.html";
            /* Estamos considerando que el parámetro enviando tiene el mismo nombre del archivo a cargar, si este no fuera así
            se produciría un error de archivo no encontrado */
            // require_once "../html/contenidos/".$pagina.".html";
            include "html/contenidos/".$pagina.".html";
        ?>
        <!-- Elemento solo visible en la vista de impresión -->
        <div class="contenedor-imprimir">
            <div class="formas-contacto-imprimir">
                <div class="contacto-dire-imprimir">
                    <span class="localizacion-imprimir" translate="no">
                        <span><strong>Charcutería C&amp;C</strong></span><br>
                        <span>Avenida de Madrid 223,</span><br>
                        <span>50017, Zaragoza </span>
                    </span>
                    <p class="contacto-hora-imprimir"><strong>Horario de apertura:</strong><br>
                        <span><strong>Lunes a viernes: </strong>9:00 - 14:00 y 17:00 - 20:30</span><br>
                        <span><strong>Sábados: </strong>9:00 - 14:00</span>
                    </p>
                    <span class="contacto-telf-imprimir">Teléfono: 976 33 82 37</span><br>
                    <span class="contacto-mail">Correo electrónico: contacto@charcuteriacyc.es</span>
                </div>
                <img class="imgmapa-imprimir" src="https://maps.googleapis.com/maps/api/staticmap?center=Avenida+Madrid+223,+Zaragoza&zoom=16&scale=2&size=300x245&maptype=roadmap&key=AIzaSyDPfCCZWxMxTJMt4haC7fpTE3-I8e71dCY&format=png&visual_refresh=true&markers=size:mid%7Ccolor:0xc93638%7Clabel:%7CCharcutería+CyC,+Avenida+Madrid+223,+50017+zaragoza" alt="Charcutería C&amp;C, Avenida Madrid 223, Zaragoza" title="Abrir en Google Maps">
            </div>
            <div class="pie-imprimir">
                <div class="pie-charcu">
                    &copy; 2017 · Charcutería C&amp;C
                </div>
                <div class="pie-hdmd">
                    <a href="">
                        <img class="aux-imgpie-hmbyart" src="img/handmade/HandmadeByArt.png" alt="Handmade By Art">
                    </a>
                </div>
            </div>
        </div>
        <?php
            // El fragmento de html que contiene el pie de página de nuestra web
            // require_once "/html/pie.html";
            include "html/pie.html";
        ?>
        <script>
            noscriptHack(); /* Función para mostrar elementos de la clase noscript */
        </script>
    </div>
    <div id="cookies-contenedor">
        <div>Para mejorar tu experiencia de navegación utilizamos cookies. Al continuar con tu visita entendemos que lo aceptas.<a href="html/auxiliar/terminos.html#politica-cookies" target="_blank" title="Ver términos y condiciones"> Más información.</a><br><strong><a onclick="PonerCookie();" href="javascript:void(0);" id="ok-cookies" title="Continuar navegando">Aceptar</a></strong></div>
    </div>
    <script type="text/javascript">
        /* Funciones para añadir cookie para saber si usuario ha aceptado las cookies...*/
        function getCookie(c_name){
            var c_value = document.cookie;
            var c_start = c_value.indexOf(" " + c_name + "=");
            if (c_start == -1){
                c_start = c_value.indexOf(c_name + "=");
            }
            if (c_start == -1){
                c_value = null;
            }else{
                c_start = c_value.indexOf("=", c_start) + 1;
                var c_end = c_value.indexOf(";", c_start);
                if (c_end == -1){
                    c_end = c_value.length;
                }
                c_value = unescape(c_value.substring(c_start,c_end));
            }
            return c_value;
        }
        function setCookie(c_name,value,exdays){
            var exdate = new Date();
            exdate.setDate(exdate.getDate() + exdays);
            var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
            document.cookie = c_name + "=" + c_value;
        }
         
        if(getCookie('avisocuki') != "1"){
            document.getElementById("cookies-contenedor").style.display = "block";
        }
        function PonerCookie(){
            setCookie('avisocuki','1',365);
            document.getElementById("cookies-contenedor").style.display = "none";
        }
    </script>
</body>
</html>