<?php
require_once '../MODELO/MySQL.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $num_documento = htmlspecialchars($_POST['num_documento'], ENT_QUOTES, 'UTF-8');
    $cargo = htmlspecialchars($_POST['cargo'], ENT_QUOTES, 'UTF-8');
    $departamento_area = htmlspecialchars($_POST['departamento_area'], ENT_QUOTES, 'UTF-8'); 
    $fecha = htmlspecialchars($_POST['fecha'], ENT_QUOTES, 'UTF-8'); 
    $salario = filter_var($_POST['salario'], FILTER_SANITIZE_NUMBER_INT);
    $estado = htmlspecialchars($_POST['estado'], ENT_QUOTES, 'UTF-8'); 
    $correo = htmlspecialchars($_POST['correo'], ENT_QUOTES, 'UTF-8'); 
    $telefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8'); 

    $mysql = new MySQL();
    $mysql->conectar();

    $res = $mysql->efectuarConsulta("SELECT foto FROM empleados WHERE id = $id");
    $empleado = $res->fetch_assoc();
    $fotoAnterior = $empleado['foto'];

    $fotoNueva = $fotoAnterior; 


    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $permitidos = ['image/jpeg' => '.jpg', 'image/png' => '.png'];
        $tipo = mime_content_type($_FILES['foto']['tmp_name']);

        if (array_key_exists($tipo, $permitidos)) {
            $ext = $permitidos[$tipo];
            $nombreUnico = 'emp_' . date('Ymd_Hisv') . $ext;
            $rutaRelativa = 'ASSETS/FOTOS/' . $nombreUnico;
            $rutaFisica   = __DIR__ . '/../' . $rutaRelativa;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaFisica)) {
                $fotoNueva = $rutaRelativa;
              
                if ($fotoAnterior) {
                    $rutaAntFisica = __DIR__ . '/../' . $fotoAnterior;
                    if (is_file($rutaAntFisica)) {
                        unlink($rutaAntFisica);
                    }
                }
            }
        }
    }

    $mysql->efectuarConsulta("
        UPDATE empleados 
        SET nombre = '$nombre',
            num_documento = '$num_documento',
            fecha = '$fecha',
            salario = '$salario',
            estado = '$estado',
            correo = '$correo',
            telefono = '$telefono',
            cargo_id = '$cargo',
            departamento_id = '$departamento_area',
            foto = '$fotoNueva'
        WHERE id = $id
    ");

    $mysql->desconectar();
    header('Location: ../index.php');
    exit();
}
