<?php
    function traer_mis_grupos1($id) { //traigo los grupos en los que estoy invitado y no soy dueño
        include_once 'conexion.php';
        $conn = cogerConexion();
        $sql = "SELECT groups.id, groups.name, description FROM groups join groups_users on groups.id = groups_users.group_id join users on groups.user_id = users.id where groups.user_id != $id and groups_users.user_id = $id and users.habilitado = 'y'";
        $result = mysqli_query($conn, $sql);
        $i = 0;
        $resultado = array();
        foreach ($result as $value) {
            $resultado[$i++] = $value;
        }
        mysqli_close($conn);
        return $resultado;
    }

    function traer_mis_grupos($id) { //traigo los grupos de los qye soy dueño
        include_once 'conexion.php';
        $conn = cogerConexion();
        $sql = "SELECT id, name, description FROM groups WHERE user_id=$id";
        $result = mysqli_query($conn, $sql);
        $i = 0;
        $resultado = array();
        foreach ($result as $value) {
            $resultado[$i++] = $value;
        }
        mysqli_close($conn);
        return $resultado;
    }

    function crear_grupo($name, $description, $user) {
        include_once 'conexion.php';
        $conn = cogerConexion();
        $stmt = $conn->prepare("INSERT INTO groups (name,description,user_id) VALUES (?, ?, ?)");
        $stmt->bind_param('ssi', $name, $description, $user);
        $stmt->execute();
        $newId = $stmt->insert_id;
        add_contacto($newId, $user);
        $stmt->close();
        header('location: misgrupos.php');
    }

    function add_contacto($group, $user) {
        include_once 'conexion.php';
        $conn = cogerConexion();
        $stmt = $conn->prepare("INSERT INTO groups_users (group_id, user_id) VALUES (?, ?)");
        $stmt->bind_param('ii', $group, $user);
        $stmt->execute();
        $newId = $stmt->insert_id;
        $stmt->close();
    }

    function quitar_invitacion_grupo($group, $user) {
        include_once 'conexion.php';
        $conn = cogerConexion();
        $sql = "DELETE from groups_users where group_id = $group and user_id = $user";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
        $conn->close();
    }

    function eliminar_grupo($group) {
        include_once 'conexion.php';
        $conn = cogerConexion();

        //elimnar gente perteneciente al grupo
        $sql = "select user_id from groups_users where group_id = $group";
        $result = mysqli_query($conn, $sql);
        print_r($result);
        $querys = "";
        foreach ($result as $a) {
            $querys .= "delete from groups_users where group_id = " . $group . " and user_id = " . $a['user_id'] . ";";
        }
        $porciones = explode(";", $querys);
        for ($j = 0; $j < count($porciones) - 1; $j++) {
            $result = mysqli_query($conn, $porciones[$j]);
        }

//    elimnar grupo
        $sql = "DELETE from groups where id = $group";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
        $conn->close();
    }

    if (isset($_POST["addInGroup"])) {
        session_start();
        include_once 'conexion.php';
        $conn = cogerConexion();
        $sql = "SELECT * FROM groups_users WHERE user_id= " . $_POST['usuarioAdd'] . " and group_id = " . $_SESSION['idGrupo'];
        $result = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));
        if (!mysqli_num_rows($result) > 0) { //no a sido invitado
            add_contacto($_SESSION['idGrupo'], $_POST['usuarioAdd']);
        }
        header('location: addcontactos.php');
    }
    if (isset($_POST["deleteForGroup"])) {
        session_start();
        include_once 'conexion.php';
        $conn = cogerConexion();
        $sql = "SELECT * FROM groups_users WHERE user_id= " . $_POST['usuarioAdd'] . " and group_id = " . $_SESSION['idGrupo'];
        $result = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));
        if (mysqli_num_rows($result) == 1) { //tiene una invitacion
            quitar_invitacion_grupo($_SESSION['idGrupo'], $_POST['usuarioAdd']);
        }
        header('location: addcontactos.php');
    }
    if (isset($_POST["salirGrupo"])) {
        session_start();
        quitar_invitacion_grupo($_POST['idGrupo'], $_SESSION['userid']);
        header('location: misgrupos.php');
    }
    if (isset($_POST["crear"])) {
        session_start();
        session_start();
        $_SESSION['error']['grupo'] = null;
        $_SESSION['error']['grupo'] = array();
        $errors = validar_nombre1($_POST['name']);
        $errors += validar_descripcion($_POST['description']);

        if ($errors == 0) {
            crear_grupo($_POST['name'], $_POST['description'], $_SESSION['userid']);
            header('location: misgrupos.php');
        } else {
            header('location: creargrupo.php');
        }
    }
    if (isset($_POST["eliminarGrupo"])) {
        session_start();
        eliminar_grupo($_POST['idGrupo']);
        header('location: misgrupos.php');
    }

    function validar_nombre1($nom) {
        $errors = 0;
        $nombre = filter_var($nom, FILTER_SANITIZE_STRING);
        if (trim($nombre) == '') {
            $_SESSION['error']['grupo'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir el nombre del grupo</label></p>';
            $errors++;
        } else if (strlen($nombre) > 20) {
            $_SESSION['error']['grupo'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">El nombre no debe ser mayor de 20</label></p>';
            $errors++;
        }
        return $errors;
    }

    function validar_descripcion($des) {
        $errors = 0;
        $descripcion = filter_var($des, FILTER_SANITIZE_STRING);
        if (trim($descripcion) == '') {
            $_SESSION['error']['grupo'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir la descripcion</label></p>';
            $errors++;
        } else if (strlen($descripcion) > 200) {
            $_SESSION['error']['grupo'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">La descripcion debe ser menor de 200 caracteres</label></p>';
            $errors++;
        }
        return $errors;
    }

