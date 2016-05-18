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
                                <h1 class = "page-header"><?php echo 'Añadir contacto' ?> </h1>
                                <div class="col-lg-6">
                                    <div class="panel panel-default">                             
                                        <!-- /.panel-heading -->
                                        <?php
                                        if (isset($_SESSION['error']['contacto'])) {
                                            for ($i = 0; $i < count($_SESSION['error']['contacto']); $i++) {
                                                echo $_SESSION['error']['contacto'][$i];
                                            }
                                            $_SESSION['error']['contacto'] = null;
                                        }
                                        ?>
                                        <div class="panel-body">
                                            <form role="form" action="accionesContactos.php" method="post" id="addcontacto">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input class="form-control" name="email" id="email"> 
                                                    </div>
                                                    <button  type="submit" name = "add" class="btn btn-primary btn-lg btn-block" data-toggle="tooltip" data-placement="bottom" title="Añadir contacto">Añadir</button>
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
            header("location: login.php");
        }
        ?>
        <?php include_once 'pie.php'; ?>

        <script type="text/javascript">
            jQuery.validator.addMethod("laxEmail", function (value, element) {
                // allow any non-whitespace characters as the host part
                return this.optional(element) || /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/.test(value);
            }, 'Debe introducir un email correcto');

            $("#addcontacto").validate({
                rules: {
                    email: {
                        required: true,
                        maxlength: 50,
                        laxEmail: true
                    },
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


