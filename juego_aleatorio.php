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
	<title>JUEGO ALEATORIO</title>
    <link rel="shortcut icon" href="imgs/bestjuegos.png">
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
	<section class="juego_aleatorio">
    <style>
.aleatorio_img {
  max-width: 200px;
  height: auto;
  
}
.juego_aleatorio{
    margin: 0 auto;
  text-align: center;
}
h2,h1{
    color: #0066c0;
}
.btn-negro2 {
                background-color: black;
                color: white;
                padding: 5px;
                font-size: 30px;
                border: none;
                background-color: #000;
		    border-radius: 4px;
            }
</style>
    <br><br>    
    <h1 style="color:white;">¿A que jugamos hoy?</h1>
    <br><br>
    <!-- Formulario para juego_aleatorio"-->
    <form action="juego_aleatorio.php" method="post">
        <input class="btn-negro2" type="submit" name="juego" value="Jugar" />
        <br><br>
    </form>
    <br><br>
    <?php
    // Comprobar si el botón "juego" ha sido presionado
    if (isset($_POST["juego"])) {
        // Llamar a la función "obtener_juego_aleatorio" y almacenar los datos del juego en variables separadas
        $juego_aleatorio = obtener_juego_aleatorio($con);
        $id_juego = $juego_aleatorio["id_juego"];
        $nombre = $juego_aleatorio["nombre"];
        $plataforma = $juego_aleatorio["plataforma"];
        $link = $juego_aleatorio["link"];
        // Imprimir los detalles del juego seleccionado, incluyendo el nombre, una imagen relacionada, la plataforma y el enlace
        echo "<h2 style='color:white;'>Este es tu juego del dia!!: " . $nombre . "</h2><br>";
        echo "<img class='aleatorio_img' src='imgs/imagen_$id_juego.png' alt='$nombre'>";
        echo "<p><h2 style='color:white;'>Plataforma:</h2><br> <p style='color: red;'>$plataforma</p><br>";
        echo "<p><h2 style='color:white;'>Enlace:</h2><br> <a href='$link'>$link</a></p>";
    }
        ?>
        <br><br><br><br><br><br><br><br><br>
    </section>
 <!-- Creamos el footer y las columnas -->   
 <footer style="position: relative; margin-top: 75px;left: 0;right: 0;" class="footer">
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