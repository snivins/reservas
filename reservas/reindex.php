<?php session_start() ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Reindex</title>
        <meta charset="utf-8" />
    </head>
    <body><?php
        require '../comunes/auxiliar.php';
    function selected($a, $b){
        ($a == $b)? true: false;
    }
    conectar();
    
        if (!isset($_SESSION['usuario'])){
            header("Location: ../usuarios/login.php");
            return;
        } else {
            $usuaro_id = $_SESSION['usuario'];
        }

//para pintar pistas
        
        $pistas_id = isset($_POST['pistas_id']) ? trim($_POST['pistas_id']) : ""; // compruebo si hay algun valor para conservarlo
        
        ?>
        <form action="reindex.php" method="post"><?php
        $res= pg_query("select * from pistas");?>
            <select name="pistas_id" ><?php
                for ($i =0; $i < pg_num_rows($res); $i++){
                    $fila = pg_fetch_assoc($res, $i);
                    extract($fila) ?>
                    <option value="<?= $id ?>" <?= selected($pistas_id, $id) ?> > <?= $nombre ?></option><?php
                }?>
            </select>
            <input type="submit" value="Mostrar reservas" />
        </form>

        <?php // para pintar los dias
        //primero sacamos que dia es hoy y que dia es el lunes
        $dow = (int) date("w"); // me devuelve el numero que seria hoy en la semana
        $dif = $dow == 0 ? 6 : $dow - 1; //saco la diferencia, si hoy es jueves 4 y el lunes es 1, 4-1 es 3 la diferencia
        $lunes = time() - $dif * UN_DIA; //time me da la hora actual en segundos, le quito la diferencia pasada a segundos y m devuelve la fecha dl lunes?>
        <table style="margin:auto">
            <td>
                <form action="reindex.php" method="post">
                    <input type="hidden" name="pistas_id" value="<?= $pistas_id ?>" />
                    <input type="hidden" name="lunes" value="<?= $lunes - 7 * UN_DIA?>" />
                    <input type="submit" value="Patras" />
                </form>
            </td>
            <td>
                <form action="reindex.php" method="post">
                    <input type="hidden" name="pistas_id" value="<?= $pistas_id ?>" />
                    <input type="hidden" name="lunes" value="<?= $lunes + 7 * UN_DIA?>" />
                    <input type="submit" value="Palante" />
                </form>
            </td>
        </table>
        



        
    ?>
    </body>
</html>