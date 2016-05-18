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
                                                        <button type="submit" name="guardar" class="btn btn-default">guardar</button>
                                                    </fieldset>
                                                </form>    
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