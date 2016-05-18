<?php
session_start();
include_once 'conexion.php';
$conn = cogerConexion();
$sql1 = "UPDATE users set habilitado = 'n' where id = ". $_SESSION['userid'];
if ($conn->query($sql1) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
$conn->close();
header('location: logout.php');
