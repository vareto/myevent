<!DOCTYPE html>
<html lang="en">
    <?php include_once './cabezera.php'; ?>
    <body>
        <?php
        session_start();
        if (!isset($_SESSION['userid'])) {
            ?>
        
        
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-4 col-md-offset-4">
                        <img src="archivos/ievent/logoievent.png" width="300" height="272">
                        <h2>TFG 2015/2016 CGG Universidad Pablo de Olavide (Sevilla)</h2>
                        <?php echo '<a href="registrar.php">Registrar</a>' ?>
                        <?php echo '<a href="recuperar.php">Recuperar credenciales</a>' ?>
                        <?php echo '<a href="habilitaruser.php">Activar cuenta</a>' ?>
                        <?php ?>
                        <div class="login-panel panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Please Sign In</h3>
                            </div>
                            <div class="panel-body">
                                <form role="form" action="accionesUsuario.php" method="post" id="login"  >
                                    <?php
                                    if (isset($_SESSION['error']['usuario'])) {
                                        for ($i = 0; $i < count($_SESSION['error']['usuario']); $i++) {
                                            echo $_SESSION['error']['usuario'][$i];
                                        }
                                        echo $_SESSION['error']['usuario']=null;
                                    }
                                    ?>
                                    <fieldset>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="E-mail" id="email" name="email"  autofocus="true">
                                        </div>
                                        <div class="form-group">

                                            <input class="form-control" placeholder="Password" id="password" name="password" type="password">
                                        </div>
                                        <input type="submit" value="Entrar" name="login" class="btn btn-lg btn-success btn-block"> 
                                    </fieldset>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            require_once 'index.php';
        }
        ?>
        <?php include_once 'pie.php'; ?>

        <script type="text/javascript">
            jQuery.validator.addMethod("laxEmail", function (value, element) {
                // allow any non-whitespace characters as the host part
                return this.optional(element) || /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/.test(value);
            }, 'Debe introducir un email correcto');


            $("#login").validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    },
                    email: {
                        required: true,
                        maxlength: 50,
                        laxEmail: true
                    },
                    agree: "required"
                },
                messages: {
                    password: {
                        required: "Debe introducir la contraseña",
                        minlength: "La contraseña debe ser mayor de 8 caracteres",
                        maxlength: "La contraseña debe ser menor de 20 caracteres"
                    },
                    email: {
                        required: "Debe introducir un email",
                        maxlength: "El email debe ser menor a 50 caracteres"
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
