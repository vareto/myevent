<?php
$confirmacion = $_GET["confirmacion"];
$token = $_GET["token"];
//$id = $_GET["id"];
$si = sha1("si");
$no = sha1("no");
include_once 'conexion.php';
$conn = cogerConexion();

$sql = "SELECT * FROM events_users where token='$token' and asistencia=''";
$result = mysqli_query($conn, $sql);
$filas = mysqli_num_rows($result);
$datos = mysqli_fetch_array($result);
$idevento = $datos['event_id'];

if ($filas == 1) { //realizar actualizacion
    if (strcmp($confirmacion, $si) == 0) {
        $conn = cogerConexion();
        $sql = "UPDATE events_users set asistencia = 'SI', token='' where event_id = $idevento and token='$token';";
        if ($conn->query($sql) === TRUE) {
            header('Location: success.php');
        }
        $conn->close();
    } else if (strcmp($confirmacion, $no) == 0) {
        $conn = cogerConexion();
        $sql = "UPDATE events_users set asistencia = 'NO', token=''  where event_id =  $idevento and token='$token';";
        if ($conn->query($sql) === TRUE) {
            header('Location: success.php');
        }
        $conn->close();
    }
} else {
    header("location: error404.php");
}

