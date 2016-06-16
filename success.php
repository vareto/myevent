<html>
    <head>
        <title>myEvent</title>
        <META HTTP-EQUIV="REFRESH" CONTENT="10;URL=http://myevent.esy.es">
        <?php include_once './cabezera.php'; ?>
        <script type="text/javascript">
            var num = 10;
            function contador() {
                num--;
                if (num == 0)
                    location = 'http://myevent.esy.es';
                document.getElementById('seg').innerHTML = num;
            }
        </script>
    </head>
    <body onload="setInterval('contador()', 1000)">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <h1>Operacion realizada con exito</h1>
                    <h4>En unos segundos seras redirigido a la pagina principal</h4>
                    <p>Redirección en <span id="seg">10</span> segundos.</p>
                    <a href="http://myevent.esy.es">Si no te redirige automaticamente pulse en el enlace</a>
                </div>
            </div>
        </div>
    </body>
</html> 
