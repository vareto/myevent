<?php

function validar_email($email) {
    $errors = 0;
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo("$email is a valid email address");
        if (trim($email) == '') {
            $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir un email</label></p>';
            $errors++;
        } else if (!preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/", $email)) {
            $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir un email correcto </label></p>';
            $errors++;
        } else if (strlen($email) > 50) {
            $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir un email menor de 50 caracteres</label></p>';
            $errors++;
        }
    } else {
        $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir un email correcto</label></p>';
        $errors++;
    }
    return $errors;
}

function validar_password($password, $tipo) {
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $errors = 0;

    if (trim($password) == '') {
        $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir una contraseña ' . $tipo . ' </label></p>';
        $errors++;
    } else if (strlen($password) < 8 || strlen($password) > 20) {
        $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">La contraseña ' . $tipo . ' no debe ser menor de 8 caracteres o mayor de 20</label></p>';
        $errors++;
    }
    return $errors;
}

function validar_nombre($nom) {
    $nombre = filter_var($nom, FILTER_SANITIZE_STRING);
    $errors = 0;
    $_SESSION['error']['usuario'] = array();
    if (trim($nombre) == '') {
        $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir un nombre</label></p>';
        $errors++;
    } else if (strlen($nombre) > 20) {
        $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">El nombre no debe ser superior a 20 caracteres</label></p>';
        $errors++;
    }
    return $errors;
}

function validar_apellidos($ape) {
    $apellidos = filter_var($ape, FILTER_SANITIZE_STRING);
    $errors = 0;
    $_SESSION['error']['usuario'] = array();
    if (trim($apellidos) == '') {
        $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir los apellidos</label></p>';
        $errors++;
    } else if (strlen($apellidos) > 50) {
        $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Los apellidos no debe ser superior a 50 caracteres</label></p>';
        $errors++;
    }
    return $errors;
}

function generate_random_key() {
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $new_key = "";
    for ($i = 0; $i < 32; $i++) {
        $new_key .= $chars[rand(0, 35)];
    }
    return $new_key;
}

function verificar_login($email, $password, &$result) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT * FROM users WHERE email='$email' and password='" . sha1($password) . "' and active='y' and habilitado='y'";
    $rec = mysqli_query($conn, $sql);
    $count = 0;
    while ($row = mysqli_fetch_array($rec)) {
        $count++;
        $result = $row;
    }
    if ($count == 1) {
        return 1;
    } else {
        return 0;
    }
}

function existe_usuario($email) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
//    print_r($num);
    if ($num == 1) { //existe usuario
        $row = mysqli_fetch_array($result);
        if (strcmp($row['active'], "y") == 0) {
            if (strcmp($row['habilitado'], "y") == 0) {
                return 1;
            } else {
                $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Ese email no tiene habilitada su cuenta</label></p>';
                header('location: login.php');
            }
        } else {
            $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Ese email no tiene activada su cuenta</label></p>';
            header('location: login.php');
        }
        return 1;
    } else {
        return 0;
    }
}

function cuenta_no_activada($email) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
//    print_r($num);
    if ($num == 1) { //existe usuario
        $row = mysqli_fetch_array($result);
        if (strcmp($row['active'], "") == 0 || strcmp($row['active'], "n") == 0) {
            return 1;
        } else {
            return 0;
        }
    } else {
        $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Ese email no tiene cuenta en nuestro servicio</label></p>';
        header('location: habilitaruser.php');
        return 0;
    }
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

function cambiar_pass($pass, $userid) { //cambiar pass
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "UPDATE users set password = '" . sha1($pass) . "' where id = $userid";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
}

function validar_fichero($ficheros) {
    $errors = 0;
    $tot = count($_FILES["pic"]["name"]);
    $con = 0;
    if ($_FILES["pic"]["error"] != 4 or $tot > 1) {
        if ((($_FILES["pic"]["type"] == "image/png") ||
                ($_FILES["pic"]["type"] == "image/jpeg") || ($_FILES["pic"]["type"][$i] == "image/jpg") ||
                ($_FILES["pic"]["type"] == "image/pjpeg") ) &&
                ($_FILES["pic"]["size"] < 5000000)) {
            
        } else {
            $_SESSION['error']['perfil'] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">El fichero ' . $_FILES["pic"]["name"] . ' no deben superar los 5MB y deben ser (jpg,png)' . $tot . '</label></p>';
            $errors++;
        }
    }
    return $errors;
}

function habilitar_user($email) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT * FROM users WHERE email='$email'  and active='y' and habilitado='n'";
    $rec = mysqli_query($conn, $sql);
    $count = 0;
    while ($row = mysqli_fetch_array($rec)) {
        $count++;
        $result = $row;
    }
    if ($count == 1) {
        $sql = "UPDATE users set habilitado = 'y' where email = '" . $email . "'";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
        $conn->close();
        header('location: login.php');
    } else {
        return 0;
    }
}

function editar_usuario($id, $nombre, $apellidos, $pic, $email) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "UPDATE users set name = '$nombre', last_name = '$apellidos', picuser='$pic', email = '$email' where id = " . $id;
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
    header('location: index.php');
}

function editar_usuario_sinfoto($id, $nombre, $apellidos, $email) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "UPDATE users set name = '$nombre', last_name = '$apellidos', email = '$email' where id = " . $id;
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
    header('location: index.php');
}

function traer_email_user($id) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT email FROM users WHERE id = $id";
    $rec = mysqli_query($conn, $sql);
    $count = 0;
    $row = mysqli_fetch_array($rec);
    return $row['email'];
}

function traer_id_user($email) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT id FROM users WHERE email ='$email'";
    $rec = mysqli_query($conn, $sql);
    $count = 0;
    $row = mysqli_fetch_array($rec);
    return $row['id'];
}

function traer_usuario_editar($id) {
    require_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_array($result);
}

if (isset($_POST['habilitar'])) {
    session_start();
    $_SESSION['error']['usuario'] = null;
    $_SESSION['error']['usuario'] = array();
    $errors = 0;
    $errors += validar_email($_POST['email']);

    if ($errors == 0) {
        if (cuenta_no_activada($_POST['email']) == 1) { //la cuenta no esta actiavada
            $id = traer_id_user($_POST['email']);
            $random_key = generate_random_key();
            include_once 'conexion.php';
            $dbh = cogerConexion();
            $stm = $dbh->prepare("update users set activation_key = ? where email = ?");
            $stm->bind_param("ss", $random_key, $_POST['email']);
            $stm->execute();
            $stm->close();

            mail($_POST['email'], "iEvent - Activación de la cuenta", "Bienvenido a iEvent!
        Gracias por registrarse en nuestro sitio.
         Su cuenta ha sido creada, y debe ser activada antes de poder ser utilizada.
        Para activar la cuenta, haga click en el siguiente enlace o copielo en la
        barra de direcciones del navegador,
     
        ievent.esy.es/activacion.php?activation=" . $random_key);
            header('location: login.php');
        } else {
            $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Ese email se encuentra activo</label></p>';
            header('location: recuperar.php');
        }
        habilitar_user($_POST['email']);
        header('location: login.php');
    } else {
        header('location: habilitaruser.php');
    }
}

if (isset($_POST['recuperarcredenciales'])) {
    session_start();
    $_SESSION['error']['usuario'] = null;
    $_SESSION['error']['usuario'] = array();
    $errors = 0;
    $errors += validar_email($_POST['email']);

    if ($errors == 0) {
        if (existe_usuario($_POST['email']) == 1) { //si el email existe cambiamos la contraseña y le enviamos un correo con los nuevos datos
            $id = traer_id_user($_POST['email']);
            $passnueva = generate_random_key();
            cambiar_pass($passnueva, $id);
            mail($_POST['email'], "iEvent - Cambio de contraseña", "Le informamos que acaba de cambiar la contraseña de acceso"
                    . "Los nuevos datos de acceso son:"
                    . "email:" . $_POST['email'] . ""
                    . "password:" . $passnueva);
            header('location: login.php');
        } else {
            $_SESSION['error']['usuario'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Ese email no tiene cuenta en nuestro servicio</label></p>';
            header('location: recuperar.php');
        }
    } else {
        header('location: recuperar.php');
    }
}

if (isset($_POST['cambiarPass'])) {
    session_start();
    $_SESSION['error']['usuario'] = null;
    $_SESSION['error']['usuario'] = array();
    $errors = 0;
    $errors += validar_password($_POST['passAntigua'], "antigua");
    $errors += validar_password($_POST['passNueva'], "nueva");
    $errors += validar_password($_POST['passNueva2'], "confirmacion");

    if ($errors == 0) {
        if (comprobar_pass($_POST['passAntigua'], $_SESSION['userid']) == 1) { //sabe la contraseña vieja
            if (strcmp($_POST['passNueva'], $_POST['passNueva2']) == 0) { //la nueva contraseña coincide
                cambiar_pass($_POST['passNueva'], $_SESSION['userid']);
                header('location: login.php');
                $email = traer_email_usuario($_SESSION['userid']);

                mail($email, "iEvent - Cambio de contraseña", "Le informamos que acaba de cambiar la contraseña de acceso"
                        . "Los nuevos datos de acceso son:"
                        . "email:" . $email . ""
                        . "password:" . $_POST['passNueva']);
                header('location: index.php');
            } else {
                header('location: cambiarpass.php');
            }
        } else {
            header('location: cambiarpass.php');
        }
    } else {
        header('location: cambiarpass.php');
    }
}

if (isset($_POST["registrar"])) {
    include_once 'conexion.php';
    $random_key = generate_random_key();
    $conn = cogerConexion();

    session_start();

    $_SESSION['error']['usuario'] = null;

    $errors = 0;
    $errors += validar_password($_POST['password'], "");
    $errors += validar_email($_POST['email']);
    $errors += validar_nombre($_POST['name']);
    $errors += validar_apellidos($_POST['last_name']);

    if ($errors == 0) {
        if (existe_usuario($_POST['email']) == 0) { //si no exite lo creamos
            $stmt = $conn->prepare("INSERT INTO users (name, last_name,email,password, activation_key,picuser) VALUES (?, ?, ?, ?, ?, ?)");
            $pic = "./archivos/picusers/default.jpg";
            $password = sha1($_POST['password']);
            $stmt->bind_param('ssssss', $_POST['name'], $_POST['last_name'], $_POST['email'], $password, $random_key, $pic);
            $stmt->execute();
            $newId = $stmt->insert_id;
            $stmt->close();
            $asunto = 'iEvent - Activación de la cuenta';
            $cabeceras .= "MIME-Version: 1.0\r\n";
            $cabeceras .= "Content-Type: text/html; charset=UTF-8\r\n";
            $cabeceras .= "X-Mailer:PHP/" . phpversion() . "\n";
            $mensaje = '<html><head>
     </head><body>';
            $mensaje .= "<p>Gracias por registrarse en nuestro sitio.
         Su cuenta ha sido creada, y debe ser activada antes de poder ser utilizada.
        Para activar la cuenta, haga click en el siguiente enlace o copielo en la
        barra de direcciones del navegador</p> ";
            $mensaje .= "<a class='enlaceactivacion' style='font-family: verdana, arial, sans-serif;
                                     font-size: 15pt;
                                     font-weight: bold;
                                     padding: 4px;
                                     background-color: blue;
                                     color: white;
                                     text-decoration: none;
                                     border-radius: 7px 7px 7px 7px;
                                     -moz-border-radius: 7px 7px 7px 7px;
                                     -webkit-border-radius: 7px 7px 7px 7px;
                                     border: 0px solid #000000;' href='ievent.esy.es/activacion.php?activation=$random_key'>ACTIVAR CUENTA</a>";
            $mensaje .= "</body></html>";
            mail($_POST['email'], $asunto, $mensaje, $cabeceras);

            header('location: success.php');
        } else {
            //error existe usuario
            $_SESSION['error']['usuario'][] = '<p><label  style="color:#FF0000;" class="control-label" for="inputError">El email usado ya esta registrado</label></p>';
            header('location: registrar.php');
        }
    } else {
        header('location: registrar.php');
    }
}

if (isset($_POST['login'])) {
    session_start();
    $_SESSION['error']['usuario'] = null;
    $_SESSION['error']['usuario'] = array();

    $errors = 0;
    $errors += validar_password($_POST['password'], "");
    $errors += validar_email($_POST['email']);

    if ($errors == 0) {
        if (existe_usuario($_POST['email']) == 1) {
            if (verificar_login($_POST['email'], $_POST['password'], $result) == 1) {
                $_SESSION['userid'] = $result['id'];
                $_SESSION['username'] = $result['name'];
                header("location:index.php");
            } else {
                $_SESSION['error']['usuario'][] = '<p><label  style="color:#FF0000;" class="control-label" for="inputError">El usuario o contraseña son incorrectos</label></p>';
                header('location: login.php');
            }
        } else {
            $_SESSION['error']['usuario'][] = '<p><label  style="color:#FF0000;" class="control-label" for="inputError">El usuario introducido no existe</label></p>';
            header('location: login.php');
        }
    } else {
        header('location: login.php');
    }
}

if (isset($_POST['guardar'])) {
    session_start();
    $_SESSION['error']['usuario'] = null;
    $_SESSION['error']['usuario'] = array();

    $errors = validar_email($_POST['email']);
    $errors = validar_nombre($_POST['name']);
    $errors = validar_apellidos($_POST['last_name']);
    $errors = validar_fichero($_FILES["pic"]);

    $tot = count($_FILES["pic"]["name"]);

    require_once 'conexion.php';
    $conn = cogerConexion();

    mysqli_close($conn);

    if ($errors == 0) {
        if ($_FILES["pic"]["error"] != 4 or $tot > 1) {
            if ((($_FILES["pic"]["type"] == "image/png") ||
                    ($_FILES["pic"]["type"] == "image/jpeg") || ($_FILES["pic"]["type"] == "image/jpg") ||
                    ($_FILES["pic"]["type"] == "image/pjpeg") ) &&
                    ($_FILES["pic"]["size"] < 20000000)) {
                if ($_FILES["pic"]["error"] > 0) {
                    echo $_FILES["pic"]["error"] . "";
                } else {
                    $hora = time();
                    $url = "./archivos/picusers/" . "archivo" . $hora . $_FILES['pic']['name'];
                    editar_usuario($_SESSION['userid'], $_POST['name'], $_POST['last_name'], $url, $_POST['email']);
                    move_uploaded_file($_FILES["pic"]["tmp_name"], $url);
                    header('location: index.php');
                }
            }
        } else {
            editar_usuario_sinfoto($_SESSION['userid'], $_POST['name'], $_POST['last_name'], $_POST['email']);
            header('location: index.php');
        }
    } else {
        header('location: perfil.php');
    }
}

    