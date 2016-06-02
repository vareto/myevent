<!DOCTYPE html>
<html lang="en">
    <?php include_once './cabezera.php'; ?>
   
    <body>
        <?php
        session_start();
        if (isset($_SESSION['userid'])) {
            if (isset($_POST['editar'])) {
                require_once './accionesEventos.php';
                require_once './accionesContactos.php';
                require_once './accionesGrupos.php';
                if (!isset($_SESSION['nameevento']) || isset($_POST['nameEvento'])) {
                    $_SESSION['nameevento'] = $_POST['nameEvento'];
                }
                if (!isset($_SESSION['idevento']) || isset($_POST['idevento'])) {
                    $_SESSION['idevento'] = $_POST['idevento'];
                }
                $evento = traer_evento_editar($_POST['idevento']);
                $contactos = traer_mis_contactos_no_invitados($_SESSION['userid'], $_SESSION['idevento']);
                $contactos1 = traer_mis_contactos_invitados($_SESSION['userid'], $_SESSION['idevento']);
                $grupos = traer_mis_grupos($_SESSION['userid']);
                ?>
                <div id="wrapper">
                    <?php include_once 'menu.php'; ?>

                    <div id = "page-wrapper">
                        <div class = "container-fluid">
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <h1 class = "page-header"><?php echo 'Editar evento' ?> </h1>
                                    <div class="col-lg-6">
                                        <div class="panel panel-default">                             
                                            <!-- /.panel-heading -->
                                            <div class="panel-body">
                                                <?php
                                                if (isset($_SESSION['error']['evento'])) {
                                                    for ($i = 0; $i < count($_SESSION['error']['evento']); $i++) {
                                                        echo $_SESSION['error']['evento'][$i];
                                                    }
                                                    $_SESSION['error']['evento']=null;
                                                }
                                                ?>
                                                <form role="form" action="#" method="post" id="editarevento" >
                                                    <fieldset>
                                                        <div class="form-group">
                                                            <label>Titulo</label>
                                                            <input class="form-control" name="name" id="name" value="<?= $evento['name'] ?>"> 
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <input class="form-control" type="textarea" id="description" name="description" value="<?= $evento['description'] ?>"> 
                                                        </div>
                                                        <div class="form-group">
                                                            <label>fecha</label>
                                                            <input  class="form-control" name="fecha" id="fecha" value="<?= cambiar_formato_fecha_mostrar($evento['fecha']) ?>"> 
                                                        </div>
<!--                                                        <button type = "submit" name = "guardar" class="btn btn-default  btn-circle" data-toggle="tooltip" data-placement="bottom" title="Guardar evento"><i class = "fa fa-save"></i></button>-->
                                                        <button  type="submit" name = "guardar" class="btn btn-primary btn-lg btn-block" data-toggle="tooltip" data-placement="bottom" title="Guardar evento">Guardar evento</button>

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
                $errors = 0;
                if (isset($_POST["guardar"])) {
                    include_once './accionesEventos.php';
                    $_SESSION['error']['evento'] = null;
                    $_SESSION['error']['evento'] = array();
                    $errors = 0;
                    $errors += validar_fecha($_POST['fecha']);
                    $errors += validar_nombre($_POST['name']);
                    $errors += validar_descripcion_evento($_POST['description']);

                    if ($errors == 0) {
                        $date = cambiar_formato_fecha_guardar($_POST['fecha']);
                        editar_evento($_POST['name'], $_POST['description'], $date, $_SESSION['idevento']);
                    }
                } else {
                    if ($errors != 0) {
                        header("location: editarevento.php");
                    }
//                    header("location: miseventos.php");
                }
            }
        } else {
            header("location: login.php");
        }
        ?>
        <?php include_once 'pie.php'; ?>
        <script type="text/javascript">
            jQuery.validator.addMethod("fecha", function (value, element) {
                return this.optional(element) || /^([0-9]{2})-([0-9]{2})-([0-9]{4})$/.test(value);
            }, 'Debe introducir una fecha en formato dd-mm-yyyy');


            $("#editarevento").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 30
                    },
                    description: {
                        required: true,
                    },
                    agree: "required",
                    fecha: {
                        required: true,
                        fecha: true
                    },
                },
                messages: {
                    name: {
                        required: "Debe introducir un nombre",
                        maxlength: "El nombre debe ser menor de 30 caracteres"
                    },
                    description: {
                        required: "Debe introducir una descripcion",
                    },
                    fecha: {
                        required: "Debe introducir una fecha",
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
