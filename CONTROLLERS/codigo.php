<?php 
require_once '../MODELO/MySQL.php';
$mysql = new MySQL();
$mysql->conectar();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
header('Content-Type: application/json; charset=utf-8');

    $required = ['nombre','password','documento','cargo','area','fecha','salario','correo','telefono'];
    foreach ($required as $campo) {
        if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => "Falta el campo $campo"]);
            exit;
        }
    }
 
   
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'No se seleccionó una imagen válida.']);
        exit;
    }

    $permitidos = ['image/jpeg' => '.jpg', 'image/png' => '.png'];
    $tipo = mime_content_type($_FILES['imagen']['tmp_name']);
    if (!array_key_exists($tipo, $permitidos)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Solo se permiten imágenes JPG y PNG.']);
        exit;
    }

    $ext = $permitidos[$tipo];
    $nombreUnico = 'imagen_' . date('Ymd_Hisv') . $ext;

    $ruta = 'ASSETS/FOTOS' . $nombreUnico;
    $rutaAbsoluta = __DIR__ . '/../ASSETS/FOTOS/' . $nombreUnico;

  
    $nombre    = htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8');
    $password  = $_POST['password'];
    $num_documento = htmlspecialchars(trim($_POST['documento']), ENT_QUOTES, 'UTF-8');
    $cargo     = htmlspecialchars(trim($_POST['cargo']), ENT_QUOTES, 'UTF-8');
    $departamento_area     = $_POST['area'];
    $fecha     = $_POST['fecha'];
    $salario   = htmlspecialchars(trim($_POST['salario']), ENT_QUOTES, 'UTF-8');
    $correo    = htmlspecialchars(trim($_POST['correo']), ENT_QUOTES, 'UTF-8');
    $telefono  = htmlspecialchars(trim($_POST['telefono']), ENT_QUOTES, 'UTF-8');

    $estado = "Activo";
    $hash   = password_hash($password, PASSWORD_BCRYPT);

  
    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaAbsoluta)) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error al subir la imagen']);
        exit;
    }
 


   
    $consulta = "
        INSERT INTO empleados 
        (id, nombre, num_documento, fecha, salario, estado, correo, telefono, cargo_id, departamento_id, foto, password) 
        VALUES 
        (NULL, '$nombre', '$num_documento', '$fecha', '$salario', '$estado', '$correo', '$telefono', '$cargo', '$departamento_area', '$ruta', '$hash')
    ";

   
$consultaDocumento = "
    SELECT id
    FROM empleados 
    WHERE num_documento = '$documento' OR correo = '$correo'
";

$result = $mysql->efectuarConsulta($consultaDocumento);
if ($result && mysqli_num_rows($result) > 0) {
    http_response_code(200);
    echo json_encode([
        'success' => false, 
        'message' => 'El documento o correo ya está registrado.'
    ]);
    exit;
}



    if ($mysql->efectuarConsulta($consulta)) {
        echo json_encode(['success' => true, 'message' => 'Empleado agregado exitosamente.']);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Error al agregar el empleado.']);
    }

    $mysql->desconectar();
}