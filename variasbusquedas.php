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

// Inicializar la consulta base
$sql = "SELECT * FROM libros WHERE 1";

// Verificar si se ha enviado un filtro por puntuación o género
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $filtros = [];

    // Filtro por puntuación
    if (isset($_POST['puntuacion']) && $_POST['puntuacion'] !== '') {
        $puntuacion = intval($_POST['puntuacion']);
        if ($puntuacion >= 1 && $puntuacion <= 5) {
            $filtros[] = "puntuacion = $puntuacion";
        }
    }

    // Filtro por género
    if (isset($_POST['genero']) && $_POST['genero'] !== '') {
        $genero = mysqli_real_escape_string($conn, $_POST['genero']);
        $filtros[] = "genero LIKE '%$genero%'";
    }

    // Si se especificaron filtros, los agregamos a la consulta
    if (count($filtros) > 0) {
        $sql .= " AND " . implode(" AND ", $filtros);
    }
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca</title>
    <style>
        body {
            background-color: #ccc;
        }
        table {
            border-collapse: collapse;
            width: 75%;
            background-color: #fff;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 8px;
            color: grey;
            border: 1px solid black;
            font-size: 14px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        form {
            margin-bottom: 10px;
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        label {
            display: block;
            margin: 5px 0;
        }
        .form-item {
            flex: 1 1 150px;
            min-width: 150px;
        }
        input[type="text"], input[type="number"] {
            padding: 8px;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            flex: 1 1 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Buscar Libros</h2>
    <form action="variasbusquedas.php" method="post">
        <div class="form-item">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>">
        </div>
        <div class="form-item">
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" value="<?php echo isset($_POST['autor']) ? $_POST['autor'] : ''; ?>">
        </div>
        <div class="form-item">
            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn" value="<?php echo isset($_POST['isbn']) ? $_POST['isbn'] : ''; ?>">
        </div>
        <div class="form-item">
            <label for="puntuacion">Puntuación:</label>
            <input type="number" id="puntuacion" name="puntuacion" min="1" max="5" value="<?php echo isset($_POST['puntuacion']) ? $_POST['puntuacion'] : ''; ?>">
        </div>
        <div class="form-item">
            <label for="genero">Género:</label>
            <input type="text" id="genero" name="genero" value="<?php echo isset($_POST['genero']) ? $_POST['genero'] : ''; ?>">
        </div>
        <div class="form-item">
            <input type="submit" value="Buscar">
        </div>
    </form>

    <h2>Biblioteca Libros por Puntuación y Género</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Autor</th>
            <th>ISBN</th>
            <th>Puntuación</th>
            <th>Género</th>
        </tr>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($fila = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['autor']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['isbn']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['puntuacion']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['genero']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No se encontraron libros</td></tr>";
        }

        // Cerrar la conexión
        mysqli_close($conn);
        ?>
    </table>
</body>
</html>
