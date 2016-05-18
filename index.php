<!DOCTYPE html>
<?php
define("_access", TRUE);
?>
<html lang="en">
    <?php include_once './cabezera.php'; ?>
    <body>
        <?php
        session_start();
        if (isset($_SESSION['userid'])) {
            ?>
            <div id="wrapper">
                <?php include_once 'menu.php'; ?>
                <?php include_once './accionesEventos.php'; ?>
                <?php require_once './accionesContactos.php'; ?>
                <?php
                $eventos = traer_mis_eventos_index($_SESSION['userid']);
                $proximoseventos = traer_proximos_eventos_index($_SESSION['userid']);
                $eventossinconfirmar = num_proximos_eventos_sin_confirmar($_SESSION['userid']);

                $peticionesdeamistad = num_invitaciones_pendientes($_SESSION['userid']);
                ?>
                <div id = "page-wrapper">
                    <div class = "container-fluid">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <h1 class = "page-header"><?php echo "Bienvenido " . $_SESSION['username']; ?>
                                </h1>

                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-users fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?= $peticionesdeamistad ?></div>
                                                <div>Peticiones de amistad</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="miscontactos.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">Ver</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-envelope fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?= $eventossinconfirmar ?></div>
                                                <div>Eventos sin confirmar</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="proximoseventos.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">Ver</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="panel panel-default">                             
                                    <div class="panel-heading">
                                        Proximos eventos creados
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Descripcion</th>
                                                        <th>Fecha</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($eventos as $a) {



                                                        echo '<tr>';
                                                        echo '<td>' . $a['name'] . '</td>';
                                                        echo '<td>' . $a['description'] . '</td>';
                                                        echo '<td>' . cambiar_formato_fecha_mostrar($a['fecha']) . '</td>';
                                                        ?>
                                                    <td>
                                                        <div class="form-group">
                                                            <label class="checkbox-inline">
                                                                <form action = "evento.php" method = "post">
                                                                    <input type = "hidden" name = "idevento" value = "<?= $a['id'] ?>">
                                                                    <button type = "submit" name = "verEvento" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Ver evento"><i class = "fa fa-eye"></i></button>
                                                                </form>
                                                            </label>
                                                        </div>
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
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="panel panel-default">                             
                                    <div class="panel-heading">
                                        Proximos eventos invitado
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
                                                    foreach ($proximoseventos as $a) {
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
                                                            
                                                        }
                                                        ?>
                                                    <td>    
                                                        <form action = "evento.php" method = "post">
                                                            <input type = "hidden" name = "idevento" value = "<?= $a['event_id'] ?>">
                                                            <button type = "submit" name = "verEvento" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Ver evento"><i class = "fa fa-eye"></i></button>
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
            <?php
        } else {
            header("location: login.php");
        }
        ?>
        <?php include_once 'pie.php'; ?>
    </body>
</html>
