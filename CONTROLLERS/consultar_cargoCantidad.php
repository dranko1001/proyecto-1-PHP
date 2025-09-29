<?php

require_once '../MODELO/MySQL.php'; 
$mysql = new MySQL();
$mysql->conectar();

$query = "SELECT count(empleados.id) as cantidad, cargo.nombre as cargos
  from empleados JOIN cargo ON empleados.cargo_id=cargo.id group by cargo.nombre";
$result = $mysql->efectuarConsulta($query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
$data[] = $row;
}


header('Content-Type: application/json');
echo json_encode($data);
?>