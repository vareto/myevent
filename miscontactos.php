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
                <?php include_once './accionesContactos.php'; ?>
                <?php $contactos = traer_mis_contactos($_SESSION['userid']) ?>
                <?php $invitaciones = traer_mis_contactos2($_SESSION['userid']) ?>
                <div id = "page-wrapper">
                    <div class = "container-fluid">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <h1 class = "page-header"><?php echo 'Mis contactos' ?> </h1>
                                <div class="col-lg-6">
                                    <div class="panel panel-default">   
                                        <div class="panel-heading">
                                            Contactos
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Foto</th>
                                                            <th>Nombre</th>
                                                            <th>Apellidos</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($contactos as $a) {
                                                            echo '<tr>';
                                                            echo '<td>' . '<img width="50" height="50" src="' . $a['picuser']. '">' . '</td>';
                                                            echo '<td>' . $a['name'] . '</td>';
                                                            echo '<td>' . $a['last_name'] . '</td>';
                                                            ?>
                                                                            <td>
                                                                            <form action = "accionesContactos.php" method = "post">
                                                                                <input type = "hidden" name = "idContacto" value = "<?= $a['id'] ?>">
                                                                                <button type = "submit" name = "eliminarContacto"  class="btn btn-default btn-circle"  data-toggle="tooltip" data-placement="bottom" title="Eliminar contacto"><i class = "fa fa-times"></i></button>
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
                                    <div class="panel panel-default">  
                                        <div class="panel-heading">
                                            Invitaciones pendientes
                                        </div>
                                        <div class="panel-body">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Foto</th>
                                                            <th>Nombre</th>
                                                            <th>Apellidos</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($invitaciones as $a) {
                                                            echo '<tr>';
                                                            echo '<td>' . '<img width="50" height="50" src="' . $a['picuser']. '">' . '</td>';
                                                            echo '<td>' . $a['name'] . '</td>';
                                                            echo '<td>' . $a['last_name'] . '</td>';
                                                            ?>
                                                        <td>
                                                            <label class="checkbox-inline">
                                                            <form action = "accionesContactos.php" method = "post">
                                                                <input type = "hidden" name = "idUsuario" value = "<?= $a['id'] ?>">
                                                                <button type = "submit" name = "aceptarInvitacion" class="btn btn-default btn-circle"  data-toggle="tooltip" data-placement="bottom" title="Aceptar invitacion"><i class = "fa fa-check"></i></button>
                                                            </form>
                                                                </label>
                                                            <label class="checkbox-inline">
                                                            <form action = "accionesContactos.php" method = "post">
                                                                <input type = "hidden" name = "idUsuario" value = "<?= $a['id'] ?>">
                                                                <button type = "submit" name = "rechazarInvitacion" class="btn btn-default btn-circle"  data-toggle="tooltip" data-placement="bottom" title="Rechazar invitacion"><i class = "fa fa-times"></i></button>
                                                            </form>
                                                            </label>
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



