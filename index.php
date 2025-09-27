<?php
session_start();

// Verificar si está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: VIEWS/login.php?error=2");
    exit();
}

// Conexión a la base de datos
require_once 'MODELO/MySQL.php';
$mysql = new MySQL();
$mysql->conectar();

// Consulta de empleados
$resultado = $mysql->efectuarConsulta("
    SELECT e.id, 
           e.nombre, 
           e.num_documento, 
           c.nombre AS cargo_nombre, 
           d.nombre AS departamento_nombre,
           e.fecha, 
           e.salario, 
           e.estado, 
           e.correo, 
           e.telefono, 
           e.foto
    FROM empleados e
    JOIN cargo c ON e.cargo_id = c.id
    JOIN departamento d ON e.departamento_id = d.id
    ORDER BY e.id DESC
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Personas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="custom.css" rel="stylesheet">
  
  <style>
    .nav-link:hover {
      background-color: #006400; 
      color: #ffc107 !important; 
      border-radius: 5px;
    }
    body {
  background: linear-gradient(135deg, #e6f4ea, #c8e6c9, #ffffff);
  min-height: 100vh;
}

  </style>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>


  
<header>
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #008000;">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="index.php">ServiPlus</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
              data-bs-target="#navbarNav" aria-controls="navbarNav" 
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">


          <?php if ($_SESSION['cargo'] != 2): ?>
            <li class="nav-item">
              <a class="nav-link active" href="index.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="VIEWS/login.php">Login</a>
            </li>
          <?php endif; ?>

          <?php if ($_SESSION['cargo'] == 2): ?>
            <li class="nav-item">
              <a class="nav-link active" href="index.php">Inicio</a>
            <!-- </li>
            <li class="nav-item">
              <a class="nav-link" href="VIEWS/agregar.php">Agregar persona</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="VIEWS/generar_pdf_dep.php">PDF por DEP</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="VIEWS/generar_pdf.php">PDF por usuario</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="PUBLIC/grafico.html">Gráficos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="VIEWS/login.php">Login</a>
            </li>
          <?php endif; ?>

          <li class="nav-item">
            <a class="btn btn-dark ms-2" href="CONTROLLERS/logout.php">Cerrar Sesión</a>
          </li>

        </ul>
      </div>
    </div>
  </nav>
</header>


<div class="container my-5">
  <h1 class="mb-4 text-center">
    Bienvenido <?php echo ($_SESSION['cargo'] == 2) ? 'Administrador' : 'Empleado'; ?>


  <h2 class="mb-4 text-success">Generar Reporte:</h2>

  <?php if ($_SESSION['cargo'] == 2): ?>
    <div class="card p-3 mb-4">
      <form action="./VIEWS/generar_pdf_dep.php" method="GET" class="row g-3">
        <div class="col-md-6">
          <label for="departamento_area" class="form-label">Departamento (área):</label>
          <select name="departamento_area" id="departamento_area" class="form-select">
            <option value="1">Electricidad</option>
            <option value="2">Mantenimiento</option>
            <option value="3">Recursos Humanos</option>
            <option value="4">Contabilidad</option>
          </select>
        </div>
        <div class="col-md-6 d-flex align-items-end gap-2">
          <button type="submit" class="btn btn-warning w-100">Generar PDF por departamento</button>
          <a href="./VIEWS/generar_pdf.php" class="btn btn-primary w-50">Generar PDF por usuario</a>
        </div>
      </form>
    </div>
<!-- <div class="container">
  <div class="row text-center">
    <div class="col-md-6">
      <h2>Gráfico de empleados por departamento</h2>
      <canvas id="graficoDepartamento" width="100" height="50"></canvas>
    </div>
    <div class="col-md-6">
      <h2>Gráfico de empleados por cargo</h2>
      <canvas id="graficoCargo" width="100" height="50"></canvas>
    </div>
  </div>
</div>

        <script src="../PUBLIC/JS/grafico.js"></script>
    <script src="../PUBLIC/JS/grafico_2.js"></script>
</div>
     -->

  </h1>
  <h5 class="mb-4 text-success">lista de usuarios:</h5>

    <!-- <div class="mb-3">
      <a href="./VIEWS/agregar.php" >Agregar nueva persona</a>
    </div> -->
  <?php endif; ?>

<button id="agregar" class="btn btn-success pb-2 mb-4">agregar persona</button>
<script>
function ajax() {

const http =new XMLHttpRequest();
const url='https://localhost/taller_1_crup_php/VIEWS/agregar.php';

http.onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        document.getElementById("response").innerHTML = this.responseText;
    }
    }
http.open("GET", url);
http.send();


}

document.getElementById("agregar").addEventListener("click", function(){
    ajax();
});
</script>






<!-- <button id="graficos" class="btn btn-success">mostrar graficos</button> -->
<!-- <script>
function ajaxGraficos() {

const http =new XMLHttpRequest();
const url='http://localhost/taller_1_crup_php/PUBLIC/grafico.html';

http.onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        document.getElementById("grafcs").innerHTML = this.responseText;
    }
    }
http.open("GET", url);
http.send();


}

document.getElementById("graficos").addEventListener("click", function(){
    ajaxGraficos();
});
</script> -->











<!-- // <div id="grafcs"></div> -->

<div id="response"></div>
  <div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
      <thead class="table-success text-center">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>N. Documento</th>
          <th>Cargo</th>
          <th>Área / Departamento</th>
          <th>Fecha</th>
          <th>Salario</th>
          <th>Estado</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th>Imagen</th>
          <?php if ($_SESSION['cargo'] == 2): ?>
            <th>Opciones</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php while($fila = $resultado->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($fila['id']); ?></td>
            <td><?= htmlspecialchars($fila['nombre']); ?></td>
            <td><?= htmlspecialchars($fila['num_documento']); ?></td>
            <td><?= htmlspecialchars($fila['cargo_nombre']); ?></td>
            <td><?= htmlspecialchars($fila['departamento_nombre']); ?></td>
            <td><?= htmlspecialchars($fila['fecha']); ?></td>
            <td><?= htmlspecialchars($fila['salario']); ?></td>
            <td><?= htmlspecialchars($fila['estado']); ?></td>
            <td><?= htmlspecialchars($fila['correo']); ?></td>
            <td><?= htmlspecialchars($fila['telefono']); ?></td>
            <td>
              <?php if (!empty($fila['foto'])): ?>
                <img src="<?= htmlspecialchars($fila['foto']); ?>" width="80" class="img-thumbnail">
              <?php else: ?>
                <span class="text-muted">Sin foto</span>
              <?php endif; ?>
            </td>
            <?php if ($_SESSION['cargo'] == 2): ?>
              <td class="text-center">
                <a href="editar.php?id=<?= $fila['id']; ?>" class="btn btn-sm btn-primary mb-1">Editar</a>
                <a href="eliminar.php?id=<?= $fila['id']; ?>" 
                   onclick="return confirm('¿Está seguro que desea eliminar esta persona?');"
                   class="btn btn-sm btn-danger">Eliminar</a>
              </td>
            <?php endif; ?>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>