<!DOCTYPE html>
<html lang="en">
<head>
 <title>Panel Edgar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ESTILOS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- SCRIPT -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<!-- comanods desde php 
inicio de php $salida = shell_exec('ping 10.9.3.54'); $salida2 = shell_exec('ping 10.9.3.23'); echo "<pre>$salida</pre>"; echo '<p>tamaño:".strlen($salida)"</p>'; echo "<br>"; echo "<pre>$salida2</pre>"; echo '<p>tamaño:".strlen($salida2)"</p>'; ?> -->
        <div class="row filas" id="validacion">
            <!-- Fila 1 -->
            <?php
                $columna = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43);
                $tamanio_array_columnas = count($columna);
                for ($i=0; $i < $tamanio_array_columnas; $i++)
                {
                    if ($columna[$i] <= 9)
                    {
                        echo "<div class='col' id='columna_".$columna[$i]."'>";
                        echo "<i class='material-icons'>desktop_windows</i>";
                        echo "<br>";
            ?>
                <form action="estaciones/estacion.php" method="post" target="_blank">
                  <input name='estacion' id='est_00<?=$columna[$i]?>' class='btn btn-dark btn-lg' type='submit' value='estacion 00<?=$columna[$i]?>' onclick="window.open('estaciones/estacion.php','Estación 00<?=$columna[$i]?>','width=320, height=450')"/>;
                </form>
            <?php
                        echo "</div>";
                    }
                }
            ?>
        </div>


</div> 

</body>
</html>