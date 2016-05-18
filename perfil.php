<!DOCTYPE html>
<html lang="en">
    <?php include_once './cabezera.php'; ?>
    <body>
        <?php
        session_start();
        if (isset($_SESSION['userid'])) {
            include_once './accionesUsuario.php';
            $usuario = traer_usuario_editar($_SESSION['userid']);
            ?>
            <div id="wrapper">
                <?php include_once 'menu.php'; ?>

                <div id = "page-wrapper">
                    <div class = "container-fluid">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <h1 class = "page-header"><?php echo 'Perfil usuario' ?> </h1>
                                <div class="col-lg-6">
                                    <div class="panel panel-default">                             
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <?php
                                            if (isset($_SESSION['error']['perfil'])) {
                                                for ($i = 0; $i < count($_SESSION['error']['perfil']); $i++) {
                                                    echo $_SESSION['error']['perfil'][$i];
                                                }
                                                $_SESSION['error']['perfil']=null;
                                            }
                                            ?>
                                            <form role="form" id="perfil" action="accionesUsuario.php" method="post" enctype="multipart/form-data" >
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label>Nombre</label>
                                                        <input class="form-control" name="name" id="name" value="<?= $usuario['name'] ?>"> 
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Apellidos</label>
                                                        <input class="form-control" name="last_name" id="last_name" value="<?= $usuario['last_name'] ?>"> 
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input  class="form-control" name="email" id="email" value="<?= $usuario['email'] ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Foto perfil</label>
                                                        <input  class="form-control" multiple="true" type="file" name="pic"> 
                                                    </div>
<!--                                                    <button type = "submit" name = "guardar" class="btn btn-default  btn-circle" data-toggle="tooltip" data-placement="bottom" title="Guardar evento"><i class = "fa fa-save"></i></button>-->
                                                    <button  type="submit" name = "guardar" class="btn btn-primary btn-lg btn-block" data-toggle="tooltip" data-placement="bottom" title="Guardar perfil">Guardar</button>

                                                </fieldset>

                                            </form> 
                                            <a href="cambiarpass.php"  name="pic"><label>Cambiar contraseña</label></a> 
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

            $("#perfil").validate({
                rules: {
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
