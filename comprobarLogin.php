<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir las variables de configuración
include 'cabecera.php';

// Conectar al servidor y seleccionar la base de datos
$conn = mysqli_connect($servidor, $userBD, $passwdBD, $nomBD);

// Comprobar la conexión
if (!$conn) {
 die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener los datos del formulario y la contraseña encriptada con MD5
$username = $_POST['username'];
$password = md5($_POST['password']);

// Crear la consulta con sprintf
$sql = sprintf("SELECT * FROM usuarios WHERE nombre='%s' AND clave='%s'", 
mysqli_real_escape_string($conn, $username), 
mysqli_real_escape_string($conn, $password));

// Ejecutar la consulta
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
 // Usuario autenticado correctamente
 echo "Inicio de sesión exitoso. Bienvenido, " . htmlspecialchars($username) . "!";
} else {
 // Usuario no encontrado
 echo "Nombre de usuario o contraseña incorrectos.";
}

// Cerrar la conexión
mysqli_close($conn);
?>