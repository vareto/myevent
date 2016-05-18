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
                <?php $eventos = traer_proximos_eventos($_SESSION['userid']) ?>
                <div id = "page-wrapper">
                    <div class = "container-fluid">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <h1 class = "page-header"><?php echo 'Proximos eventos' ?> </h1>
                                <div class="col-lg-6">
                                    <div class="panel panel-default">                             
                                        <div class="panel-heading">
                                            Proximos eventos
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Descripcion</th>
                                                            <th>Fecha</th>
                                                            <th>Asistencia</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($eventos as $a) {
                                                            echo '<tr>';
                                                            echo '<td>' . $a['name'] . '</td>';
                                                            echo '<td>' . $a['description'] . '</td>';
                                                            echo '<td>' . $a['fecha'] . '</td>';
                                                            echo '<td>';
                                                            if (strcmp($a['asistencia'], "SI") == 0) {
                                                                echo '<i class="fa fa-check"></i>';
                                                            } else if (strcmp($a['asistencia'], "NO") == 0) {
                                                                echo ' <i class="fa fa-times"></i>';
                                                            } else {
                                                                echo '¿confirmar asistencia?';
                                                                ?>
                                                            <form action = "accionesEventos.php" method = "post">
                                                                <input type = "hidden" name = "idevento" value = "<?= $a['event_id'] ?>">
                                                               
                                                                <button type = "submit" name = "asiste" class="btn btn-info btn-circle" data-toggle="tooltip" data-placement="bottom" title="Aceptar invitacion del evento"><i class = "fa fa-check"></i></button>
                                                                <button type = "submit" name = "noAsiste" class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="bottom" title="Rechazar invitacion del evento"><i class = "fa fa-times"></i></button>

                                                            </form>
                                                            <?php
                                                        }
                                                        ?>
                                                        <td>    
                                                            <form action = "editarasistencia.php" method = "post">
                                                                <input type = "hidden" name = "idevento" value = "<?= $a['event_id'] ?>">
                                                                <button type = "submit" name = "editar" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Editar asistencia del evento"><i class = "fa fa-edit"></i></button>
                                                            </form>
                                                        </td>
                                                        <?php
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
            header("location: login.php");
        }
        ?>
        <?php include_once 'pie.php'; ?>
    </body>
</html>


