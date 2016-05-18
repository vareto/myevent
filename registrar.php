<!DOCTYPE html>
<html lang="en">
    <?php include_once './cabezera.php'; ?>
    <body>
        <?php session_start(); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Registro</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="accionesUsuario.php" method="post" id="registro" >
                                <?php
                                if (isset($_SESSION['error']['usuario'])) {
                                    for ($i = 0; $i < count($_SESSION['error']['usuario']); $i++) {
                                        echo $_SESSION['error']['usuario'][$i];
                                    }
                                    $_SESSION['error']['usuario'] = null;
                                }
                                ?>
                                <fieldset>
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input class="form-control" name="name" id="name"> 
                                    </div>
                                    <div class="form-group">
                                        <label>Apellidos</label>
                                        <input class="form-control" name="last_name" id="last_name"> 
                                    </div>
                                    <div class="form-group">
                                        <label>Correo</label>
                                        <input class="form-control" name="email"  id="email">
                                    </div>
                                    <div class="form-group" >
                                        <label>Password</label>
                                        <input  type="password" class="form-control" name="password" id="password"> 
                                    </div>
                                    <button type="submit" name="registrar" class="btn btn-default">Registrar</button>
                                </fieldset>
                            </form>                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'pie.php'; ?>
        <script type="text/javascript">
            jQuery.validator.addMethod("laxEmail", function (value, element) {
                // allow any non-whitespace characters as the host part
                return this.optional(element) || /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/.test(value);
            }, 'Debe introducir un email correcto');
            
            $("#registro").validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    },
                    email: {
                        required: true,
                        laxEmail: true,
                        maxlength: 50,
                    },
                    agree: "required",
                    last_name: {
                        required: true,
                        maxlength: 50
                    },
                    name: {
                        required: true,
                        maxlength: 20
                    },
                },
                messages: {
                    password: {
                        required: "Debe introducir la contraseña",
                        minlength: "La contraseña debe ser mayor de 8 caracteres",
                        maxlength: "La contraseña debe ser menor de 20 caracteres"
                    },
                    name: {
                        required: "Debe introducir un nombre",
                        maxlength: "El nombre debe ser menor de 20 caracteres"
                    },
                    last_name: {
                        required: "Debe introducir los apellidos",
                        maxlength: "La contraseña debe ser menor de 50 caracteres"
                    },
                    email: {
                        email: "Debe introducir un email correcto",
                        required: "Debe introducir un email",
                        maxlength: "El email debe ser menor de 50 caracteres"
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