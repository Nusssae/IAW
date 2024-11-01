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
            border-color: #02e740;
        }
        th, td {
            width: 40px;
            height: 40px;
            text-align: center;
            border: 1px solid #000;
            box-shadow: inset 2px 2px; /*hacer el hundimiento*/
            border-color: #02e740;
            font-size: 150%;
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

<?php
include 'recupera.php';

$num1 = recupera('num1');
$num2 = recupera('num2');

if ($num1 >= 1 && $num1 <= 10 && $num2 >= 10 && $num2 <= 20) {
    echo "<table>
            <tr>
                <th></th>";
    for ($i = 50; $i <= 60; $i++) {
       echo "<th>$i</th>";
    }
    echo "</tr>";
    for ($j = $num1; $j <= $num2; $j++) {
        $rowClass = ($j % 2 == 0) ? 'amarillo' : 'naranja';
       echo "<tr class='$rowClass'><th>$j</th>";
        for ($k = 50; $k <= 60; $k++) {
            echo "<td>" . ($k % $j == 0 ? '*' : '-') . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
?>
</body>
</html>