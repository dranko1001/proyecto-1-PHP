<?php
session_start();
session_destroy();
header("Location: ../VIEWS/login.php");
exit();
?>