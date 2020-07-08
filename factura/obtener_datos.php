<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <title>Datos prefijos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilos_obtener_datos.css">
    <link rel="shortcut icon" href="../img/factura.ico" />
    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> 
    <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
</head>
<body>
    <?php
        $usuario    = "EdgarTele";
        $pass       = "**tele++fonia2";
        $servidor   = "10.9.2.21";
        $basededatos= "telefonia";
        $conexion = mysqli_connect( $servidor, $usuario, $pass );
        $db = mysqli_select_db( $conexion, $basededatos );
                    
        $server     =$_POST['carrier'];
        $tipo       =$_POST['tipo'];
        $prefix     =$_POST['troncales'];
        $fe_inicio  =$_POST['fecha_inicio'];
        $fe_termino =$_POST['fecha_termino'];    

       /* $consultar_prefijo = "SELECT distinct (d_carrier_prefix) as prefijo
                              FROM $server
                              WHERE u_start_time>='$fe_inicio 00:00:00'
                                AND u_start_time<='$fe_termino 23:59:59'
                                AND c_dialstatus in ('ANSWER')";
        $resultado_prefijo = mysqli_query($conexion, $consultar_prefijo);
        $mostrar_prefijo  = mysqli_fetch_array($resultado_prefijo);                                     
        $prefix =  $mostrar_prefijo['prefijo'];*/
    ?>
    <div class="container-fluid">
        <br>
        <div class=" container table-responsive">
        <?php
            switch ($tipo) {
                case 0:
                    echo "i es igual a 0";
                    break;
                case 1:
                    echo "i es igual a 1";
                    break;
                case 2:
                    echo "i es igual a 2";
                    break;
            }
        ?>    
            <table class="table table-bordered">
                <thead class="">
                    <tr class="table-success">
                        <td colspan="1">    <label><?php echo "$server"; ?></label> </td>
                        <?php
                            if ($prefix == 9 || $prefix == 11 || $prefix == 209 || $prefix == 210 || $prefix == 222 || $prefix == 223 )
                            {
                                echo "<td colspan='1'>LOCAL ".$prefix."</td>";
                            }
                            else
                            {
                                echo "<td colspan='1'>RAPTOR ".$prefix."</td>";
                            }
                        ?>
                        <td colspan="3">Minutos</td>
                    </tr>
                    <tr class="bg-primary">
                        <th class="titulos_tabla_resultado" id="id_campania">ID Campaña</th>
                        <th class="titulos_tabla_resultado" id="grupo">Grupo</th>
                        <th class="titulos_tabla_resultado" id="eventos">Eventos</th>
                        <th class="titulos_tabla_resultado" id="movil">Movil</th>
                        <th class="titulos_tabla_resultado" id="fijo">fijo</th>
                    </tr>
                </thead>
                <tbody class="table-striped">
                    <?php
                        $consultar_campania= "SELECT DISTINCT (d_campaign_id) AS campania
                                  FROM $server
                                  WHERE u_start_time>='$fe_inicio 00:00:00'
                                    AND  u_start_time<='$fe_termino 23:59:59'
                                    AND c_dialstatus in ('ANSWER')
                                  ORDER BY d_campaign_id";
                        $resultado_campania =   mysqli_query($conexion, $consultar_campania);
                        while ($mostrar_campania   =   mysqli_fetch_array($resultado_campania))
                        {
                            $campaign           =   $mostrar_campania['campania'];
                            echo "<tr>";
                                echo "<td id='celda_campania' colspan='5'>" .$campaign. "</td>";
                            echo "</tr>"; 
                            $consultar_grupos = "SELECT DISTINCT (d_user_group) AS grupos
                                                     FROM $server
                                                     WHERE u_start_time>='$fe_inicio 00:00:00'
                                                        AND u_start_time<='$fe_termino 23:59:59'
                                                        AND c_dialstatus in ('ANSWER')
                                                        AND d_campaign_id ='$campaign'
                                                        AND d_carrier_prefix ='$prefix'
                                                     ORDER BY d_user_group";
                            $resultado_grupos = mysqli_query($conexion, $consultar_grupos);
                            while ($mostrar_grupos   =   mysqli_fetch_array($resultado_grupos))
                            {
                                $groups =   $mostrar_grupos['grupos'];
                                echo "<tr>";
                                    echo "<td>SUCURSAL</td>";
                                    echo "<td>" .$groups. "</td>";
                                    echo "<td>EVENTOS</td>";
                                    $suma_monto_movil    =   "SELECT SUM(redondea_a_minutos) AS monto_movil from $server
                                                        where u_start_time>='$fe_inicio 00:00:00'  and  u_start_time<='$fe_termino 23:59:59'
                                                        and c_dialstatus in ('ANSWER') and d_campaign_id='$campaign' and d_carrier_prefix IN  ('$prefix')
                                                        and d_user_group='$groups' and d_tipo_numero='movil'";
                                    $resultado_monto_movil  =   mysqli_query($conexion, $suma_monto_movil);
                                    while ($mostrar_monto_movil =   mysqli_fetch_array($resultado_monto_movil))
                                    {   
                                        $monto_movil    =   $mostrar_monto_movil['monto_movil'];
                                        echo "<td>".$monto_movil."</td>";
                                    }
                                    $suma_monto_fijo    =   "SELECT SUM(redondea_a_minutos) AS monto_fijo from $server
                                                        where u_start_time>='$fe_inicio 00:00:00'  and  u_start_time<='$fe_termino 23:59:59'
                                                        and c_dialstatus in ('ANSWER') and d_campaign_id='$campaign' and d_carrier_prefix in  ('$prefix')
                                                        and d_user_group='$groups' and d_tipo_numero='fijo'";
                                    $resultado_monto_fijo   =   mysqli_query($conexion, $suma_monto_fijo);
                                    while ($mostrar_monto_fijo  =   mysqli_fetch_array($resultado_monto_fijo))
                                    {
                                        $monto_fijo     =   $mostrar_monto_fijo['monto_fijo'];
                                        echo "<td>".$monto_fijo."</td>";
                                    }     
                                echo "</tr>";
                            }
                            echo "<tr class='table-warning'>";
                                echo "<td></td>";
                                echo "<td>DROP</td>";
                                echo "<td>EVENTOS</td>";
                                $suma_monto_movildrop  = "SELECT SUM(redondea_a_minutos) AS monto_movildrop from $server
                                                    where u_start_time>='$fe_inicio 00:00:00'  and  u_start_time<='$fe_termino 23:59:59'
                                                    and c_dialstatus in ('ANSWER') and d_campaign_id='$campaign' and d_carrier_prefix in  ('$prefix')
                                                    and d_user_group='' and d_status not IN ('NA', 'AA') and d_tipo_numero='movil'";
                                $resultado_monto_movildrop = mysqli_query($conexion, $suma_monto_movildrop);
                                while ($mostrar_monto_movildrop = mysqli_fetch_array($resultado_monto_movildrop))
                                {
                                    $monto_movildrop = $mostrar_monto_movildrop['monto_movildrop'];
                                    echo "<td>".$monto_movildrop."</td>";
                                }
                                $suma_monto_fijodrop = "SELECT SUM(redondea_a_minutos) AS monto_fijodrop from $server
                                                    where u_start_time>='$fe_inicio 00:00:00'  and  u_start_time<='$fe_termino 23:59:59'
                                                    and c_dialstatus in ('ANSWER') and d_campaign_id='$campaign' and d_carrier_prefix in  ('$prefix')
                                                    and d_user_group='' and d_status not IN ('NA', 'AA') and d_tipo_numero='fijo'";
                                $resultado_monto_fijodrop = mysqli_query($conexion, $suma_monto_fijodrop);
                                while ($mostrar_monto_fijodrop = mysqli_fetch_array($resultado_monto_fijodrop))
                                {
                                    $monto_fijodrop = $mostrar_monto_fijodrop['monto_fijodrop'];
                                    echo "<td>".$monto_fijodrop."</td>";
                                }
                            echo "</tr>";
                            echo "<tr class='table-warning'>";
                                echo "<td></td>";
                                echo "<td>BUZON</td>";
                                echo "<td>EVENTOS</td>";
                                $suma_monto_movilbuzon = "SELECT SUM(redondea_a_minutos) AS monto_movilbuzon from $server
                                                    where u_start_time>='$fe_inicio 00:00:00'  and  u_start_time<='$fe_termino 23:59:59'
                                                    and c_dialstatus in ('ANSWER') and d_campaign_id='$campaign' and d_carrier_prefix in  ('$prefix')
                                            and d_user_group='' and d_status IN ('NA', 'AA') and d_tipo_numero='movil'";
                                $resultado_monto_movilbuzon = mysqli_query($conexion, $suma_monto_movilbuzon);
                                while ($mostrar_monto_movilbuzon = mysqli_fetch_array($resultado_monto_movilbuzon))
                                {
                                    $monto_movilbuzon = $mostrar_monto_movilbuzon['monto_movilbuzon'];
                                    echo "<td>".$monto_movilbuzon."</td>";
                                }
                                $suma_monto_fijobuzon = "SELECT SUM(redondea_a_minutos) AS monto_fijobuzon from $server
                                                    where u_start_time>='$fe_inicio 00:00:00'  and  u_start_time<='$fe_termino 23:59:59'
                                                    and c_dialstatus in ('ANSWER') and d_campaign_id='$campaign' and d_carrier_prefix in  ('$prefix')
                                                    and d_user_group='' and d_status IN ('NA', 'AA') and d_tipo_numero='fijo'";
                                $resultado_monto_fijobuzon = mysqli_query($conexion, $suma_monto_fijobuzon);
                                while ($mostrar_monto_fijobuzon = mysqli_fetch_array($resultado_monto_fijobuzon))
                                {
                                    $monto_fijobuzon = $mostrar_monto_fijobuzon['monto_fijobuzon'];
                                    echo "<td>".$monto_fijobuzon."</td>";
                                }
                            echo "</tr>";
                            echo "<tr class='table-warning'>";
                                echo "<td></td>";
                                echo "<td>CAMPAÑA0</td>";
                                echo "<td>EVENTOS</td>";
                                $suma_monto_nulo = "SELECT SUM(redondea_a_minutos) AS monto_nulo from $server
                                                    where u_start_time>='$fe_inicio 00:00:00'  and  u_start_time<='$fe_termino 23:59:59'
                                                    and c_dialstatus IN ('ANSWER') AND d_campaign_id ='' AND d_user_group ='' and d_carrier_prefix IN ('$prefix')";
                                $resultado_monto_nulo = mysqli_query($conexion, $suma_monto_nulo);
                                while ($mostrar_monto_nulo = mysqli_fetch_array($resultado_monto_nulo))
                                {
                                    $monto_nulo = $mostrar_monto_nulo['monto_nulo'];
                                    echo "<td>".$monto_nulo."</td>";
                                }
                                echo "<td></td>";
                                echo "<td></td>";
                            echo "</tr>";
                            echo "<tr>";
                            $total_server = $monto_movil + $monto_fijo + $monto_movildrop + $monto_fijodrop + $monto_movilbuzon + $monto_fijobuzon + $monto_nulo;
                            echo "<td colspan='5' class='bg-danger'>".$total_server."</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>