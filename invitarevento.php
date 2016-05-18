<!DOCTYPE html>
<html lang="en">
    <?php include_once './cabezera.php'; ?>
    <body>
        <?php
        session_start();
        if (isset($_SESSION['userid'])) {
            if (!isset($_SESSION['nameevento']) || isset($_POST['nameEvento'])) {
                $_SESSION['nameevento'] = $_POST['nameEvento'];
            }
            if (!isset($_SESSION['idevento']) || isset($_POST['idevento'])) {
                $_SESSION['idevento'] = $_POST['idevento'];
            }
            ?>
            <div id="wrapper">
                <?php
                include_once 'menu.php';
                include_once './accionesContactos.php';
                include_once './accionesGrupos.php';
                $contactos = traer_mis_contactos_no_invitados($_SESSION['userid'], $_SESSION['idevento']);
                $contactos1 = traer_mis_contactos_invitados($_SESSION['userid'], $_SESSION['idevento']);
                $grupos = traer_mis_grupos($_SESSION['userid']);

                ?>
                <div id = "page-wrapper">
                    <div class = "container-fluid">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <h1 class = "page-header"><?php echo "Evento - '" . $_SESSION['nameevento'] . "'" ?>
                                </h1>
                                <div class="col-lg-6">
                                    <div class="panel panel-default">   
                                        <div class="panel-heading">
                                            Contactos no invitados
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
                                                            <th>Invitar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($contactos as $a) {
                                                            echo '<tr>';
                                                            echo '<td>' . '<img width="50" height="50" src="' . $a['picuser']. '">' . '</td>';
                                                            echo '<td>' . $a['name'] . '</td>';
                                                            echo '<td>' . $a['last_name'] . '</td>';
                                                            echo '<td>';
                                                            ?> 
                                                        <form action = "realizarinvitacion.php" method = "post">
                                                            <input type = "hidden" name = "usuarioInvitar" value = "<?= $a['id'] ?>">
                                                            <input type = "hidden" name = "eventoInvitar" value = "<?= $_SESSION['idevento'] ?>">
                                                            <button type = "submit" name = "invitar" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Invitar al evento"><i class = "fa fa-check"></i></button>

                                                        </form>
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
                                <div class="col-lg-6">
                                    <div class="panel panel-default">   
                                        <div class="panel-heading">
                                            Contactos  invitados
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Foto</th>
                                                            <th>Nombre</th>
                                                            <th>Apellidos</th>
                                                            <th>Retirar invitacion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($contactos1 as $n) {
                                                            echo '<tr>';
                                                            echo '<td>' . '<img width="50" height="50" src="' . $n['picuser']. '">' . '</td>';
                                                            echo '<td>' . $n['name'] . '</td>';
                                                            echo '<td>' . $n['last_name'] . '</td>';
                                                            echo '<td>';
                                                            ?> 
                                                        <form action = "realizarinvitacion.php" method = "post">
                                                            <input type = "hidden" name = "usuarioInvitar" value = "<?= $n['id'] ?>">
                                                            <input type = "hidden" name = "eventoInvitar" value = "<?= $_SESSION['idevento'] ?>">
                                                            <button type = "submit" name = "desinvitar" class="btn btn-default  btn-circle" data-toggle="tooltip" data-placement="bottom" title="Quitar invitacion del evento"><i class = "fa fa-times"></i></button>

                                                        </form>
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

                            </div>

                        </div>
                        <div class = "row">
                            <div class = "col-lg-12">

                                <div class="col-lg-6">
                                    <div class="panel panel-default">   
                                        <div class="panel-heading">
                                            Grupos
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">

                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Descripcion</th>
                                                            <th>Invitar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($grupos as $a) {
                                                            echo '<tr>';
                                                            echo '<td>' . $a['name'] . '</td>';
                                                            echo '<td>' . $a['description'] . '</td>';
                                                            echo '<td>';
                                                            ?> 
                                                        <form action = "realizarinvitacion.php" method = "post">
                                                            <input type = "hidden" name = "grupoInvitar" value = "<?= $a['id'] ?>">
                                                            <input type = "hidden" name = "eventoInvitar" value = "<?= $_SESSION['idevento'] ?>">
                                                            <button type = "submit" name = "invitarGrupo" class="btn btn-default  btn-circle" data-toggle="tooltip" data-placement="bottom" title="Invitar al grupo al evento"><i class = "fa fa-check"></i></button>


                                                        </form>
                                                        <form action = "realizarinvitacion.php" method = "post">
                                                            <input type = "hidden" name = "grupoInvitar" value = "<?= $a['id'] ?>">
                                                            <input type = "hidden" name = "eventoInvitar" value = "<?= $_SESSION['idevento'] ?>">
                                                            <button type = "submit" name = "desinvitarGrupo" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Quitar invitacion del evento al grupo"><i class = "fa fa-times"></i></button>

                                                        </form>
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
