<?php

function traer_mis_contactos($iduser) { //traemos todos mis contactos
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT user_id1 FROM users_users join users where users_users.user_id = users.id and users.id=$iduser and users_users.acepta='y' ";
    $result = mysqli_query($conn, $sql);
    $querys = "";
    foreach ($result as $a) {
        include_once 'conexion.php';
        $querys .= "SELECT users.id, users.name, users.last_name, users.picuser FROM users  where  users.habilitado = 'y' and users.id=" . $a['user_id1'] . ";";
    }
    $porciones = explode(";", $querys);
    $resultado = array();
    for ($i = 0; $i < count($porciones) - 1; $i++) {
        $result = mysqli_query($conn, $porciones[$i]);
        $a = mysqli_fetch_array($result);
        $resultado[$i] = $a;
    }
    $sql = "SELECT user_id FROM users_users join users where users_users.user_id1 = users.id and users.id=$iduser and users_users.acepta='y'";
    $result = mysqli_query($conn, $sql);
    $querys = "";
    foreach ($result as $a) {
        include_once 'conexion.php';
        $querys .= "SELECT users.id, users.name, users.last_name ,users.picuser FROM users where users.habilitado = 'y' and  users.id=" . $a['user_id'] . ";";
    }
    $porciones = explode(";", $querys);
    for ($j = 0; $j < count($porciones) - 1; $j++) {
        $i++;
        $result = mysqli_query($conn, $porciones[$j]);

        $totalFilas = mysqli_num_rows($result);
        if ($totalFilas > 0) {
            $a = mysqli_fetch_array($result);
            $resultado[$i] = $a;
        }
    }
    return $resultado;
}

function traer_mis_contactos2($iduser) { //traemos los contactos que aun no hemos aceptado la peticion de amistad
    include_once 'conexion.php';
    $conn = cogerConexion();
    $resultado = array();
    $sql = "SELECT user_id FROM users_users join users where users_users.user_id1 = users.id and users.id=$iduser and users_users.acepta=''";
    $result = mysqli_query($conn, $sql);
    $querys = "";
    foreach ($result as $a) {
        include_once 'conexion.php';
        $querys .= "SELECT users.id, users.name, users.last_name , users.picuser FROM users  where users.id=" . $a['user_id'] . ";";
    }
    $porciones = explode(";", $querys);
    for ($j = 0; $j < count($porciones) - 1; $j++) {

        $result = mysqli_query($conn, $porciones[$j]);


        $totalFilas = mysqli_num_rows($result);
        if ($totalFilas > 0) {
            $a = mysqli_fetch_array($result);
            $resultado[$j] = $a;
        }
    }

    return $resultado;
}

function num_invitaciones_pendientes($id) {
    $result = traer_mis_contactos2($id);
    $num = count($result);
    return $num;
}

function traer_mis_contactos_no_invitados($iduser, $idevento) { //traemos los contactos no invitados a un evento X y que esten habilitados
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT user_id1 FROM users_users join users where users_users.user_id = users.id and users.id=$iduser and users_users.acepta='y'";
    $result = mysqli_query($conn, $sql);
    $querys = "";
    foreach ($result as $a) {
        include_once 'conexion.php';
        $querys .= "SELECT users.id, users.name, users.last_name FROM users join events_users ON users.id = events_users.user_id where users.id= " . $a['user_id1'] . " and events_users.event_id = $idevento;";
    }
    $porciones = explode(";", $querys);
    $resultado = array();
    for ($i = 0; $i < count($porciones) - 1; $i++) {
        $result = mysqli_query($conn, $porciones[$i]);
        if (!mysqli_num_rows($result) > 0) {
            $s = explode(" ", $porciones[$i]);
            $a = mysqli_fetch_array($result);
            $sql = "select id, name, last_name, picuser from users where id = " . $s[14] . " and users.habilitado = 'y'";
            $result = mysqli_query($conn, $sql);
            $totalFilas = mysqli_num_rows($result);
            if ($totalFilas > 0) {
                $a = mysqli_fetch_array($result);
                $resultado[$i] = $a;
            }
        }
    }
    $sql = "SELECT user_id FROM users_users join users where users_users.user_id1 = users.id and users.id=$iduser  and users.habilitado = 'y'  and users_users.acepta='y'";
    $result = mysqli_query($conn, $sql);
    $querys = "";
    foreach ($result as $a) {
        $querys .= "SELECT users.id, users.name, users.last_name FROM users join events_users ON users.id = events_users.user_id where users.id= " . $a['user_id'] . " and events_users.event_id = $idevento;";
    }
    $porciones = explode(";", $querys);
    for ($j = 0; $j < count($porciones) - 1; $j++) {
        $i++;
        $result = mysqli_query($conn, $porciones[$j]);
        if (!mysqli_num_rows($result) > 0) { //no a sido invitado
            $s = explode(" ", $porciones[$j]);
            $a = mysqli_fetch_array($result);
            $sql = "select id, name, last_name, picuser from users where id = " . $s[14] . " and users.habilitado = 'y'";
            $result = mysqli_query($conn, $sql);
            $totalFilas = mysqli_num_rows($result);
            if ($totalFilas > 0) {
                $a = mysqli_fetch_array($result);
                $resultado[$i] = $a;
            }
        }
    }
    return $resultado;
}

function traer_mis_contactos_invitados($iduser, $idevento) { //traemos los contactos  invitados a un evento X
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT user_id1 FROM users_users join users where users_users.user_id = users.id and users.id=$iduser and users.habilitado = 'y' and users_users.acepta='y'";
    $result = mysqli_query($conn, $sql);
    $querys = "";
    foreach ($result as $a) {
        include_once 'conexion.php';
        $querys .= "SELECT users.id, users.name, users.last_name ,users.picuser FROM users join events_users ON users.id = events_users.user_id where users.id= " . $a['user_id1'] . " and events_users.event_id = $idevento;";
    }
    $porciones = explode(";", $querys);
    $resultado = array();
    for ($i = 0; $i < count($porciones) - 1; $i++) {
        $result = mysqli_query($conn, $porciones[$i]);
        if (mysqli_num_rows($result) == 1) { //no a sido invitado
            $a = mysqli_fetch_array($result);
            $resultado[$i] = $a;
        }
    }
    $sql = "SELECT user_id FROM users_users join users where users_users.user_id1 = users.id and users.habilitado = 'y' and users.id=$iduser and users_users.acepta='y'";
    $result = mysqli_query($conn, $sql);
    $querys = "";
    foreach ($result as $a) {
        $querys .= "SELECT users.id, users.name, users.last_name ,users.picuser FROM users join events_users ON users.id = events_users.user_id where users.id= " . $a['user_id'] . " and events_users.event_id = $idevento;";
    }
    $porciones = explode(";", $querys);
    for ($j = 0; $j < count($porciones) - 1; $j++) {
        $i++;
        $result = mysqli_query($conn, $porciones[$j]);
        if (mysqli_num_rows($result) == 1) { //no a sido invitado
            $a = mysqli_fetch_array($result);
            $resultado[$i] = $a;
        }
    }
    return $resultado;
}

function traer_mis_contactos_add($iduser, $idgrupo) { //traemos los contactos no añadidos a un grupo X
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT user_id1 FROM users_users join users where users_users.user_id = users.id and users.id=$iduser  and users.habilitado = 'y'  and users_users.acepta='y'";
    $result = mysqli_query($conn, $sql);
    $querys = "";

    foreach ($result as $a) {
        include_once 'conexion.php';
        $querys .= "SELECT users.id, users.name, users.last_name FROM users join groups_users ON users.id = groups_users.user_id where users.id= " . $a['user_id1'] . " and groups_users.group_id = $idgrupo ;";
    }

    $porciones = explode(";", $querys);
    $resultado = array();

    for ($i = 0; $i < count($porciones) - 1; $i++) {
        $result = mysqli_query($conn, $porciones[$i]);
        if (!mysqli_num_rows($result) > 0) {
            $s = explode(" ", $porciones[$i]);
            $a = mysqli_fetch_array($result);
            $sql = "select id, name, last_name, picuser from users where  habilitado = 'y' and id = " . $s[14];
            $result = mysqli_query($conn, $sql);
            $totalFilas = mysqli_num_rows($result);
            if ($totalFilas > 0) {
                $a = mysqli_fetch_array($result);
                $resultado[$i] = $a;
            }
        }
    }

    $sql = "SELECT user_id FROM users_users join users where users_users.user_id1 = users.id and users.id=$iduser  and users.habilitado = 'y'  and users_users.acepta='y'";
    $result = mysqli_query($conn, $sql);
    $querys = "";
    foreach ($result as $a) {
        $querys .= "SELECT users.id, users.name, users.last_name FROM users join groups_users ON users.id = groups_users.user_id where users.id= " . $a['user_id'] . " and groups_users.group_id = $idgrupo;";
    }
    $porciones = explode(";", $querys);
    for ($j = 0; $j < count($porciones) - 1; $j++) {
        $i++;
        $result = mysqli_query($conn, $porciones[$j]);
        if (!mysqli_num_rows($result) > 0) { //no a sido invitado
            $s = explode(" ", $porciones[$j]);
            $a = mysqli_fetch_array($result);
            $sql = "select id, name, last_name, picuser from users where habilitado = 'y' and  id = " . $s[14];
            $result = mysqli_query($conn, $sql);
            $totalFilas = mysqli_num_rows($result);
            if ($totalFilas > 0) {
                $a = mysqli_fetch_array($result);
                $resultado[$i] = $a;
            }
        }
    }
    return $resultado;
}

function traer_mis_contactos_retirar($iduser, $idgrupo) { //traemos los contactos invitados a un grupo X
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT user_id1 FROM users_users join users where users_users.user_id = users.id and users.id=$iduser  and users.habilitado = 'y'   and users_users.acepta='y'";
    $result = mysqli_query($conn, $sql);
    $querys = "";
    foreach ($result as $a) {
        include_once 'conexion.php';
        $querys .= "SELECT users.id, users.name, users.last_name, users.picuser FROM users join groups_users ON users.id = groups_users.user_id where users.id= " . $a['user_id1'] . " and groups_users.group_id = $idgrupo;";
    }
    $porciones = explode(";", $querys);
    $resultado = array();
    for ($i = 0; $i < count($porciones) - 1; $i++) {
        $result = mysqli_query($conn, $porciones[$i]);
        if (mysqli_num_rows($result) == 1) { //no a sido invitado
            $a = mysqli_fetch_array($result);
            $resultado[$i] = $a;
        }
    }
    $sql = "SELECT user_id FROM users_users join users where users_users.user_id1 = users.id and users.id=$iduser  and users.habilitado = 'y'   and users_users.acepta='y'";
    $result = mysqli_query($conn, $sql);
    $querys = "";
    foreach ($result as $a) {
        $querys .= "SELECT users.id, users.name, users.last_name, users.picuser FROM users join groups_users ON users.id = groups_users.user_id where users.id= " . $a['user_id'] . " and groups_users.group_id = $idgrupo;";
    }
    $porciones = explode(";", $querys);
    for ($j = 0; $j < count($porciones) - 1; $j++) {
        $i++;
        $result = mysqli_query($conn, $porciones[$j]);
        if (mysqli_num_rows($result) == 1) { //no a sido invitado
            $a = mysqli_fetch_array($result);
            $resultado[$i] = $a;
        }
    }
    return $resultado;
}


function comprobar_pass($pass, $userid) { //comprobar si la pass que introduzco es la misma que tiene
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT password FROM users WHERE id = $userid";
    $rec = mysqli_query($conn, $sql);
    $count = 0;
    $row = mysqli_fetch_array($rec);
    if (strcmp($row['password'], sha1($pass)) == 0) {
        return 1; //son iguales
    } else {
        return 2; //no son iguales
    }
}

if (isset($_POST['aceptarInvitacion'])) {
    session_start();
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql1 = "UPDATE users_users set acepta = 'y' where user_id = " . $_POST['idUsuario'] . " and user_id1 = " . $_SESSION['userid'] . ";";
    if ($conn->query($sql1) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
    header('location: miscontactos.php');
}
if (isset($_POST['rechazarInvitacion'])) {
    session_start();
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql1 = "UPDATE users_users set acepta = 'n' where user_id = " . $_POST['idUsuario'] . " and user_id1 = " . $_SESSION['userid'] . ";";
    if ($conn->query($sql1) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
    header('location: miscontactos.php');
}

function validar_email($email) {

    $_SESSION['error']['email'] = array();
    $errors = 0;
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo("$email is a valid email address");
        if (trim($email) == '') {
            $_SESSION['error']['contacto'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir un email</label></p>';
            $errors++;
        } else if (!preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/", $email)) {
            $_SESSION['error']['contacto'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir un email correcto </label></p>';
            $errors++;
        } else if (strlen($email) > 50) {
            $_SESSION['error']['contacto'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir un email menor de 50 caracteres</label></p>';
            $errors++;
        }
    } else {
        $_SESSION['error']['contacto'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir un email correcto</label></p>';
        $errors++;
    }
    return $errors;
}

function validar_apellidos($ape) {
    $apellidos = filter_var($ape, FILTER_SANITIZE_STRING);
    $errors = 0;
    $_SESSION['error']['apellidos'] = array();
    if (trim($apellidos) == '') {
        $_SESSION['error']['apellidos'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir los apellidos</label></p>';
        $errors++;
    } else if (strlen($apellidos) > 50) {
        $_SESSION['error']['apellidos'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Los apellidos no debe ser superior a 50 caracteres</label></p>';
        $errors++;
    }
    return $errors;
}

if (isset($_POST['add'])) {
    session_start();
    $_SESSION['error']['contacto'] = null;
    $_SESSION['error']['contacto'] = array();
    $errors = validar_email($_POST['email']);
    if ($errors == 0) {
        include_once 'conexion.php';
        $conn = cogerConexion();
        $sql1 = "select * from users where email = '" . $_POST['email'] . "'";
        $rec = mysqli_query($conn, $sql1);
        $count = 0;
        $result;
        while ($row = mysqli_fetch_array($rec)) {
            $count++;
            $result = $row;
        }
        $id = $result['id'];

        if ($id != $_SESSION['userid']) {
            if ($count == 1) {
                $stmt = $conn->prepare("INSERT INTO users_users (user_id, user_id1) VALUES (?, ?)");
                $stmt->bind_param('ii', $_SESSION['userid'], $id);
                $stmt->execute();
                $newId = $stmt->insert_id;
                $stmt->close();
            } else {
                $_SESSION['error']['contacto'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">El email introducido no pertence a ningun usuario</label></p>';
                header('location: addcontacto.php');
                exit();
            }
            $conn->close();
            header('location: miscontactos.php');
        } else {
            $_SESSION['error']['contacto'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">No puede añadirse a si mismo como contacto</label></p>';
            header('location: addcontacto.php');
            exit();
        }
    } else {
        header('location: addcontacto.php');
    }
}

if (isset($_POST['eliminarContacto'])) { //modificar a poner desabilitado
    require_once 'conexion.php';
    $conn = cogerConexion();
    session_start();
    require_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "delete from users_users where user_id =" . $_SESSION['userid'] . " and user_id1 = " . $_POST['idContacto'];
    $sql1 = "delete from users_users where user_id =" . $_POST['idContacto'] . " and user_id1 = " . $_SESSION['userid'];
    $sql2 = "select * from groups where user_id = " . $_SESSION['userid'];
    $sql3 = "select * from events where user_id = " . $_SESSION['userid'];
    mysqli_query($conn, $sql);
    mysqli_query($conn, $sql1);

    $result = mysqli_query($conn, $sql2);
    $result1 = mysqli_query($conn, $sql3);
    $querys = "";
    foreach ($result as $a) {
        include_once 'conexion.php';
        $querys .= "delete from groups_users where group_id = " . $a['id'] . " and user_id = " . $_POST['idContacto'] . ";";
    }
    $porciones = explode(";", $querys);
    for ($j = 0; $j < count($porciones) - 1; $j++) {
        $result = mysqli_query($conn, $porciones[$j]);
    }
    $querys = "";
    foreach ($result1 as $a) {
        include_once 'conexion.php';
        $querys .= "delete from events_users where event_id = " . $a['id'] . " and user_id = " . $_POST['idContacto'] . ";";
    }
    $porciones = explode(";", $querys);
    for ($j = 0; $j < count($porciones) - 1; $j++) {
        $result = mysqli_query($conn, $porciones[$j]);
    }

    mysqli_close($conn);
    header('location: miscontactos.php');
}