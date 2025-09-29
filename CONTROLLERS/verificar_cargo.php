<?php
session_start();



if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../VIEWS/login.php?error=2");
    exit();
}


if (!isset($_SESSION['estado']) || strtolower($_SESSION['estado']) !== 'activo') {
    session_destroy();
    header("Location: ../VIEWS/acceso_denegado.php"); 
    exit();
} else {
    header("Location: ../index.php");
    exit();
}

?>

