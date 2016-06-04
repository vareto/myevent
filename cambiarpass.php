<!DOCTYPE html>
<html lang="en">
    <?php include_once './cabezera.php'; ?>
    <body>
        <?php
        session_start();
        if (isset($_SESSION['userid'])) {
            include_once './accionesContactos.php';
            ?>
            <div id="wrapper">
                <?php include_once 'menu.php'; ?>

                <div id = "page-wrapper">
                    <div class = "container-fluid">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <h1 class = "page-header"><?php echo 'Cambiar contraseña' ?> </h1>
                                <div class="col-lg-6">
                                    <div class="panel panel-default">                             
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <?php
                                            if (isset($_SESSION['error']['usuario'])) {
                                                for ($i = 0; $i < count($_SESSION['error']['usuario']); $i++) {
                                                    echo $_SESSION['error']['usuario'][$i];
                                                }
                                                $_SESSION['error']['usuario'] = null;
                                            }
                                            ?>
                                            <form role="form" id="cambiarpass" action="accionesUsuario.php" method="post">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label>Antigua contraseña</label>
                                                        <input id="passAntigua" type="password" class="form-control" name="passAntigua">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nueva contraseña</label>
                                                        <input  id="passNueva" type="password"  class="form-control" name="passNueva">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Repite nueva contraseña</label>
                                                        <input id="passNueva2" type="password"  class="form-control" name="passNueva2">
                                                    </div>
                                                    <button type = "submit" name = "cambiarPass" class="btn btn-primary btn-lg btn-block" data-toggle="tooltip" data-placement="bottom" title="Guardar evento">Guardar</button>
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
            $("#cambiarpass").validate({
                rules: {
                    passAntigua: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    },
                    passNueva: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    },
                    passNueva2: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    }
                },
                messages: {
                    passAntigua: {
                        required: "Debe introducir la contraseña",
                        minlength: "La contraseña debe ser mayor de 8 caracteres",
                        maxlength: "La contraseña debe ser menor de 20 caracteres"
                    },
                    passNueva: {
                        required: "Debe introducir la contraseña",
                        minlength: "La contraseña debe ser mayor de 8 caracteres",
                        maxlength: "La contraseña debe ser menor de 20 caracteres"
                    },
                    passNueva2: {
                        required: "Debe introducir la contraseña",
                        minlength: "La contraseña debe ser mayor de 8 caracteres",
                        maxlength: "La contraseña debe ser menor de 20 caracteres"
                    }
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
