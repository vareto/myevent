<?php

function crear_fichero($description, $evento, $url, $type) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $stmt = $conn->prepare("INSERT INTO files (description,url,event_id,typemime) VALUES (?, ?, ?,?)");
    $stmt->bind_param('ssis', $description, $url, $evento, $type);
    $stmt->execute();
    $newId = $stmt->insert_id;
    $stmt->close();
}

function traer_ficheos_eventos($evento) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT * FROM files WHERE event_id = $evento";
    $result = mysqli_query($conn, $sql);
    return $result;
}

if (isset($_POST['descargar'])) {
    header("Content-disposition: attachment; filename=".$_POST['urlFile']);
    header("Content-type:". $_POST['typeFile']);
    readfile($_POST['urlFile']);
}

if (isset($_POST['ver'])) { 
    header("Content-disposition: inline; filename=".$_POST['urlFile']);
    header("Content-type:". $_POST['typeFile']);
    readfile($_POST['urlFile']);
//    header("location: ficheros.php");
}
