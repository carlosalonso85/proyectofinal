<?php
// Importamos el archivo que contiene la función para conectarse a la base de datos
require_once("basededatos.php");
// Creamos una instancia de la clase Database
$db = new Database();
?>

<!DOCTYPE html>
<html>
<head>
	<title>BUSCAR JUEGOS</title>
    <link rel="shortcut icon" href="imgs/lupa-de-busqueda.png">
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

    <?php
    // Conectar a la base de datos
  $conexion = mysqli_connect("localhost", "root", "", "trabajofin");
  if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
  }
  // Obtener el término de búsqueda desde el formulario
  $termino = $_POST["nombre"];
  if (strlen($termino) < 3) {
    die("El término de búsqueda debe tener al menos 3 caracteres.");
  }
   // Realizar la consulta SQL para obtener los juegos que coinciden con el término de búsqueda
  $sql = "SELECT * FROM juegos WHERE nombre LIKE '%$termino%'";
  $resultado = mysqli_query($conexion, $sql);
  if (!$resultado) {
    die("Error al ejecutar la consulta: " . mysqli_error($conexion));
  }
  // Mostrar los resultados en una tabla HTML
  echo "<br><h2 style='font-family: Comic Sans MS, sans-serif; font-size: 30px; color: white; text-align: center;'>Resultados de la búsqueda para: $termino </h2><br><br><br>";
  if (mysqli_num_rows($resultado) > 0) {
    echo "<table>";
    echo "<tr>
      <th style='padding: 10px;font-family: Comic Sans MS, sans-serif; font-size: 25px; color: white; text-align: left;'>Imagen</th>
      <th style='padding: 10px;font-family: Comic Sans MS, sans-serif; font-size: 25px; color: white; text-align: left;'>Nombre</th>
      <th style='padding: 30px;font-family: Comic Sans MS, sans-serif; font-size: 25px; color: white; text-align: left;'>Plataforma</th>
      <th style='padding: 30px;font-family: Comic Sans MS, sans-serif; font-size: 25px; color: white; text-align: left;'>Link</th>
      </tr>";
    // Mostrar cada fila de resultado en una fila de la tabla
    while ($fila = mysqli_fetch_assoc($resultado)) {
      echo "<tr>";
      echo "<td><img src='imgs/imagen_" . $fila["id_juego"] . ".png' alt='" . $fila["nombre"] . "' width='100' height='100'></td>";
      echo "<td style='padding: 10px;font-family: Comic Sans MS, sans-serif; font-size: 20px; color: white; text-align: left;'>" . $fila["nombre"] . "</td>";
      echo "<td style='padding: 10px;font-family: Comic Sans MS, sans-serif; font-size: 20px; color: white; text-align: left;'>" . $fila["plataforma"] . "</td>";
      echo "<td style='padding: 10px;font-family: Comic Sans MS, sans-serif; font-size: 20px; color: white; text-align: left;'><a  style='text-decoration:none' href='" . $fila["link"] . "'>" . $fila["link"] . "</a></td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    // Mostrar un mensaje si no hay resultados
    echo "<p style='font-family: Comic Sans MS, sans-serif; font-size: 20px; color: white; text-align: center;'>No se encontraron resultados.</p>";
  }
?>

<!-- Creamos el footer y las columnas -->
<footer style="position: relative; margin-top: 150px;left: 0;right: 0;" class="footer">
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











