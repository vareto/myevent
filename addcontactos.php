<!DOCTYPE html>
<html lang="en">
<?php include_once './cabezera.php'; ?>
    <body>
        <?php
        session_start();

        if (isset($_SESSION['userid'])) {

            if (!isset($_SESSION['nameGrupo']) || isset($_POST['nameGrupo'])) {
                $_SESSION['nameGrupo'] = $_POST['nameGrupo'];
            }
            if (!isset($_SESSION['idGrupo']) || isset($_POST['idGrupo'])) {
                $_SESSION['idGrupo'] = $_POST['idGrupo'];
            }
            ?>
            <div id="wrapper">
                <?php include_once 'menu.php'; ?>
                <?php require_once './accionesContactos.php'; ?>
                <?php
                $contactos = traer_mis_contactos_add($_SESSION['userid'], $_SESSION['idGrupo']);
                $contactos1 = traer_mis_contactos_retirar($_SESSION['userid'], $_SESSION['idGrupo']);
                ?>
                <div id = "page-wrapper">
                    <div class = "container-fluid">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <h1 class = "page-header"><?php echo "Grupo - '" .$_SESSION['nameGrupo']."'" ?>
                                </h1>
                                <div class="col-lg-6">
                                    <div class="panel panel-default">                             
                                        <div class="panel-heading">
                                            Contactos que no pertenecen al grupo
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">

                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Foto</th>
                                                            <th>Nombre</th>
                                                            <th>Apellidos</th>
                                                            <th>Añadir al grupo</th>
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
                                                        <form action = "accionesGrupos.php" method = "post">
                                                            <input type = "hidden" name = "usuarioAdd" value = "<?= $a['id'] ?>">
                                                            <input type = "hidden" name = "grupoAdd" value = "<?= $_SESSION['idGrupo'] ?>">
                                                            <button type = "submit" class="btn btn-default btn-circle"  name = "addInGroup" data-toggle="tooltip" data-placement="bottom" title="Añadir contacto"><i class = "fa fa-check"></i></button>
                                                        </form>
                                                        <?php
                                                        echo '</td>';
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
                                            Contactos que pertenecen al grupo
                                        </div>
                                        <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Foto</th>
                                                        <th>Nombre</th>
                                                        <th>Apellidos</th>
                                                        <th>Sacar grupo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    
                                                        
                                                    
                                                    foreach ($contactos1 as $a) {
                                                        echo '<tr>';
                                                         echo '<td>' . '<img width="50" height="50" src="' . $a['picuser']. '">' . '</td>';
                                                        echo '<td>' . $a['name'] . '</td>';
                                                        echo '<td>' . $a['last_name'] . '</td>';
                                                        echo '<td>';
                                                        ?> 
                                                    <form action = "accionesGrupos.php" method = "post">
                                                        <input type = "hidden" name = "usuarioAdd" value = "<?= $a['id'] ?>">
                                                        <input type = "hidden" name = "grupoAdd" value = "<?= $_SESSION['idGrupo'] ?>">
                                                        <button type = "submit"  class="btn btn-default btn-circle"  name = "deleteForGroup" data-toggle="tooltip" data-placement="bottom" title="Eliminar contacto"><i class = "fa fa-times"></i></button>
                                                    </form>
                                                    <?php
                                                    echo '</td>';
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
