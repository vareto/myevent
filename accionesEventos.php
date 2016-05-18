<?php

function traer_mis_eventos($id) { //traer evento que ha creado e usuario
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT * FROM events WHERE user_id=$id";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function traer_mis_eventos_index($id) { //traer evento que ha creado e usuario
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT * FROM events WHERE user_id=$id" . " order by events.fecha asc limit 5";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function traer_proximos_eventos($id) { //traer eventos a los que ha sido el invitado y aun no han ocurrido
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT events_users.event_id, events.name, events.description, events.fecha, asistencia FROM `events` join events_users on events.id = events_users.event_id join users on events.user_id = users.id where events_users.user_id = $id and users.habilitado = 'y' and events.fecha >= '" . date("Y-m-d") . "'";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function traer_proximos_eventos_index($id) { //traer eventos a los que ha sido el invitado y aun no han ocurrido
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT events_users.event_id, events.name, events.description, events.fecha, asistencia FROM `events` join events_users on events.id = events_users.event_id join users on events.user_id = users.id where events_users.user_id = $id and users.habilitado = 'y' and events.fecha >= '" . date("Y-m-d") . "'" . " and events.user_id != $id order by events.fecha asc limit 5";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function num_proximos_eventos_sin_confirmar($id) { //traer eventos a los que ha sido el invitado y aun no han ocurrido
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT events_users.event_id, events.name, events.description, events.fecha, asistencia FROM `events` join events_users on events.id = events_users.event_id join users on events.user_id = users.id where events_users.user_id = $id and users.habilitado = 'y' and events.fecha >= '" . date("Y-m-d") . "'" . "and events_users.asistencia = ''";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    return $num;
}

function crear_evento($name, $description, $user, $fecha) {  //crear evento
    include_once 'conexion.php';
    $conn = cogerConexion();
    $stmt = $conn->prepare("INSERT INTO events (name,description,user_id,fecha) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssis', $name, $description, $user, $fecha);
    $stmt->execute();
    $newId = $stmt->insert_id;
    $stmt->close();
    return $newId;
}

function traer_evento_editar_asistencia($idevent, $iduser) { //obtener datos de un evento que vamos a editar
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT * FROM `events` join events_users where events.id = events_users.event_id and events_users.user_id = $iduser and events.id =" . $idevent;
    $result = mysqli_query($conn, $sql);
    $a = mysqli_fetch_array($result);
    return $a;
}

function traer_evento_editar($id) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT * FROM events WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $a = mysqli_fetch_array($result);
    return $a;
}

function editar_evento($name, $description, $fecha, $idevento) { //realizar actualizacion de un evento
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql1 = "UPDATE events set name = '$name' , description = '$description', fecha = '$fecha' where id = " . $idevento . ";";
    if ($conn->query($sql1) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
    header('location: miseventos.php');
}

function editar_evento_asistencia($asistencia, $idevento, $iduser) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "UPDATE events_users set asistencia = '$asistencia' where event_id = " . $idevento . " and user_id = " . $iduser . ";";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
    header('location: index.php');
}

function crear_invitacion($event, $user) { //crear una invitacion a un usuario a algun eento nuestro
    include_once 'conexion.php';
    $conn = cogerConexion();
    $key = generate_random_key();
    $stmt = $conn->prepare("INSERT INTO events_users (event_id, user_id, token) VALUES (?, ?, ?)");
    $stmt->bind_param('iis', $event, $user, $key);
    $stmt->execute();
    $newId = $stmt->insert_id;

    $sql1 = "Select user_id, name from events where id=$event";
    $array = mysqli_fetch_array(mysqli_query($conn, $sql1));
    $creador = $array['user_id'];
    $evento = $array['name'];

    $sql2 = "select * from users where id=$creador ";
    $array1 = mysqli_fetch_array(mysqli_query($conn, $sql2));
    $nombre = $array1['name'];


    $si = sha1("si");
    $no = sha1("no");
    $sql = "SELECT email from users where id=$user";
    $array = mysqli_fetch_array(mysqli_query($conn, $sql));
    $email = $array['email'];
    $asunto = 'Nueva invitacion iEvent';
    $cabeceras .= "MIME-Version: 1.0\r\n";
    $cabeceras .= "Content-Type: text/html; charset=UTF-8\r\n";
    $cabeceras .= "X-Mailer:PHP/" . phpversion() . "\n";
    $mensaje = '<html><head>
     </head><body>';
    $mensaje .= "<p>Tiene una nueva invitacion  de <b> $nombre </b> al evento titulado <b> $evento </b>.</p>
       <p> Recuerde que para mayor informacion sobre el evento debe aceder a su cuenta a traver del siguiente enlace <a href='http://ievent.esy.es'>iEvent</a></p>";
    $mensaje .= "<p> Tambien puede aceptar/rechazar el evento con los siguentes botones</p>";
    $mensaje .= "<a  class='enlacebotonacepto' style='font-family: verdana, arial, sans-serif;
                                    font-size: 15pt;
                                    font-weight: bold;
                                    padding: 4px;
                                    background-color: green;
                                    color: white;
                                    text-decoration: none;
                                    border-radius: 7px 7px 7px 7px;
                                    -moz-border-radius: 7px 7px 7px 7px;
                                    -webkit-border-radius: 7px 7px 7px 7px;
                                    border: 0px solid #000000;' href='ievent.esy.es/asistenciaevento.php?confirmacion=$si&token=$key'>ACEPTO</a>";
    $mensaje .= "  ";
    $mensaje .= "<a class='enlacebotonrechazo' style='font-family: verdana, arial, sans-serif;
                                     font-size: 15pt;
                                     font-weight: bold;
                                     padding: 4px;
                                     background-color: red;
                                     color: white;
                                     text-decoration: none;
                                     border-radius: 7px 7px 7px 7px;
                                     -moz-border-radius: 7px 7px 7px 7px;
                                     -webkit-border-radius: 7px 7px 7px 7px;
                                     border: 0px solid #000000;' href='ievent.esy.es/asistenciaevento.php?confirmacion=$no&token=$key'>RECHAZO</a>";
    $mensaje .= "</body></html>";
    mail($email, $asunto, $mensaje, $cabeceras);
    $stmt->close();
}

function crear_invitacion_dueño($event, $user) { //crear una invitacion a un usuario a algun eento nuestro
    include_once 'conexion.php';
    $asistencia = "SI";
    $conn = cogerConexion();
    $stmt = $conn->prepare("INSERT INTO events_users (event_id, user_id, asistencia) VALUES (?, ?, ?)");
    $stmt->bind_param('iis', $event, $user, $asistencia);
    $stmt->execute();
    $newId = $stmt->insert_id;
    $stmt->close();
}

function generate_random_key() {
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $new_key = "";
    for ($i = 0; $i < 50; $i++) {
        $new_key .= $chars[rand(0, 35)];
    }
    return $new_key;
}

function quitar_invitacion_evento($event, $user) { //quitar una invitacion a un usuario
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "DELETE from events_users where event_id = $event and user_id = $user";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
}

function traer_evento($id) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT * from events where id=$id";
    $result = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($result);
    return $result;
}

function traer_asistentes($id) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT picuser, name, last_name  FROM events_users join users on events_users.user_id = users.id where events_users.event_id = $id and events_users.asistencia = 'SI'";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function traer_no_asistentes($id) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT picuser, name, last_name  FROM events_users join users on events_users.user_id = users.id where events_users.event_id = $id and (events_users.asistencia = '' or events_users.asistencia = 'NO')";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function es_dueño($iduser, $idevent) {
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "SELECT user_id FROM events where id= $idevent";
    $result = mysqli_query($conn, $sql);
    $datos = mysqli_fetch_array($result);
    $dueño = $datos['user_id'];
    $retur = null;
    if($dueño === $iduser){
        $retur =  true;
    }else {
        $retur =  false;
    } 
    return $retur;
}

function eliminar_evento($evento) {
    include_once 'conexion.php';
    $conn = cogerConexion();

//elimnar gente invitada al evento
    $sql = "select user_id from events_users where event_id = $evento";
    $result = mysqli_query($conn, $sql);
    $querys = "";
    foreach ($result as $a) {
        $querys .= "delete from events_users where event_id = " . $evento . " and user_id = " . $a['user_id'] . ";";
    }
    $porciones = explode(";", $querys);
    for ($j = 0; $j < count($porciones) - 1; $j++) {
        $result = mysqli_query($conn, $porciones[$j]);
    }

//elimnar archivos pertenecientes al evento
    $sql = "select id, url from files where event_id = $evento";
    $result = mysqli_query($conn, $sql);
    $querys = "";
    foreach ($result as $a) {
        $querys .= "delete from files where id = " . $a['id'] . ";";
        unlink($a['url']); //borramos archivos del servidor
    }
    $porciones = explode(";", $querys);
    for ($j = 0; $j < count($porciones) - 1; $j++) {
        $result = mysqli_query($conn, $porciones[$j]);
    }

    $sql = "DELETE from events where id = $evento";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
}

function cambiar_formato_fecha_guardar($date) {
    $date1 = new DateTime($date);
    return date_format($date1, 'Y-m-d');
}

function cambiar_formato_fecha_mostrar($date) {
    $date1 = new DateTime($date);
    return date_format($date1, 'd-m-Y');
}

function checkDateFormat($date) {
//match the format of the date
    if (preg_match("/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/", $date, $parts)) {
//check weather the date is valid of not
        if (checkdate($parts[2], $parts[1], $parts[3]))
            return true;
        else
            return false;
    } else
        return false;
}

function validar_nombre($nom) {
    $errors = 0;
    $nombre = filter_var($nom, FILTER_SANITIZE_STRING);
    if (trim($nombre) == '') {
        $_SESSION['error']['evento'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir el nombre del evento</label></p>';
        $errors++;
    } else if (strlen($nombre) > 30) {
        $_SESSION['error']['evento'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">El nombre no debe ser mayor de 30</label></p>';
        $errors++;
    } else {
        
    }
    return $errors;
}

function validar_descripcion_evento($des) {
    $errors = 0;
    $descripcion = filter_var($des, FILTER_SANITIZE_STRING);
    if (trim($descripcion) == '') {
        $_SESSION['error']['evento'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir la descripcion del evento</label></p>';
        $errors++;
    }
    return $errors;
}

function validar_fecha($fecha) {
    $errors = 0;
    $fecha_actual = date("d-m-Y");
    if (trim($fecha) == '') {
        $_SESSION['error']['evento'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir la fecha del evento</label></p>';
        $errors++;
    } else if (checkDateFormat($fecha) == false) {
        $_SESSION['error']['evento'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir la fecha en el formato correcto dd-mm-yyyy</label></p>';
        $errors++;
    } else if ((strtotime($fecha) >= strtotime($fecha_actual)) != 1) {
        $_SESSION['error']['evento'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir una fecha posterior a hoy</label></p>';
        $errors++;
    }
    return $errors;
}

function validar_ficheros($ficheros) {
    $errors = 0;
    $tot = count($_FILES["userfile"]["name"]);
    $con = 0;

    if ($_FILES["userfile"]["error"][0] != 4 or $tot > 1) {

        for ($i = 0; $i < $tot; $i++) {
            if ((($_FILES["userfile"]["type"][$i] == "image/png") ||
                    ($_FILES["userfile"]["type"][$i] == "image/jpeg") || ($_FILES["userfile"]["type"][$i] == "image/jpg") ||
                    ($_FILES["userfile"]["type"][$i] == "image/pjpeg") || ($_FILES["userfile"]["type"][$i] == "application/pdf") ) &&
                    ($_FILES["userfile"]["size"][$i] < 5000000)) {
                
            } else {
                $_SESSION['error']['evento'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">El fichero ' . $_FILES["userfile"]["name"][$i] . ' no deben superar los 5MB y deben ser (jpg,png o pdf)' . $tot . '</label></p>';
                $errors++;
            }
        }
    }

    return $errors;
}

function validar_descripciones_ficheros($descripciones) {
    $errors = 0;
    $tot = count($_FILES["userfile"]["name"]);
    $con = 0;

    if ($_FILES["userfile"]["error"][0] != 4 or $tot > 1) {
        for ($i = 0; $i < $tot; $i++) {
            $descripcion = filter_var($descripciones[$i], FILTER_SANITIZE_STRING);
            if (trim($descripcion) == '') {
                $_SESSION['error']['evento'][] = '<p><label style="color:#FF0000;" class="control-label" for="inputError">Debe introducir la descripcion del fichero</label></p>';
                $errors++;
            }
        }
    }

    return $errors;
}

if (isset($_POST["crearEvento"])) {
    require_once 'accionesFiles.php';
    session_start();
    $_SESSION['error']['evento'] = null;
    $_SESSION['error']['evento'] = array();
    $errors = validar_nombre($_POST['name']);
    $errors += validar_descripcion_evento($_POST['description']);
    $errors += validar_fecha($_POST['fecha']);
    $errors += validar_ficheros($_FILES["userfile"]);
    $errors += validar_descripciones_ficheros($_POST['descripcionFicheros']);
    if ($errors == 0) {
        if (isset($_FILES["userfile"])) {
//de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo
//obtenemos la cantidad de elementos que tiene el arreglo archivos
            $tot = count($_FILES["userfile"]["name"]);
            $con = 0;
//este for recorre el arreglo
            for ($i = 0; $i < $tot; $i++) {
//con el indice $i, poemos obtener la propiedad que desemos de cada archivo
//para trabajar con este
                $tmp_name = $_FILES["userfile"]["tmp_name"][$i];
                $name = $_FILES["userfile"]["name"][$i];

                if ((($_FILES["userfile"]["type"][$i] == "image/png") ||
                        ($_FILES["userfile"]["type"][$i] == "image/jpeg") || ($_FILES["userfile"]["type"][$i] == "image/jpg") ||
                        ($_FILES["userfile"]["type"][$i] == "image/pjpeg") || ($_FILES["userfile"]["type"][$i] == "application/pdf") ) &&
                        ($_FILES["userfile"]["size"][$i] < 5000000)) {

//Si es que hubo un error en la subida, mostrarlo, de la variable $_FILES podemos extraer el valor de [error], que almacena un valor booleano (1 o 0).
                    if ($_FILES["userfile"]["error"][$i] > 0) {
                        echo $_FILES["userfile"]["error"][$i] . "";
                        $error = true;
                    } else {
// Si no hubo ningun error, hacemos otra condicion para asegurarnos que el archivo no sea repetido
                        $hora = time();
                        $typemime = $_FILES["userfile"]["type"][$i];
                        $idcreado;
                        $con++;
                        if ($con == 1) {
                            $idcreado = crear_evento($_POST['name'], $_POST['description'], $_SESSION['userid'], $_POST['fecha']);
                            crear_invitacion_dueño($idcreado, $_SESSION['userid']);
                        }
                        $url = "./archivos/filesevents/" . "archivo" . $hora . $_FILES['userfile']['name'][$i];
                        crear_fichero($_POST['descripcionFicheros'][$i], $idcreado, $url, $typemime);
// Si no es un archivo repetido y no hubo ningun error, procedemos a subir a la carpeta /archivos, seguido de eso mostramos la imagen subida
                        move_uploaded_file($_FILES["userfile"]["tmp_name"][$i], $url);
                        header('location: miseventos.php');
                    }
                }
            }
            if ($con == 0) {
                $date = cambiar_formato_fecha_guardar($_POST['fecha']);
                $idcreado = crear_evento($_POST['name'], $_POST['description'], $_SESSION['userid'], $date);
                crear_invitacion_dueño($idcreado, $_SESSION['userid']);
                header('location: miseventos.php');
            }
        }
    } else {
        header('location: crearevento.php');
    }
}

if (isset($_POST["borrarEvento"])) {
    session_start();
    eliminar_evento($_POST['idevento']);
    header('location: miseventos.php');
}

if (isset($_POST["asiste"])) {
    session_start();
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "UPDATE events_users set asistencia = 'SI' where event_id = " . $_POST['idevento'] . " and user_id = " . $_SESSION['userid'] . ";";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
    header('location: proximoseventos.php');
}

if (isset($_POST["noAsiste"])) {
    session_start();
    include_once 'conexion.php';
    $conn = cogerConexion();
    $sql = "UPDATE events_users set asistencia = 'NO' where event_id = " . $_POST['idevento'] . " and user_id = " . $_SESSION['userid'] . ";";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
    header('location: proximoseventos.php');
}

if (isset($_POST["subirFichero"])) {
    require_once 'accionesFiles.php';

    session_start();
    $_SESSION['error']['evento'] = null;
    $_SESSION['error']['evento'] = array();


    $errors = validar_ficheros($_FILES["userfile"]);
    $errors += validar_descripciones_ficheros($_POST['descripcionFicheros']);

    if ($errors == 0) {
        if (isset($_FILES["userfile"])) {
//de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo
//obtenemos la cantidad de elementos que tiene el arreglo archivos
            $tot = count($_FILES["userfile"]["name"]);
            $con = 0;
//este for recorre el arreglo
            for ($i = 0; $i < $tot; $i++) {
//con el indice $i, poemos obtener la propiedad que desemos de cada archivo
//para trabajar con este
                $tmp_name = $_FILES["userfile"]["tmp_name"][$i];
                $name = $_FILES["userfile"]["name"][$i];

                if ((($_FILES["userfile"]["type"][$i] == "image/png") ||
                        ($_FILES["userfile"]["type"][$i] == "image/jpeg") || ($_FILES["userfile"]["type"][$i] == "image/jpg") ||
                        ($_FILES["userfile"]["type"][$i] == "image/pjpeg") || ($_FILES["userfile"]["type"][$i] == "application/pdf") ) &&
                        ($_FILES["userfile"]["size"][$i] < 5000000)) {

//Si es que hubo un error en la subida, mostrarlo, de la variable $_FILES podemos extraer el valor de [error], que almacena un valor booleano (1 o 0).
                    if ($_FILES["userfile"]["error"][$i] > 0) {
                        echo $_FILES["userfile"]["error"][$i] . "";
                        $error = true;
                    } else {
// Si no hubo ningun error, hacemos otra condicion para asegurarnos que el archivo no sea repetido
                        $hora = time();
                        $typemime = $_FILES["userfile"]["type"][$i];
                        $idevento = $_POST['idevento'];
                        $con++;

                        $url = "./archivos/filesevents/" . "archivo" . $hora . $_FILES['userfile']['name'][$i];
                        crear_fichero($_POST['descripcionFicheros'][$i], $idevento, $url, $typemime);
// Si no es un archivo repetido y no hubo ningun error, procedemos a subir a la carpeta /archivos, seguido de eso mostramos la imagen subida
                        move_uploaded_file($_FILES["userfile"]["tmp_name"][$i], $url);
                        header('location: miseventos.php');
                    }
                }
            }
            if ($con == 0) {
                $date = cambiar_formato_fecha_guardar($_POST['fecha']);
                $idcreado = crear_evento($_POST['name'], $_POST['descripcionFicheros'], $_SESSION['userid'], $date);
                crear_invitacion($idcreado, $_SESSION['userid']);
                header('location: miseventos.php');
            }
        }
    } else {
        header('location: subirfichero.php');
    }
}