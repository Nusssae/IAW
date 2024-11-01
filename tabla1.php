<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla de Divisores</title>
    <style>
        table {
            border: 1px solid black;
            border-collapse:  separate;
            margin: 20px;
        }
        th, td {
            width: 40px;
            height: 40px;
            text-align: center;
            border: 1px solid #000;
            box-shadow: inset 2px 2px /*hacer el hundimiento*/
        }
        td {
            text-align: left;
        }
        th {
            background-color: #b6a6db;
        }
        .amarillo {
            background-color: #FCFB94;
        }
        .naranja {
            background-color: #FEE0C5;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <th></th>
        <?php
        for ($i = 50; $i <= 60; $i++) {
            echo "<th>$i</th>";
        }
        ?>
    </tr>
    
    <?php
    for ($row = 1; $row <= 10; $row++) {
        echo "<tr>";
        echo "<th>$row</th>";  // Fila encabezado con el divisor

        for ($col = 50; $col <= 60; $col++) {
            // Alternar colores según la FILA
            $color = ($row % 2 == 0) ? "naranja" : "amarillo";
            // Verificar si el número es divisible por el índice de fila
            $content = ($col % $row == 0) ? "*" : "-";
            echo "<td class='$color'>$content</td>";
        }

        echo "</tr>";
    }
    ?>

</table>

</body>
</html>