<?php
// Iniciamos la sesión para poder acceder a las variables de sesión
session_start();
// Importamos el archivo que contiene la función para conectarse a la base de datos
require("basededatos.php");
// Establecemos la conexión a la base de datos
$con = conectar();
// Obtenemos los juegos de la plataforma Xbox desde la base de datos
$resultado = obtener_xbox($con);
?>


<!DOCTYPE html>
<html>
<head>
	<title>XBOX</title>
    <link rel="shortcut icon" href="imgs/xbox1.png">
    <!-- Importamos los estilos CSS -->
	<link rel="stylesheet" type="text/css" href="css/estilo.css" />
</head>
<body style="background-image: url('https://eveniments.es/wp-content/uploads/2019/03/fondos-abstractos-para-paginas-web-wallpaper-hd-para-bajar-gratis-elegant-3d-abstract-wallpaper-2018-wallpapers-hd-en-2018-of-fondos-abstractos-para-paginas-web-wallpaper-hd-para-bajar-grati.jpg');">

    <!-- Creamos la barra de navegación -->
	<div class="navbarx">
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
    <style>
    .centrar {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 50vh;
    margin-left: 430px;
}
</style>
<section style class="centrar">
<div class="play">
    <img class="logos" src="imgs\xbox44.png">
    <br><br><br>
    <H2 style='margin-left: 150px; color:white' class ="green">XBOX</H2>
</div>    
</section>
<style>
/* Contenedor de los juegos */
.juegos-container {
    text-align: center;
    margin-top: 50px;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}

/* Contenedor individual de cada juego */
.juego {
    margin: 20px;
    padding: 20px;
    box-sizing: border-box;
    max-width: 300px;
    text-align: center;
    border: 5px solid green;
}

/* Imagen del juego */
.imagen {
    max-width: 100%;
    height: auto;
}

/* Títulos del juego */
.juego h2 {
    color: #0066c0;
}

/* Comentarios */
.juego p {
    font: 80% sans-serif;
}

/* Enlace */
.juego a {
    color: #0066c0;
}
</style>

<?php
    
    echo "<div class='juegos-container'>";
    // Iteramos sobre los resultados de la consulta y mostramos la información de cada juego                       
    while ($fila = mysqli_fetch_assoc($resultado)) {
        // Obtener los datos de la fila actual
        $id_juego = $fila["id_juego"];
        $nombre = $fila["nombre"];
        $genero = $fila["genero"];
        $plataforma = $fila["plataforma"];
        $comentarios = $fila["comentarios"];
        $link = $fila["link"];
        // Generar la estructura HTML para mostrar la información y la imagen del juego
        echo "<div style='border: 5px solid green;' class='juego'>";
        echo "<div style='width: 200px;'>";
        echo "<img class='imagen' src='imgs/imagen_$id_juego.png' alt='$nombre'>";
        echo "<h2 style='color: white;'>$nombre</h2><br>";
        echo "</div>";
        echo "<p><h2 style='color: green;'>Género:</h2><br> <p style='color: white;'>$genero</p><br>";
        echo "<p><h2 style='color: green;'>Plataforma:</h2><br> <p style='color: white;'>$plataforma</p><br>";
        echo "<div class='comentarios'>";
        echo "<h2 style='color: green;'>Comentarios:</h2><br><p style='color: white;'>$comentarios</p><br>";
        echo "</div>";
        echo "<p><h2 style='color: green;'>Enlace:</h2><br> <a href='$link' style='color: white;'>$link</a></p>";
        echo "</div>";
    }
    echo "</div>";
    
?>

<!-- Creamos el footer y las columnas -->
<footer class="footerx">
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