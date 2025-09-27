<?php
require_once '../MODELO/MySQL.php';
session_start();

if (
    isset($_POST['documento'], $_POST['password']) && 
    !empty($_POST['documento']) && 
    !empty($_POST['password'])
) {
    $mysql = new MySQL();
    $mysql->conectar();

    $documento = htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8'); 
    $password = $_POST['password'];

    $resultado = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE num_documento = '$documento'");

    if ($usuario = mysqli_fetch_assoc($resultado)) {
        if (password_verify($password, $usuario['password'])) {
            // Guardar datos en la sesión (sin importar si está activo o no)
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['documento'] = $usuario['num_documento'];
            $_SESSION['cargo'] = $usuario['cargo_id'];
            $_SESSION['estado'] = $usuario['estado'];
            $_SESSION['nombre'] = $usuario['nombre'];

            $mysql->desconectar();
            header("Location: ../CONTROLLERS/verificar_cargo.php");
            exit();
        } else {
            $mysql->desconectar();
            header("Location: ../VIEWS/login.php?error=1");
            exit();
        }
    } else {
        $mysql->desconectar();
        header("Location: ../VIEWS/login.php?error=1");
        exit();
    }
} else {
    header("Location: ../VIEWS/login.php?error=2");
    exit();
}
?>
