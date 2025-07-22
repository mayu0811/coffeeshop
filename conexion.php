<?php
$conexion = new mysqli("localhost", "root","","Coffeeshop");

if ($conexion->connect_errno) {
    echo "Error de conexion:" .$conexion->$connect_error;
    exit();
}

$conexion->set_charset("utf8");

$sql = "INSERT INTO usuario (Id_cliente, Nombre, Email, Telefono) VALUES($cli,'$nom','$em','$tel')";


if ($conexion->query($sql) === TRUE) {
    echo "Usuario insertado:3";
}else {
    echo "error insertar:(".$conexion->error;

   
}
$conexion->close();
?>


