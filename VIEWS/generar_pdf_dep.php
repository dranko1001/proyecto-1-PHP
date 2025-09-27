<?php
require('../LIBS/FPDF/fpdf.php');
require_once '../MODELO/MySQL.php';

// Obtener el departamento desde el formulario
$departamento = isset($_GET['departamento_area']) ? $_GET['departamento_area'] : '';

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Listado de Empleados - Departamento: ' . ucfirst($departamento), 0, 1, 'C');
$pdf->Cell(0, 10, '', 0, 1); // Espacio

// Cabecera de tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Nombre', 1, 0, 'C');
$pdf->Cell(40, 10, 'Documento', 1, 0, 'C');
$pdf->Cell(40, 10, 'Cargo', 1, 0, 'C');
$pdf->Cell(40, 10, 'Estado', 1, 1, 'C');

// Conexión y consulta
$mysql = new MySQL();
$mysql->conectar();

$consulta = "SELECT empleados.nombre as name, empleados.num_documento, cargo.nombre as cargo_nombre, empleados.estado
             FROM empleados 
             JOIN cargo ON empleados.cargo_id = cargo.id 
             WHERE empleados.departamento_id = '$departamento'";

$resultado = $mysql->efectuarConsulta($consulta);

// Llenar la tabla
$pdf->SetFont('Arial', '', 10);
while ($fila = $resultado->fetch_assoc()) {
    $pdf->Cell(40, 10, utf8_decode($fila['name']), 1, 0, 'L');
    $pdf->Cell(40, 10, utf8_decode($fila['num_documento']), 1, 0, 'L');
    $pdf->Cell(40, 10, utf8_decode($fila['cargo_nombre']), 1, 0, 'L');
    $pdf->Cell(40, 10, utf8_decode($fila['estado']), 1, 1, 'L');
}

$mysql->desconectar();
$pdf->Output('I', 'listado_empleados_' . $departamento . '.pdf');
?>
