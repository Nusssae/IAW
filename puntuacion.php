<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// incluir variables de configuración
include('cabecera.php');

// Conectar al servidor y seleccionar la base de datos
$conn = mysqli_connect($servidor, $userBD, $passwdBD, $nomBD);

// Comprobar la conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// consulta en la tabla datos
$sql = "SELECT * FROM libros";

// se he enviado la puntuacion y no esta vacio
if ($_SERVER['REQUEST_METHOD'] =='POST' && isset($_POST['puntuacion']) && $_POST['puntuacion'] !== ''){
    $puntuacion = intval($_POST['puntuacion']);
    if ($puntuacion >= 1 && $puntuacion <= 5) {
        $sql = sprintf("SELECT * FROM libros WHERE puntuacion =%d", $puntuacion);
    }
}
echo"<pre>Consulta Sql: $sql</pre>"

$result = mysqli_query($conn, $sql);

if (!$result && mysqli_num_rows($result) > 0) {
    while ($fila = mysqli_fetch_assoc($result)) {
        echo "<tr>"
        echo "<td>". htmlspecialchars($fila["nombre"]) ."</td>";
        echo "<td>". htmlspecialchars($fila["autor"]) ."</td>";
        echo "<td>". htmlspecialchars($fila["isbn"]) ."</td>";
        echo "<td>". htmlspecialchars($fila["puntuacion"]) ."</td>";
        echo "<td>". htmlspecialchars($fila["genero"]) ."</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No se encontraron libros</td></tr>";

// Cerrar la conexion
mysqli_close( $conn );
?>