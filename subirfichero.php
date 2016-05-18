<!DOCTYPE html>
<html lang="en">
    <?php include_once './cabezera.php'; ?>
    <script type="text/javascript">
        var numero = 0; //Esta es una variable de control para mantener nombres
        //diferentes de cada campo creado dinamicamente.
        evento = function (evt) { //esta funcion nos devuelve el tipo de evento disparado
            return (!evt) ? event : evt;
        }


        addCampo = function () {
            if (numero < 5) {
                //Creamos un nuevo div para que contenga el nuevo campo
                nDiv = document.createElement('div');
//con esto se establece la clase de la div
                nDiv.className = 'form-group';
//este es el id de la div, aqui la utilidad de la variable numero
//nos permite darle un id unico
                nDiv.id = 'file' + (++numero);
//creamos el input para el formulario:
                nCampo = document.createElement('input');
                nCampo1 = document.createElement('input');
                nCampo2 = document.createElement('label');
                nCampo3 = document.createElement('label');
//le damos un nombre, es importante que lo nombren como vector, pues todos los campos
//compartiran el nombre en un arreglo, asi es mas facil procesar posteriormente con php
                nCampo.name = 'userfile[]';
                nCampo1.name = 'descripcionFicheros[]';
//Establecemos el tipo de campo
                nCampo.type = 'file';
                nCampo.title = 'ARchiv';
                nCampo1.type = 'textarea';
//Ahora creamos un link para poder eliminar un campo que ya no deseemos
                a = document.createElement('a');
//El link debe tener el mismo nombre de la div padre, para efectos de localizarla y eliminarla
                a.name = nDiv.id;
//Este link no debe ir a ningun lado
                a.href = '#';
//Establecemos que dispare esta funcion en click
                a.onclick = elimCamp;
//Con esto ponemos el texto del link
                a.innerHTML = 'Eliminar';
//Bien es el momento de integrar lo que hemos creado al documento,
//primero usamos la función appendChild para adicionar el campo file nuevo
                nDiv.appendChild(nCampo);
                nDiv.appendChild(nCampo1);
//Adicionamos el Link
                nDiv.appendChild(a);
//Ahora si recuerdan, en el html hay una div cuyo id es 'adjuntos', bien
//con esta función obtenemos una referencia a ella para usar de nuevo appendChild
//y adicionar la div que hemos creado, la cual contiene el campo file con su link de eliminación:
                container = document.getElementById('adjuntos');
                container.appendChild(nDiv);
            }
        }

//con esta función eliminamos el campo cuyo link de eliminación sea presionado
        elimCamp = function (evt) {
            evt = evento(evt);
            nCampo = rObj(evt);
            div = document.getElementById(nCampo.name);
            div.parentNode.removeChild(div);
            numero--;
        }
//con esta función recuperamos una instancia del objeto que disparo el evento
        rObj = function (evt) {
            return evt.srcElement ? evt.srcElement : evt.target;
        }
    </script>

    <body>
        <?php
        session_start();
        if (isset($_SESSION['userid'])) {
            ?>
            <div id="wrapper">
                <?php
                 include_once 'menu.php';
                if (!isset($_SESSION['nombreEvento'])) {
                    $_SESSION['nombreEvento'] = $_POST['nombreEvento'];
                    $_SESSION['idevento'] = $_POST['idevento'];
                }
                ?>

                <div id = "page-wrapper">
                    <div class = "container-fluid">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <h1 class = "page-header"><?php echo 'Subir ficheros ' . "'" . $_SESSION['nombreEvento'] . "'" ?> </h1>
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
                                            <form role="form" action="accionesEventos.php" method="post" enctype="multipart/form-data" >
                                                <input type = "hidden" name = "idevento" value = "<?= $_SESSION['idevento'] ?>">
                                                <div class="form-group" id="adjuntos" name="adjuntos">
                                                    <label>Archivo</label>
                                                    <input  class="form-control" type="file" name="userfile[]" > 
                                                    <label>Descripcion fichero</label>
                                                    <input  class="form-control" type="textarea"  name="descripcionFicheros[]"> 
                                                    <a href="#" onClick="addCampo()">Subir otro archivo</a> 

                                                </div>
                                                <button type="submit" name="subirFichero" class="btn btn-default">subir</button>
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
    </body>
</html>


