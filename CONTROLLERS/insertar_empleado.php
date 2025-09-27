<?php
require_once '../MODELO/MySQL.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $num_documento = htmlspecialchars($_POST['num_documento'], ENT_QUOTES, 'UTF-8');
    $cargo = htmlspecialchars($_POST['cargo'], ENT_QUOTES, 'UTF-8');
    $departamento_area = htmlspecialchars($_POST['departamento_area'], ENT_QUOTES, 'UTF-8'); 
    $fecha = htmlspecialchars($_POST['fecha'], ENT_QUOTES, 'UTF-8'); 
    $salario = filter_var($_POST['salario'], FILTER_SANITIZE_NUMBER_INT);
    $estado = htmlspecialchars($_POST['estado'], ENT_QUOTES, 'UTF-8'); 
    $correo = htmlspecialchars($_POST['correo'], ENT_QUOTES, 'UTF-8'); 
    $telefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8'); 
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_BCRYPT);

    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $permitidos = ['image/jpeg' => '.jpg', 'image/png' => '.png'];
        $tipo = mime_content_type($_FILES['foto']['tmp_name']);

        if (array_key_exists($tipo, $permitidos)) {
            $ext = $permitidos[$tipo];
            $nombreUnico = 'emp_' . date('Ymd_Hisv') . $ext;
            $rutaRelativa = 'ASSETS/FOTOS/' . $nombreUnico;   
            $rutaFisica   = __DIR__ . '/../' . $rutaRelativa; 

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaFisica)) {
                $foto = $rutaRelativa;
            }
        }
    }

    $mysql = new MySQL();
    $mysql->conectar();

    $consulta = "
        INSERT INTO empleados 
        (id, nombre, num_documento, fecha, salario, estado, correo, telefono, cargo_id, departamento_id, foto, password) 
        VALUES 
        (NULL, '$nombre', '$num_documento', '$fecha', '$salario', '$estado', '$correo', '$telefono', '$cargo', '$departamento_area', '$foto', '$hash')
    ";

    $resultado = $mysql->efectuarConsulta($consulta);
    $mysql->desconectar();

    if ($resultado) {
        echo "ok";
        header('Location:../index.php');
    } else {
        echo "error";
        header('Location:../index.php');
    }
    exit();
}

