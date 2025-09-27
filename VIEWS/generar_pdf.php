<?php
// Incluir la biblioteca FPDF desde la carpeta 'lib/fpdf'
require('../LIBS/FPDF/fpdf.php');

// Conexión a la base de datos
require_once '../MODELO/MySQL.php';

// Crear una nueva instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Título del PDF
$pdf->Cell(0, 10, 'Listado de Empleados', 0, 1, 'C');

// Espacio en blanco
$pdf->Cell(0, 10, '', 0, 1);

// Cabecera de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Nombre', 1, 0, 'C');
$pdf->Cell(40, 10, 'Documento', 1, 0, 'C');
$pdf->Cell(40, 10, 'Cargo', 1, 0, 'C');
$pdf->Cell(40, 10, 'Estado', 1, 1, 'C');

// Conectar a la base de datos
$mysql = new MySQL();
$mysql->conectar();

// Consulta para obtener los empleados
$consulta = "SELECT 
                empleados.nombre as name,
                empleados.num_documento,
                cargo.nombre,
                empleados.estado
            FROM
                empleados
            JOIN
                cargo ON empleados.cargo_id = cargo.id";

$resultado = $mysql->efectuarConsulta($consulta);

$pdf->SetFont('Arial', '', 10);

// Llenar la tabla con los datos de los empleados
while ($fila = $resultado->fetch_assoc()) {
    $pdf->Cell(40, 10, utf8_decode($fila['name']), 1, 0, 'L');
    $pdf->Cell(40, 10, utf8_decode($fila['num_documento']), 1, 0, 'L');
    $pdf->Cell(40, 10, utf8_decode($fila['nombre']), 1, 0, 'L');
    $pdf->Cell(40, 10, utf8_decode($fila['estado']), 1, 1, 'L');
}

// Desconectar la base de datos
$mysql->desconectar();

// Salida del PDF
$pdf->Output('I', 'listado_empleados.pdf');
?>