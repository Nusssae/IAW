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

// comprobación que se han mandado los datos del formulario por post
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    //mostrar en pantalla para depurar de forma mas clara y ordenada con el <pre>
  //  echo "<pre>";
 //   print_r($_POST);
  //  echo "</pre>";

    //obtencion de datos del formulario
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $autor = mysqli_real_escape_string($conn,$_POST['autor']);
    $isbn = mysqli_real_escape_string($conn,$_POST['isbn']);
    $puntuacion = mysqli_real_escape_string($conn,$_POST['puntuacion']);
    $genero = mysqli_real_escape_string($conn,$_POST['genero']);

// Comprobar si ya existe un libro con el mismo ISBN
$sql_check = sprintf("SELECT * FROM libros WHERE isbn='%s'", $isbn);

// mostrar la consulta SQL
//echo "<pre>";
//echo "Consulta SQL: $sql_check";
//echo "</pre>";
$result_check = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    echo "Ya hay un libro con ese ISBN, modifica los datos.";
} else {
    // Si no hay coincidencias insertar el nuevo libro
    $sql_insert = sprintf("INSERT INTO libros (nombre, autor, isbn, puntuacion, genero) 
    VALUES ('%s', '%s', '%s', %d, '%s')",
    $nombre, $autor, $isbn, $puntuacion, $genero
    );

    if (mysqli_query($conn, $sql_insert)) {
        echo "Libro añadido";
    } else {
        echo "Error al agregar el libro: " . mysqli_error($conn);
    }
}

// Cerrar la conexión
mysqli_close($conn);
} else {
echo "No se han enviado datos.";
}
?>