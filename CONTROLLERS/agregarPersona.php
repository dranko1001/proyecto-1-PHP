<?php 
require_once '../MODELO/MySQL.php';
$mysql = new MySQL();
$mysql->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');

    $required = ['nombre','password','documento','cargo','area','fecha','salario','correo','telefono'];
    foreach ($required as $campo) {
        if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
            echo json_encode(['success' => false, 'message' => "Falta el campo $campo"]);
            exit;
        }
    }

    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'No se seleccionó una imagen válida.']);
        exit;
    }

    $permitidos = ['image/jpeg' => '.jpg', 'image/png' => '.png'];
    $tipo = mime_content_type($_FILES['imagen']['tmp_name']);
    if (!array_key_exists($tipo, $permitidos)) {
        echo json_encode(['success' => false, 'message' => 'Solo se permiten imágenes JPG y PNG.']);
        exit;
    }

    $ext = $permitidos[$tipo];
    $nombreUnico = 'imagen_' . date('Ymd_Hisv') . $ext;

    $ruta = 'ASSETS/FOTOS/' . $nombreUnico;
    $rutaAbsoluta = __DIR__ . '/../ASSETS/FOTOS/' . $nombreUnico;

    
    $nombre    = htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8');
    $password  = $_POST['password'];
    $num_documento = htmlspecialchars(trim($_POST['documento']), ENT_QUOTES, 'UTF-8');
    $cargo     = intval($_POST['cargo']);
    $departamento_area = intval($_POST['area']);
    $fecha     = $_POST['fecha'];
    $salario   = floatval($_POST['salario']);
    $correo    = htmlspecialchars(trim($_POST['correo']), ENT_QUOTES, 'UTF-8');
    $telefono  = htmlspecialchars(trim($_POST['telefono']), ENT_QUOTES, 'UTF-8');

    $estado = "Activo";
    $hash   = password_hash($password, PASSWORD_BCRYPT);

    $consultaDocumento = "
        SELECT id
        FROM empleados 
        WHERE num_documento = '$num_documento' OR correo = '$correo'
    ";
    $result = $mysql->efectuarConsulta($consultaDocumento);

    if ($result && mysqli_num_rows($result) > 0) {
        echo json_encode([
            'success' => false, 
            'message' => 'El documento o correo ya está registrado.'
        ]);
        exit;
    }

   
    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaAbsoluta)) {
        echo json_encode(['success' => false, 'message' => 'Error al subir la imagen']);
        exit;
    }

    $consulta = "
        INSERT INTO empleados 
        (id, nombre, num_documento, fecha, salario, estado, correo, telefono, cargo_id, departamento_id, foto, password) 
        VALUES 
        (NULL, '$nombre', '$num_documento', '$fecha', '$salario', '$estado', '$correo', '$telefono', '$cargo', '$departamento_area', '$ruta', '$hash')
    ";

    if ($mysql->efectuarConsulta($consulta)) {
        echo json_encode(['success' => true, 'message' => 'Empleado agregado exitosamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el empleado.']);
    }

    $mysql->desconectar();
}

