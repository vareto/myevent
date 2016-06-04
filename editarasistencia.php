<!DOCTYPE html>
<html lang="en">
    <?php include_once './cabezera.php'; ?>
    <body>
        <?php
        session_start();
        if (isset($_SESSION['userid'])) {
            if (isset($_POST['editar'])) {
                include_once './accionesEventos.php';
                $_SESSION['idevento'] = $_POST['idevento'];
                $evento = traer_evento_editar_asistencia($_POST['idevento'], $_SESSION['userid']);
                ?>
                <div id="wrapper">
                    <?php include_once 'menu.php'; ?>

                    <div id = "page-wrapper">
                        <div class = "container-fluid">
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <h1 class = "page-header"><?php echo 'Editar asistencia' ?> </h1>
                                    <div class="col-lg-6">
                                        <div class="panel panel-default">                             
                                            <!-- /.panel-heading -->
                                            <div class="panel-body">
                                                <form role="form" action="#" method="post" >
                                                    <fieldset>
                                                        <div class="form-group">
                                                            <label>Asistencia</label>
                                                            <p>SI  <input  class=""  type="radio" name="asistencia" value="SI"> </p>
                                                            <p>NO  <input  class=""  type="radio" name="asistencia" value="NO"> </p>
                                                        </div>
                                                        <button  type="submit" name = "guardar" class="btn btn-primary btn-lg btn-block" data-toggle="tooltip" data-placement="bottom" title="Guardar asistencia">Guardar</button>
                                                    </fieldset>
                                                </form>    
                                            </div>
                                        </div>
                                    </div>
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
                            </div>
                        </div>
                    </div>

                </div>
                <?php
            } else {
                if (isset($_POST["guardar"])) {
                    include_once './accionesEventos.php';
                    editar_evento_asistencia($_POST['asistencia'], $_SESSION['idevento'], $_SESSION['userid']);
                    header('location: proximoseventos.php');
                } else {
                    header("location: index.php");
                }
            }
        } else {
            header("location: login.php");
        }
        ?>
        <?php include_once 'pie.php'; ?>
    </body>
</html>