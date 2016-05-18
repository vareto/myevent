<!DOCTYPE html>
<html lang="en">
    <?php
    include_once './cabezera.php';
    session_start();
    ?>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Recuperar credenciales</h3>
                        </div>
                        <div class="panel-body">
                            <?php
                                if (isset($_SESSION['error']['usuario'])) {
                                    for ($i = 0; $i < count($_SESSION['error']['usuario']); $i++) {
                                        echo $_SESSION['error']['usuario'][$i];
                                    }
                                    $_SESSION['error']['usuario']=null;
                                }
                                ?>
                            <form role="form" action="accionesUsuario.php" method="post" id="recuperar">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="E-mail" name="email" id="email" autofocus="true">
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="submit" value="Entrar" name="recuperarcredenciales" class="btn btn-lg btn-success btn-block"></input >
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

            $("#recuperar").validate({
                rules: {
                    email: {
                        required: true,
                        laxEmail: true,
                        maxlength: 50,
                    },
                    agree: "required",
                },
                messages: {
                    email: {
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
