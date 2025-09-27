<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-success d-flex justify-content-center align-items-center vh-100">

  <div class="card shadow-lg p-4" style="width: 380px;">
    <h2 class="text-center text-success mb-4">Iniciar Sesión</h2>

    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == '1') {
            echo '<div class="alert alert-danger">Credenciales inválidas. Verifique su documento y contraseña.</div>';
        } elseif ($_GET['error'] == '2') {
            echo '<div class="alert alert-warning">Debe iniciar sesión para acceder.</div>';
        } elseif ($_GET['error'] == '3') {
            echo '<div class="alert alert-danger">Su cuenta está inactiva. Contacte al administrador.</div>';
        }
    }
    ?>

    <form action="../CONTROLLERS/login.php" method="POST">
      <div class="mb-3">
        <label for="documento" class="form-label">Número de Documento</label>
        <input type="text" name="documento" id="documento" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-success w-100">Iniciar sesión</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

