<?php 
require_once '../MODELO/MySQL.php';
$mysql = new MySQL();
$mysql->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');

    $id = intval($_POST['id']);
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID inválido']);
        exit;
    }

    $nombre    = htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8');
    $password  = $_POST['password'] ?? '';
    $num_documento = htmlspecialchars(trim($_POST['documento']), ENT_QUOTES, 'UTF-8');
    $cargo     = intval($_POST['cargo']);
    $departamento_area = intval($_POST['area']);
    $fecha     = $_POST['fecha'];
    $salario   = floatval($_POST['salario']);
    $correo    = htmlspecialchars(trim($_POST['correo']), ENT_QUOTES, 'UTF-8');
    $telefono  = htmlspecialchars(trim($_POST['telefono']), ENT_QUOTES, 'UTF-8');


    $setPassword = "";
    if (!empty($password)) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $setPassword = ", password = '$hash'";
    }


    $setFoto = "";
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $permitidos = ['image/jpeg' => '.jpg', 'image/png' => '.png'];
        $tipo = mime_content_type($_FILES['imagen']['tmp_name']);
        if (array_key_exists($tipo, $permitidos)) {
            $ext = $permitidos[$tipo];
            $nombreUnico = 'imagen_' . date('Ymd_Hisv') . $ext;
            $ruta = 'ASSETS/FOTOS/' . $nombreUnico;
            $rutaAbsoluta = __DIR__ . '/../ASSETS/FOTOS/' . $nombreUnico;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaAbsoluta)) {
                $setFoto = ", foto = '$ruta'";
            }
        }
    }

  
    $consulta = "
        UPDATE empleados
        SET nombre = '$nombre',
            num_documento = '$num_documento',
            fecha = '$fecha',
            salario = '$salario',
            correo = '$correo',
            telefono = '$telefono',
            cargo_id = '$cargo',
            departamento_id = '$departamento_area'
            $setPassword
            $setFoto
        WHERE id = $id
    ";

    if ($mysql->efectuarConsulta($consulta)) {
        echo json_encode(['success' => true, 'message' => 'Empleado actualizado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el empleado.']);
    }

    $mysql->desconectar();
}
