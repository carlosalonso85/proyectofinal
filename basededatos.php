<?php
// Establecer los valores para la conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "trabajofin";

// Función para conectar a la base de datos

function conectar(){
	// Conectar a la base de datos con los valores especificados
	$con = mysqli_connect($GLOBALS["host"], $GLOBALS["user"], $GLOBALS["pass"]) or die("Error al conectar con la base de datos");
	// Seleccionar la base de datos
	mysqli_select_db($con, $GLOBALS["db_name"]);
	// Devolver la conexión
	return $con;
}

// Función para obtener los juegos de Play Station
function obtener_play($con){
	// Ejecutar una consulta para seleccionar los juegos de Play Station
	$resultado = mysqli_query($con, "select id_juego, nombre, genero, plataforma, comentarios, link from juegos where plataforma='Play Station'");
	return $resultado;
}

// Función para obtener los juegos de Xbox
function obtener_xbox($con){
	// Ejecutar una consulta para seleccionar los juegos de xbox
	$resultado = mysqli_query($con, "select id_juego, nombre, genero, plataforma, comentarios, link from juegos where plataforma='Xbox'");
	return $resultado;
}

// Función para obtener los juegos de PC
function obtener_pc($con){
	// Ejecutar una consulta para seleccionar los juegos de PC
	$resultado = mysqli_query($con, "select id_juego, nombre, genero, plataforma, comentarios, link from juegos where plataforma='Ordenador'");
	return $resultado;
}

// Función para obtener los juegos de Nintendo Switch
function obtener_nintendo($con){
	// Ejecutar una consulta para seleccionar los juegos de Nintendo Switch
	$resultado = mysqli_query($con, "select id_juego, nombre, genero, plataforma, comentarios, link from juegos where plataforma='Nintendo - Switch'");
	return $resultado;
}

// Función para obtener un juego aleatorio
function obtener_juego_aleatorio($con) {
	// Ejecutar una consulta para seleccionar todos los juegos
    $resultado = mysqli_query($con, "select id_juego, nombre,plataforma,link from juegos");
	// Obtener el número de juegos en el resultado
    $num_juegos = mysqli_num_rows($resultado);
	// Generar un número aleatorio entre 0 y el número de juegos
    $num_aleatorio = rand(0, $num_juegos-1);
	// Desplazar el puntero del resultado a la posición del juego aleatorio
    mysqli_data_seek($resultado, $num_aleatorio);
	// Obtener los datos del juego
    $row = mysqli_fetch_array($resultado);
	// Guardar los datos en variables
    $id_juego = $row['id_juego'];
    $nombre_juego = $row['nombre'];
	$plataforma_juego = $row['plataforma'];
	$link_juego = $row['link'];
	// Devolver los datos en un array
    return array("id_juego"=>$id_juego, "nombre"=>$nombre_juego,"plataforma"=>$plataforma_juego, "link"=>$link_juego);
}

// Función para imagen aleatoria
function obtener_imagen_aleatoria() {
	// Se genera un número aleatorio entre 1 y 40 que se usará para seleccionar una imagen
    $id_juego = rand(1, 40);
	// Se construye la ruta a la imagen seleccionada
    $ruta_img = "imgs/imagen_" . $id_juego . ".png";
	 // Se comprueba si la imagen existe en el directorio, y si no se repite el proceso hasta encontrar una
    while (!file_exists($ruta_img)) {
        $id_juego = rand(1, 40);
        $ruta_img = "imgs/imagen_" . $id_juego . ".png";
    }
	// Se devuelve el id del juego correspondiente a la imagen
    return $id_juego;
}

// Función para comprobar la respeusta
function comprobar_respuesta($con, $respuesta) {
	// Se consulta el nombre del juego correspondiente a la imagen actual
    $resultado = mysqli_query($con, "SELECT nombre FROM juegos WHERE id_juego = ".$_SESSION["imagen_actual"]);
    $juego = mysqli_fetch_assoc($resultado);
	// Se compara la respuesta dada por el usuario con el nombre del juego
    if ($juego["nombre"] == $respuesta) {
		// Si la respuesta es correcta, se devuelve verdadero
        return true;
    } else {
		// Si la respuesta es incorrecta, se devuelve falso
        return false;
    }
}

function obtener_num_filas($resultado){
	// Se obtiene el número de filas de un resultado obtenido de una consulta
	return mysqli_num_rows($resultado);
}
function obtener_resultados($resultado){
	// Se obtienen los resultados de una consulta en forma de array
	return mysqli_fetch_array($resultado);
}

function cerrar_conexion($con){
	// Se cierra la conexión a la base de datos
	mysqli_close($con);
}
?>
<?php
	// Definición de la clase Database
	class Database {
		// Variables de configuración de la base de datos
		private static $db_host = "localhost";
		private static $db_user = "root";
		private static $db_pass = "";
		private static $db_name = "trabajofin";
		
		// Variables de conexión y resultados
		private $con;
		private $result;
		private $numRows;
		
		// Constructor de la clase, se conecta a la base de datos
		public function __construct(){
			$this->con = new mysqli(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
		}
		
		// Cierra la conexión a la base de datos
		public function disconnect(){
			$this->con->close();
		}
		
		// Ejecuta una consulta a la base de datos
		public function query($sql){
			$this->result = $this->con->query($sql); // Se guarda el resultado en la variable $result
			$this->numRows = $this->result->num_rows; // Se guarda la cantidad de filas en la variable $numRows
		}
		
		// Retorna el número de filas en el resultado
		public function numRows(){
			return $this->numRows;
		}
		
		// Retorna un arreglo con las filas del resultado
		public function rows(){
			$rows = array(); // Se crea un arreglo vacío
			for($i=0;$i<$this->numRows;$i++){ // Se recorre el resultado
				$rows[] = $this->result->fetch_assoc(); // Se agrega la fila actual al arreglo
			}
			return $rows; // Se retorna el arreglo completo
		}
	}
?>