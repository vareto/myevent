<!DOCTYPE html>
<html lang="en">
    <?php include_once './cabezera.php'; ?>
    <body>
        <?php
        session_start();
        if (isset($_SESSION['userid'])) {
            ?>
            <div id="wrapper">
                <?php include_once './menu.php'; ?>
                <?php include_once './accionesEventos.php'; ?>
                <?php include_once './accionesFiles.php'; ?>
                <?php
                if (!isset($_SESSION['nameevento']) || isset($_POST['nameEvento'])) {
                    $_SESSION['nameevento'] = $_POST['nameEvento'];
                }
                if (!isset($_SESSION['idevento']) || isset($_POST['idevento'])) {
                    $_SESSION['idevento'] = $_POST['idevento'];
                }
                $ficheros = traer_ficheos_eventos($_SESSION['idevento']);

                if (mysqli_num_rows($ficheros) >= 1) {
                    ?>

                    <div id = "page-wrapper">
                        <div class = "container-fluid">
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <h1 class = "page-header"><?php echo "Ficheros evento '" . $_SESSION['nameevento'] . "'" ?> </h1>
                                    <div class="col-lg-6">
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
                                                                <form action = "accionesFiles.php" method = "post">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <?php
            } else {
                ?>
                <div id="wrapper">
                    <div id = "page-wrapper">
                        <div class = "container-fluid">
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <h1 class = "page-header"><?php echo "Ficheros evento '" . $_SESSION['nameevento'] . "'" ?> </h1>
                                </div>
                                <h3>Este evento no tiene ficheros asociados</h3>
                            </div> 
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            header("location: login.php");
        }
        ?>
        <?php include_once 'pie.php'; ?>
    </body>
</html>


