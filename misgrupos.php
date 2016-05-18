<!DOCTYPE html>
<html lang="en">
<?php include_once './cabezera.php'; ?>
    <body>
        <?php
        session_start();
        if (isset($_SESSION['userid'])) {
            ?>
            <div id="wrapper">
                <?php
                include_once './menu.php';
                require_once './accionesGrupos.php';
                $grupos = traer_mis_grupos($_SESSION['userid']);
                $grupos1 = traer_mis_grupos1($_SESSION['userid']);
                ?>


                <div id = "page-wrapper">
                    <div class = "container-fluid">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <h1 class = "page-header"><?php echo 'Mis grupos' ?> </h1>
                                <div class="col-lg-6">
                                    <div class="panel panel-default">                             
                                        <div class="panel-heading">
                                            Grupos creados por mi
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Descripcion</th>
                                                            <th>acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($grupos as $a) {
                                                            echo '<tr>';
                                                            echo '<td>' . $a['name'] . '</td>';
                                                            echo '<td>' . $a['description'] . '</td>';
                                                            ?>
                                                        <td>
                                                             <div class="form-group">
                                                                 <label class="checkbox-inline">
                                                            <form action = "addcontactos.php" method = "post">
                                                                <input type = "hidden" name = "idGrupo" value = "<?= $a['id'] ?>">
                                                                <input type = "hidden" name = "nameGrupo" value = "<?= $a['name'] ?>">
                                                                <button type = "submit" class="btn btn-default btn-circle" name = "addGrupo" data-toggle="tooltip" data-placement="bottom" title="Añadir contactos"><i class = "fa fa-users"></i></button>
                                                            </form>
                                                                 </label>
                                                                  <label class="checkbox-inline">
                                                            <form action = "accionesGrupos.php" method = "post">
                                                                <input type = "hidden" name = "idGrupo" value = "<?= $a['id'] ?>">
                                                                <button type = "submit" class="btn btn-default btn-circle" name = "eliminarGrupo" data-toggle="tooltip" data-placement="bottom" title="Eliminar grupo"> <i class = "fa fa-times"></i></button>
                                                            </form>
                                                                 </label>
                                                             </div>
                                                        </td> <?php
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
                                                Grupos a los que pertenezco  
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Descripcion</th>
                                                            <th>salir</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                       
                                                            
                                                        
                                                        foreach ($grupos1 as $a) {
                                                            echo '<tr>';
                                                            echo '<td>' . $a['name'] . '</td>';
                                                            echo '<td>' . $a['description'] . '</td>';
                                                            ?>
                                                        <td>
                                                            <form action = "accionesGrupos.php" method = "post">
                                                                <input type = "hidden" name = "idGrupo" value = "<?= $a['id'] ?>">
                                                                <input type = "hidden" name = "nameGrupo" value = "<?= $a['name'] ?>">
                                                                <button type = "submit" class="btn btn-default  btn-circle"  name = "salirGrupo"><i class = "fa fa-times"></i></button>
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

        </div>
        <?php
    } else {
        header("location: login.php");
    }
    ?>
    <?php include_once 'pie.php'; ?>
</body>
</html>



