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
	<title>GESTION JUEGOS</title>
    <link rel="shortcut icon" href="imgs/usuario-de-perfil.png">
    <!-- Importamos los estilos CSS -->
	<link rel="stylesheet" type="text/css" href="css/estilo.css" />
</head>
<body>
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
    <style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }
    textarea {
        width: 100%;
        height: 100px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        padding: 6px 12px;
        resize: vertical;
    }
    button[type="submit"] {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 12px 20px;
        border-radius: 4px;
        cursor: pointer;
    }
    button[type="submit"]:hover {
        background-color: red;
    }
</style>
    <?php

$conexion = mysqli_connect("localhost", "root", "", "trabajofin");
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Obtener los juegos de la base de datos
$query = mysqli_query($conexion, "SELECT * FROM juegos");
$juegos = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Procesar la actualización del comentario
if (isset($_POST['id_juego']) && isset($_POST['comentarios'])) {
    $id_juego = $_POST['id_juego'];
    $comentarios = $_POST['comentarios'];
    
    // Actualizar el comentario en la base de datos
    $stmt = mysqli_prepare($conexion, "UPDATE juegos SET comentarios = ? WHERE id_juego = ?");
    mysqli_stmt_bind_param($stmt, "si", $comentarios, $id_juego);
    mysqli_stmt_execute($stmt);

    // Guardar mensaje de éxito en una variable de sesión
    $_SESSION['success_message'] = 'Los comentarios se han guardado correctamente';
}
// Procesar la eliminación del juego
if (isset($_POST['eliminar_juego'])) {
    $id_juego = $_POST['id_juego'];
    
    // Eliminar el juego de la base de datos
    $stmt = mysqli_prepare($conexion, "DELETE FROM juegos WHERE id_juego = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_juego);
    mysqli_stmt_execute($stmt);

    // Guardar mensaje de éxito en una variable de sesión
    $_SESSION['success_message'] = 'El juego ha sido eliminado correctamente';
}

?>



<!-- Mostrar la tabla de juegos y el formulario de actualización -->
<!-- Mostrar mensaje de éxito si existe -->
<?php if (isset($_SESSION['success_message'])): ?>
    <p><?= $_SESSION['success_message'] ?></p>
    <?php unset($_SESSION['success_message']) ?>
<?php endif ?>

<!-- Mostrar la tabla de juegos y el formulario de actualización -->
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Género</th>
            <th>Plataforma</th>
            <th>Comentarios</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($juegos as $juego): ?>
            <tr>
                <td><?= $juego['nombre'] ?></td>
                <td><?= $juego['genero'] ?></td>
                <td><?= $juego['plataforma'] ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="id_juego" value="<?= $juego['id_juego'] ?>">
                        <textarea name="comentarios"><?= $juego['comentarios'] ?></textarea>
                        <button type="submit">Guardar</button>
                    </form>
                </td>
                <td>
                <td>
                    <form method="post" onsubmit="return confirm('¿Está seguro de que desea eliminar este juego?')">
                        <input type="hidden" name="id_juego" value="<?= $juego['id_juego'] ?>">
                        <button type="submit" name="eliminar_juego">Eliminar</button>
                    </form>
                </td>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
    <!-- Creamos el footer y las columnas -->
    <footer class="footer">
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