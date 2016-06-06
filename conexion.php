<?php
function cogerConexion() {
    $conn = new mysqli("mysql.hostinger.es", "u310920036_varet", "vareto3461", "u310920036_myeve");
    if (mysqli_connect_errno()) {
        printf("Error de conexión: %s\n", mysqli_connect_error());
        exit();
    }
    return $conn;
}
function cerrarConexion($conn) {
    mysqli_close($conn);
}
