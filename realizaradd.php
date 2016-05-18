<?php
session_start();
if (isset($_POST["add"])) {
include_once 'conexion.php';
    $conn = cogerConexion();    
    $sql = "SELECT * FROM groups_users WHERE user_id= " . $_POST['usuarioAdd'] . " and group_id = " . $_SESSION['idGrupo'];
    $result = mysqli_query($conn, $sql) or die("Error: ".mysqli_error($conn));
    if (!mysqli_num_rows($result) > 0) { //no a sido invitado
        include_once './accionesGrupos.php';
        add_contacto($_SESSION['idGrupo'], $_POST['usuarioAdd']);
    }
    header('location: addcontactos.php');
} 