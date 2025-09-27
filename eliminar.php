<?php

require_once 'MODELO/MySQL.php';

$mysql = new MySQL();
$mysql->conectar();
    $id=$_GET['id'];

    $mysql->efectuarConsulta("DELETE FROM empleados WHERE id=$id");
    $mysql->desconectar();
header('Location:index.php');
exit();
?>