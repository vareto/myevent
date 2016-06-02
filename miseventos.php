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
                <?php $eventos = traer_mis_eventos($_SESSION['userid']); ?>
                <?php $eventos_ocurridos = traer_mis_eventos_ocurridos($_SESSION['userid']); ?>
                <div id = "page-wrapper">
                    <div class = "container-fluid">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <h1 class = "page-header"><?php echo 'Mis eventos' ?> </h1>
                                <div class="col-lg-6">
                                    <div class="panel panel-default">                             
                                        <div class="panel-heading">
                                            Mis eventos
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Fecha</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($eventos as $a) {
                                                            echo '<tr>';
                                                            echo '<td>' . $a['name'] . '</td>';
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
                                                                <label class="checkbox-inline">
                                                                    <form action = "editarevento.php" method = "post">
                                                                         <input type = "hidden" name = "idevento" value = "<?= $a['id'] ?>">
                                                                        <input type = "hidden" name = "nameEvento" value = "<?= $a['name'] ?>">
                                                                        <button type = "submit" name = "editar" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Editar evento"><i class = "fa fa-edit"></i></button>
                                                                    </form>
                                                                </label>
                                                                <label class="checkbox-inline">
                                                                    <form action = "invitarevento.php" method = "post">
                                                                        <input type = "hidden" name = "idevento" value = "<?= $a['id'] ?>">
                                                                        <input type = "hidden" name = "nameEvento" value = "<?= $a['name'] ?>">
                                                                        <button type = "submit" name = "invitar" class="btn btn-default  btn-circle" data-toggle="tooltip" data-placement="bottom" title="Invitar al evento"><i class = "fa fa-users"></i></button>
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
                                <div class="col-lg-6">
                                    <div class="panel panel-default">                             
                                        <div class="panel-heading">
                                            Mis eventos pasados
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Fecha</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($eventos_ocurridos as $a) {
                                                            echo '<tr>';
                                                            echo '<td>' . $a['name'] . '</td>';
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


