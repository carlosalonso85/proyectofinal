<?php
// Iniciamos la sesión para poder acceder a las variables de sesión
session_start();
// Importamos el archivo que contiene la función para conectarse a la base de datos
require("basededatos.php");
// Establecemos la conexión a la base de datos
$con = conectar();
?>

<!DOCTYPE html>
<html>
<head>
	<title>CORREO</title>
    <link rel="shortcut icon" href="imgs/correo.png">
    <!-- Importamos los estilos CSS -->
	<link rel="stylesheet" type="text/css" href="css/estilo.css" />
</head>
<body style="background-image: url('https://eveniments.es/wp-content/uploads/2019/03/fondos-abstractos-para-paginas-web-wallpaper-hd-para-bajar-gratis-elegant-3d-abstract-wallpaper-2018-wallpapers-hd-en-2018-of-fondos-abstractos-para-paginas-web-wallpaper-hd-para-bajar-grati.jpg');">

    <!-- Creamos la barra de navegación -->
	<div class="navbar">
		<img  class="logo" src="imgs/Logo.png" alt="Mi logo">
		<div class="lista">
			<ul class="nav-links">
				<div>
					<li><a href="proyecto.php">HOME</a>
					<img class="logo2" src="imgs/home.png"></li>
				</div>
				<div>
					<li><a href="play.php">PLAYSTATION</a>
					<img class="logo2" src="imgs/ps3.png"></li>
				</div>
				<div>
					<li><a href="xbox.php">XBOX</a>
					<img class="logo2" src="imgs/xbox1.png"></li>
				</div>
				<div>
					<li><a href="nintendo.php">NINTENDO</a>
					<img class="logo2" src="imgs/nintendo2.png"></li>
				</div>
				<div>
					<li><a href="pc.php">ORDENADOR</a>
					<img class="logo2" src="imgs/steam2.png"></li>
				</div>
                <style>
.btn {
		display: inline-block;
		padding: 5px;
		font-size: 15px;
		color: #fff;
		background-color: #000;
		border-radius: 4px;
	}
	.btn:hover {
		background-color: red;
	}
</style>

<?php

// Verificar si la variable de sesión existe
if (isset($_SESSION['nombre_usuario'])) {
    // Mostrar el nombre del usuario, botón de gestionar juegos y botón de cerrar sesión
    echo '<div>
                <p>Bienvenido, '.$_SESSION['nombre_usuario'].'</p>
                <li><a href="gestionarjuegos.php" class="btn">Gestionar Juegos</a></li>
                <br>
                <li><a href="logout.php" class="btn">Cerrar sesión</a></li>
            </div>';
} else {
    // Mostrar el enlace de registro
    echo '<div>
                <li><a href="inicio_sesion.php">REGISTRO</a>
                <img class="logo2" src="imgs/usuario-de-perfil.png"></li>
            </div>';
}
?>
      </ul>
      <style>
             .btn-negro {
                background-color: black;
                color: white;
                padding: 5px;
                font-size: 15px;
                border: none;
                background-color: #000;
		    border-radius: 4px;
            }
            .formulario {
        margin: 50px auto;
        max-width: 600px;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,.1);
    }

    .formulario label {
        display: block;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .formulario input[type="text"],
    .formulario input[type="email"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 2px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .formulario input[type="submit"] {
        background-color: #000;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 18px;
        cursor: pointer;
    }

    .formulario input[type="submit"]:hover {
        background-color: #333;
    }

    .formulario p {
        margin-top: 10px;
        font-size: 16px;
        color: #008000;
    }
            </style>
            <!-- Creamos el formulario de búsqueda por nombre de juego -->
			<div class = "busquedas">
      
                <div class ="busquedatexto">
                <form action="buscarjuegos.php" method="post">
                <input type="text" name="nombre" id="nombre" placeholder="Buscar juegos...">
                <input class="btn-negro" type="submit" value="Buscar">
                </form>
                </div>

            <!-- Creamos el formulario de búsqueda por género de juego -->
                <div class="busquedagenero">
                    <form method='post' action='busqueda.php'>
                    <?php
                    // Creamos una instancia de la clase Database
                    $db = new Database();
                    // Ejecutamos una consulta para obtener todos los géneros de juegos distintos
                    $db->query("select distinct(genero) from juegos");
                    // Obtenemos los resultados de la consulta
                    $resultado_generos = $db->rows();
                    ?>
                    <br/>
                    Selecciona el Género:
                    
                    <select name='genero'>
                      
                            <?php
                            // Iteramos sobre el resultado de la consulta y creamos una opción por cada género
                            foreach($resultado_generos as $genero){
                                echo "<option value='".$genero['genero']."'>".$genero['genero']."</option>";
                            }
                            ?>
                            <br/><br/>
                            <input class="btn-negro" type='submit'/>
                            
                            </form>
                            <br/>
                    </select>
                </div>
            </div>
		
		</div>
	</div>
    <?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$_SESSION['sent'] = false; // Inicializar la variable de sesión como falsa

if(isset($_POST['submit'])) {
    $to = $_POST['email']; // Obtener la dirección de correo electrónico del campo de entrada
    $subject = "TE ENVIAMOS DESDE LA WEB DEL EQUIPO 10 LOS MEJORES JUEGOS";
    $name = $_POST['name'];
    //Costruimos el html que va a recibir por correo
    $message = $message = '
    <html>
    <head>
    </head>
    <body>
        
        <div>
            <p>Hola,</p>
            <p>Te acabamos de mandar los mejores juegos con sus enlaces para que los guardes en tu correo:</p>
            <div>
                
                
                    <div class="imagen-correo">
                        <h3>POKEMON ESCARLATA</h3>
                        
                        <a href="https://www.eneba.com/steelbook-pokemon-escarlata-nuevo-e6adb090"><img width="20%" src="https://uvejuegos.com/img/caratulas/68029/pokemon-escarlata.jpg" alt="Imagen de correo"></a>
                        <br><br>
                        <a href="https://www.eneba.com/steelbook-pokemon-escarlata-nuevo-e6adb090">COMPRA YA TU JUEGO</a>
                    </div>
                    
                    <div class="imagen-correo">
                        <br><br>
                        <h3>Assassins Creed Valhalla</h3>
                        <a href="https://www.eneba.com/uplay-assassins-creed-valhalla-season-pass-dlc-uplay-key-europe"><img width="20%" src="https://sm.ign.com/t/ign_es/screenshot/a/assassins-/assassins-creed-valhalla-box-art_rua2.1080.jpg" alt="Imagen de correo"></a>
                        <br><br>
                        <a href="https://www.eneba.com/uplay-assassins-creed-valhalla-season-pass-dlc-uplay-key-europe">COMPRA YA TU JUEGO</a>
                    </div>
            
            </div>
            <p>¡Gracias por utilizar el formulario del grupo10!</p>
        </div>
    </body>
</html>';

    $mail = new PHPMailer(true); // Iniciar la clase PHPMailer

    try {
        //Configuración del servidor
        $mail->SMTPDebug = 0; // 0: Desactivar depuración, 1: Mensajes de depuración básicos, 2: Mensajes de depuración completos
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Reemplazar con la dirección del servidor SMTP de tu proveedor de correo
        $mail->SMTPAuth = true;
        $mail->Username = 'grupo10videojuegos@gmail.com'; // Reemplazar con la dirección de correo electrónico del remitente
        $mail->Password = 'ekgullikbaaewxga'; // Reemplazar con la contraseña del remitente
        $mail->SMTPSecure = 'SSL'; // TLS o SSL según corresponda
        $mail->Port = 587; // Puerto SMTP

        //Destinatario y mensaje
        $mail->setFrom('tucorreo@gmail.com', $name);
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send(); // Enviar el correo electrónico
        $_SESSION['sent'] = true; // Establecer la variable de sesión como verdadera
    } catch (Exception $e) {
        echo 'El mensaje no pudo ser enviado. Error: ', $mail->ErrorInfo;
    }
}
?>

<div class="formulario">
    
    <form method="post" action="">
        <label for="name">RECIBE LOS MEJORES JUEGOS EN TU CORREO</label>
        <label for="name">Nombre de GAMER:</label>
        <input type="text" name="name" required>
        <br>
        <br><label for="email">Correo electrónico:</label>
        <input type="email" name="email" required>
        <br>
        <br><input class="btn-negro" type="submit" name="submit" value="Enviar">
        <?php if($_SESSION['sent']): ?> <!-- Verificar si la variable de sesión es verdadera -->
        <p>Tu mensaje ha sido enviado</p>
        <?php $_SESSION['sent'] = false; ?> <!-- Restablecer la variable de sesión como falsa -->
    <?php endif; ?>
    </form>
</div>

 <!-- Creamos el footer y las columnas -->   
 <footer style="position: relative; margin-top: 30px;left: 0;right: 0;" class="footer">
        <div class="columna">
            <h3>Sobre el proyecto</h3>
            <br>
            <ul>
                <li><img width="30px" src="imgs/grupo.png">
                <a href="nosotros.php" style="text-decoration:none; color: white;">Nosotros</a></li>
					
                <li><img width="30px" src="imgs/contactenos.png">
                <a href="contactos.php" style="text-decoration:none; color: white;">Contactos</a></li> 
            </ul>
        </div>
        <div class="columna">
        <h3>Mucho Más...</h3>
            <br>
            <ul>
                <li><img width="35px"  src="imgs/adivina.png">
                <a href="adivina.php" style="text-decoration:none; color: white;">Adivina el juego</a></li>
					
                <li><img width="30px" src="imgs/bestjuegos.png">
                <a href="juego_aleatorio.php" style="text-decoration:none; color: white;">Juego Aleatorio</a></li> 

                <li><img width="30px"  src="imgs/correo.png">
                <a href="correo.php" style="text-decoration:none; color: white;">Recibe los mejores juegos</a></li>
            </ul>
        </div>
        <div class="columna">
            <h3>Siguenos:</h3>
            <br>
            <ul>
                <a href="https://www.twitter.com"><img src="imgs/twitter2.png" width="30px"/></a>
                <a href="https://www.facebook.com"><img src="imgs/facebook2.png" width="30px"/></a>
                <a href="https://www.instagram.com"><img src="imgs/instagram2.png" width="30px"/></a>
                
            </ul>
        </div>
    </footer>
</body>
</html>

