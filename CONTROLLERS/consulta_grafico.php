<?php

require_once '../MODELO/MySQL.php'; 
$mysql = new MySQL();
$mysql->conectar();

$query = "SELECT count(empleados.id) as cantidad, departamento.nombre as departamento
  from empleados JOIN departamento ON empleados.departamento_id=departamento.id group by departamento.nombre";
$result = $mysql->efectuarConsulta($query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
$data[] = $row;
}


header('Content-Type: application/json');
echo json_encode($data);
?>