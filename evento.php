<!DOCTYPE html>
<html lang="en">
    <?php include_once './cabezera.php'; ?>
    <body>
        <?php
        session_start();
        if (isset($_SESSION['userid'])) {
            if (!isset($_SESSION['idevento']) || isset($_POST['idevento'])) {
                $_SESSION['idevento'] = $_POST['idevento'];
            }
            ?>
            <div id="wrapper">
                <?php
                include_once 'menu.php';
                include_once './accionesEventos.php';
                include_once './accionesFiles.php';
                $evento = traer_evento($_SESSION['idevento']);
                $asistentes = traer_asistentes($_SESSION['idevento']);
                $noAsistentes = traer_no_asistentes($_SESSION['idevento']);
                $ficheros = traer_ficheos_eventos($_SESSION['idevento']);
                $dueño = es_dueño($_SESSION['userid'], $_SESSION['idevento']);
                $pasado = es_pasado($_SESSION['idevento']);

                function vacio($variable) {
                    $return = false;
                    foreach ($variable as $a) {
                        if (isset($a)) {
                            $return = true;
                        }
                    }
                    return $return;
                }
                ?>
                <div id = "page-wrapper">
                    <div class = "container-fluid">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <h1 class = "page-header"><?= $evento['name'] ?>
                                </h1>
                            </div>
                        </div>
                        <div class = "row">
                            <div class = "col-lg-12">
                                <h2><?= $evento['description'] ?></h2>
                            </div>
                        </div>
                        <br><br><br><br><br>
                        <div class="row">
                            <div class="col-lg-4">
                                <?php if (count($asistentes) >= 1 && vacio($asistentes)) { ?>

                                    <div class="panel panel-default">   
                                        <div class="panel-heading">
                                            Asistentes
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Foto</th>
                                                            <th>Nombre</th>
                                                            <th>Apellidos</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($asistentes as $a) {
                                                            echo '<tr>';
                                                            echo '<td>' . '<img width="50" height="50" src="' . $a['picuser'] . '">' . '</td>';
                                                            echo '<td>' . $a['name'] . '</td>';
                                                            echo '<td>' . $a['last_name'] . '</td>';
                                                            ?> 
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                <?php } else { ?>
                                    <h4>No hay asistentes</h4>
                                <?php } ?>
                                <?php if ($dueño == true && $pasado != true) { ?>
                                    <form action = "prueba.php" method = "post">
                                        <input type = "hidden" name = "idevento" value = "<?= $evento['id'] ?>">
                                        <input type = "hidden" name = "nombreEvento" value = "<?= $evento['name'] ?>">
                                        <input type = "hidden" name = "descripcionEvento" value = "<?= $evento['description'] ?>">
                                        <button  type="submit" name = "generarWord" class="btn btn-primary btn-lg btn-block" data-toggle="tooltip" data-placement="bottom" title="Generar word">Generar word</button>
                                    </form>
                                    <br>
                                    <button data-toggle="modal" data-target="#eliminarEvento" name = "borrarEvento" class="btn btn-danger btn-lg btn-block" data-toggle="tooltip" data-placement="bottom" title="Borrar evento">Borrar evento</button>
                                <?php } ?>
                            </div>
                            <div class="col-lg-4">
                                <?php if (count($noAsistentes) >= 1 && vacio($noAsistentes)) { ?>
                                    <div class="panel panel-default">   
                                        <div class="panel-heading">
                                            No asistentes
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Foto</th>
                                                            <th>Nombre</th>
                                                            <th>Apellidos</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($noAsistentes as $n) {
                                                            echo '<tr>';
                                                            echo '<td>' . '<img width="50" height="50" src="' . $n['picuser'] . '">' . '</td>';
                                                            echo '<td>' . $n['name'] . '</td>';
                                                            echo '<td>' . $n['last_name'] . '</td>';
                                                            ?> 

                                                            </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <h4>Todos los contactos asistiran</h4>
                                <?php } ?>
                            </div>
                            <div class="col-lg-4">
                                <?php
                                if (mysqli_num_rows($ficheros) >= 1) { ?>

                                    <div class="panel panel-default">                             
                                        <div class="panel-heading">
                                            Ficheros del evento
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Descripcion</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($ficheros as $a) {
                                                            echo '<tr>';
                                                            echo '<td>' . $a['description'] . '</td>';
                                                            ?>
                                                        <td>
                                                            <form action = "accionesFiles.php" method = "post" target="_blank">
                                                                <input type = "hidden" name = "typeFile" value = "<?= $a['typemime'] ?>">
                                                                <input type = "hidden" name = "urlFile" value = "<?= $a['url'] ?>">
                                                                <button type = "submit" name = "descargar" class="btn btn-default  btn-circle" data-toggle="tooltip" data-placement="bottom" title="Descargar fichero"><i class = "glyphicon glyphicon-download-alt"></i></button>
                                                                <button type = "submit" name = "ver" class="btn btn-default  btn-circle" data-toggle="tooltip" data-placement="bottom" title="ver fichero"><i class = "glyphicon glyphicon-eye-open"></i></button>
                                                            </form>

                                                        </td> 
                                                        <?php
                                                        echo '</tr>';
                                                    }
                                                    ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                }
                                ?>
                                <h4>No hay Ficheros</h4>
                                
                                <?php if ($dueño == true && $pasado != true) { ?>
                                    <form action = "subirfichero.php" method = "post">
                                        <input type = "hidden" name = "idevento" value = "<?= $evento['id'] ?>">
                                        <input type = "hidden" name = "nombreEvento" value = "<?= $evento['name'] ?>">
                                        <button  type="submit" name = "subir" class="btn btn-info btn-lg btn-block" data-toggle="tooltip" data-placement="bottom" title="Subir ficheros">Subir ficheros</button>
                                    </form>
                                <?php } ?>
                            </div>

                            <div class = "modal fade" id = "eliminarCuenta" tabindex = "-1" role = "dialog" aria-labelledby = "myModalLabel" aria-hidden = "true">
                                <div class = "modal-dialog">
                                    <div class = "modal-content">
                                        <div class = "modal-header">
                                            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">&times;
                                            </button>
                                            <h4 class = "modal-title" id = "myModalLabel">Eliminacion de cuenta</h4>
                                        </div>
                                        <div class = "modal-body">
                                            ¿Estas seguro que desas eliminar la cuenta en myEvent?
                                        </div>
                                        <div class = "modal-footer">
                                            <a href="index.php"><button type = "button" class = "btn btn-primary" data-dismiss = "modal">NO</button></a>
                                            <a href="dropuser.php"><button type = "button" class = "btn btn-default">SI</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "modal fade" id = "eliminarEvento" tabindex = "-1" role = "dialog" aria-labelledby = "myModalLabel" aria-hidden = "true">
                                <div class = "modal-dialog">
                                    <div class = "modal-content">
                                        <div class = "modal-header">
                                            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">&times;
                                            </button>
                                            <h4 class = "modal-title" id = "myModalLabel">Eliminacion de evento</h4>
                                        </div>
                                        <div class = "modal-body">
                                            ¿Estas seguro que desas eliminar el evento?
                                        </div>
                                        <div class = "modal-footer">

                                            <form action = "accionesEventos.php" method = "post">
                                                <input type = "hidden" name = "idevento" value = "<?= $evento['id'] ?>">
                                                <button type = "button"  class = "btn btn-primary" data-dismiss = "modal">NO</button>
                                                <button type = "submit" name = "borrarEvento" class = "btn btn-default">SI</button>                                           
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?php
        } else {
            header("location: login.php");
        }
        ?>
        <?php include_once 'pie.php'; ?>
    </body>
</html>
