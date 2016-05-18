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
                                <div class="panel panel-default">   
                                    <div class="panel-heading">
                                        Asistentes
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
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
                                <?php if($dueño == true) {?>
                                <form action = "prueba.php" method = "post">
                                    <input type = "hidden" name = "idevento" value = "<?= $evento['id'] ?>">
                                    <input type = "hidden" name = "nombreEvento" value = "<?= $evento['name'] ?>">
                                    <input type = "hidden" name = "descripcionEvento" value = "<?= $evento['description'] ?>">
                                    <button  type="submit" name = "generarWord" class="btn btn-primary btn-lg btn-block" data-toggle="tooltip" data-placement="bottom" title="Generar word">Generar word</button>
                                </form>
                                <br>
                                <form action = "accionesEventos.php" method = "post">
                                    <input type = "hidden" name = "idevento" value = "<?= $evento['id'] ?>">
                                    <button  type="submit" name = "borrarEvento" class="btn btn-danger btn-lg btn-block" data-toggle="tooltip" data-placement="bottom" title="Borrar evento">Borrar evento</button>
                                </form>
                                <?php } ?>
                            </div>
                            <div class="col-lg-4">
                                <div class="panel panel-default">   
                                    <div class="panel-heading">
                                        No asistentes
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
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

                            </div>
                            <div class="col-lg-4">
                                <?php
                                if (mysqli_num_rows($ficheros) >= 1) {
                                    ?>

                                    <div class="panel panel-default">                             
                                        <div class="panel-heading">
                                            Ficheros del evento
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
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
                                 <?php if($dueño == true) {?>
                                <form action = "subirfichero.php" method = "post">
                                    <input type = "hidden" name = "idevento" value = "<?= $evento['id'] ?>">
                                    <input type = "hidden" name = "nombreEvento" value = "<?= $evento['name'] ?>">
                                    <button  type="submit" name = "subir" class="btn btn-info btn-lg btn-block" data-toggle="tooltip" data-placement="bottom" title="Subir ficheros">Subir ficheros</button>
                                </form>
                                 <?php } ?>
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
