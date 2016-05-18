<?php

session_start();
if (isset($_POST["invitar"])) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT * FROM events_users WHERE user_id= " . $_POST['usuarioInvitar'] . " and event_id = " . $_SESSION['idevento'];
    $result = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));
    if (!mysqli_num_rows($result) > 0) { //no a sido invitado
        include_once './accionesEventos.php';
        crear_invitacion($_SESSION['idevento'], $_POST['usuarioInvitar']);
    }
    header('location: invitarevento.php');
}

if (isset($_POST["desinvitar"])) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT * FROM events_users WHERE user_id= " . $_POST['usuarioInvitar'] . " and event_id = " . $_SESSION['idevento'];
    $result = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));
    if (mysqli_num_rows($result) == 1) { //tiene una invitacion
        include_once './accionesEventos.php';
        quitar_invitacion_evento($_SESSION['idevento'], $_POST['usuarioInvitar']);
    }
    header('location: invitarevento.php');
}

if (isset($_POST["invitarGrupo"])) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT user_id FROM groups_users WHERE group_id= " . $_POST['grupoInvitar']; //traemos id de usuario de grupo X
    $result = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));
    foreach ($result as $a) { //recorremos lista de ids para comprobar que no tengan invitacion
        $sql = "SELECT * FROM events_users WHERE user_id= " . $a['user_id'] . " and event_id = " . $_SESSION['idevento'];
        $result = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));
        if (!mysqli_num_rows($result) > 0) { //no a sido invitado
            include_once './accionesEventos.php';
            $sql = "SELECT * FROM users WHERE id= " . $a['user_id'] . " and habilitado = 'y'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) == 1){ //esta habilitado
                crear_invitacion($_SESSION['idevento'], $a['user_id']);
            }
        }
    }
    header('location: invitarevento.php');
}
if (isset($_POST["desinvitarGrupo"])) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT user_id FROM groups_users WHERE group_id= " . $_POST['grupoInvitar']; //traemos id de usuario de grupo X
    $result = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));
    foreach ($result as $a) { //recorremos lista de ids para comprobar que no tengan invitacion
        $sql = "SELECT * FROM events_users WHERE user_id= " .$a['user_id'] . " and event_id = " . $_SESSION['idevento'];
        $result = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));
        if (mysqli_num_rows($result) == 1) { //tiene una invitacion
            include_once './accionesEventos.php';
            quitar_invitacion_evento($_SESSION['idevento'], $a['user_id']);
        }
    }
    header('location: invitarevento.php');
}