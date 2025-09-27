<?php
require_once 'MODELO/MySQL.php';

$mysql = new MySQL();
$mysql->conectar();

$id = $_GET['id'];
$resultado = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE id = $id");
$empleado = $resultado->fetch_assoc();

$mysql->desconectar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../custom.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4 text-success">Editar Empleado</h1>
        
        <div class="card p-4 shadow-sm">
            <form action="../CONTROLLERS/actualizar_imagen.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $empleado['id']; ?>">

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $empleado['nombre']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="num_documento" class="form-label">Documento:</label>
                    <input type="text" class="form-control" name="num_documento" value="<?php echo $empleado['num_documento']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="cargo" class="form-label">Cargo:</label>
                    <input type="text" class="form-control" name="cargo" value="<?php echo $empleado['cargo_id']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="departamento_area" class="form-label">Departamento:</label>
                    <input type="text" class="form-control" name="departamento_area" value="<?php echo $empleado['departamento_id']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha:</label>
                    <input type="date" class="form-control" name="fecha" value="<?php echo $empleado['fecha']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="salario" class="form-label">Salario:</label>
                    <input type="number" class="form-control" name="salario" value="<?php echo $empleado['salario']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado:</label>
                    <input type="text" class="form-control" name="estado" value="<?php echo $empleado['estado']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo:</label>
                    <input type="email" class="form-control" name="correo" value="<?php echo $empleado['correo']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono:</label>
                    <input type="text" class="form-control" name="telefono" value="<?php echo $empleado['telefono']; ?>" required>
                </div>

                <div class="mb-3">
                    <p class="fw-bold">Foto actual:</p>
                    <?php if ($empleado['foto']): ?>
                        <img src="../<?php echo $empleado['foto']; ?>" width="120" class="img-thumbnail mb-2">
                    <?php else: ?>
                        <span class="text-muted">Sin foto</span>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Nueva foto (opcional):</label>
                    <input type="file" class="form-control" name="foto" accept=".jpg,.jpeg,.png">
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="index.php" class="btn btn-secondary ms-2">Volver al listado</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

