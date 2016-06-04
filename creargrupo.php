<!DOCTYPE html>
<html lang="en">
    <?php include_once './cabezera.php'; ?>
    <body>
        <?php
        session_start();
        if (isset($_SESSION['userid'])) {
            ?>
            <div id="wrapper">
                <?php include_once 'menu.php'; ?>

                <div id = "page-wrapper">
                    <div class = "container-fluid">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <h1 class = "page-header"><?php echo 'Crear grupo' ?> </h1>
                                <div class="col-lg-6">
                                    <div class="panel panel-default">                             
                                        <!-- /.panel-heading -->
                                        <?php
                                        if (isset($_SESSION['error']['grupo'])) {
                                            for ($i = 0; $i < count($_SESSION['error']['grupo']); $i++) {
                                                echo $_SESSION['error']['grupo'][$i];
                                            }
                                            $_SESSION['error']['grupo']=null;
                                        }
                                        ?>
                                        <div class="panel-body">
                                            <form role="form" action="accionesGrupos.php" method="post" id="creargrupo" >
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label>Titulo</label>
                                                        <input class="form-control" name="name" id="name"> 
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <input class="form-control"  name="description" id="description"> 
                                                    </div>
                                                    <button  type="submit" name = "crear" class="btn btn-primary btn-lg btn-block" data-toggle="tooltip" data-placement="bottom" title="Crear grupo">Crear</button>

                                                    <!--<button type="submit" name="crear" class="btn btn-default">crear</button>-->
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
            header("location: login.php");
        }
        ?>
        <?php include_once 'pie.php'; ?>
        <script type="text/javascript">

            $("#creargrupo").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 20
                    },
                    description: {
                        required: true,
                        maxlength: 200
                    },
                    agree: "required",
                },
                messages: {
                    name: {
                        required: "Debe introducir un nombre",
                        maxlength: "El nombre debe ser menor de 20 caracteres"
                    },
                    description: {
                        required: "Debe introducir una descripcion",
                        maxlength: "La descripcion debe ser menor de 200 caracteres"
                    },
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    // Add the `help-block` class to the error element
                    error.addClass("help-block");
                    if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.parent("label"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
                }
            });
        </script>
    </body>
</html>


