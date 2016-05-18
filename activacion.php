<?php
include_once 'conexion.php';
$activation_key = $_GET["activation"];
$dbh = cogerConexion();
// Busca la entrada en la tabla de usuarios para la clave de activación recibida
$stm = $dbh->prepare("select count(*) from users where activation_key=?");
$stm->bind_param("s",$activation_key);
$stm->bind_result($total);
$message = "";
$stm->execute();
$stm->fetch();
$stm->close();

if ($total == 1) { // Si se ha encontrado...
    // Retrieve the email address
    $stm = $dbh->prepare("select email from users where activation_key=?");
    $stm->bind_param("s",$activation_key);
    $stm->bind_result($email);
    $stm->execute();
    $stm->fetch();
    $stm->close();
    $stm = $dbh->prepare("update users set active='y' , habilitado= 'y' where activation_key = ? and email = ?");
    $stm->bind_param("ss",$activation_key,$email);
    $stm->execute();
    $stm->close();
    
    header('location: success.php');
}

