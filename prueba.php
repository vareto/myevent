<?php
header('Content-type: application/vnd.ms-word');
header("Content-Disposition: attachment; filename=" . $_POST['nombreEvento'] . '.doc');
header("Pragma: no-cache");
header("Expires: 0");
require_once './accionesEventos.php';
$asistentes = traer_asistentes($_POST['idevento']);
$noAsistentes = traer_no_asistentes($_POST['idevento']);
?>

<h1><?php echo $_POST['nombreEvento'] ?></h1>
<br>
<br>
<h4><?php echo $_POST['descripcionEvento'] ?></h4>
<br>
<br>
<br>
<br>
<br>
<h2>Asistentes</h2>
<table style="border: #000">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($asistentes as $a) {
            echo '<tr>';
            echo '<td>' . $a['name'] . '</td>';
            echo '<td>' . $a['last_name'] . '</td>';
            echo '</tr>';
        }
        ?>

    </tbody>
</table>
<br>
<br>
<br>
<h2>No asistentes</h2>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($noAsistentes as $a) {
            echo '<tr>';
            echo '<td>' . $a['name'] . '</td>';
            echo '<td>' . $a['last_name'] . '</td>';
            echo '</tr>';
        }
        ?>

    </tbody>
</table>
