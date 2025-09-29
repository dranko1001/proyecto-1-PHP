<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: VIEWS/login.php?error=2");
    exit();
}


require_once 'MODELO/MySQL.php';
$mysql = new MySQL();
$mysql->conectar();


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
  <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />

 
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .nav-link:hover {
      background-color: #006400; 
      color: #ffc107 !important; 
      border-radius: 5px;
    }


  </style>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <style>
body {
  background: linear-gradient(
    120deg,
    #ffffff 60%,  
    #a9dfbf 85%,  
    #28a745 100% 
  );
  min-height: 100vh;
}

.card, .table {
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(10px);
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}
.reporte-title {
  background: linear-gradient(90deg, #007a33, #28a745);
  border-radius: 10px;
  font-weight: bold;
  letter-spacing: 1px;
}
.section-title {
  background: linear-gradient(90deg, #007a33, #28a745);
  color: white;
  text-align: center;
  padding: 12px;
  border-radius: 10px;
  font-weight: bold;
  letter-spacing: 1px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}
.welcome-title {
  background: linear-gradient(90deg, #007a33, #28a745);
  padding: 20px;
  border-radius: 12px;
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 2px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}
      </style>
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
<h1 class="welcome-title text-white text-center mb-4">
  Bienvenido <?php echo ($_SESSION['cargo'] == 2) ? ' Administrador' : ' Empleado'; ?>
</h1>



<h2 class="reporte-title text-white text-center py-3 mb-4 shadow-sm">
  Generar Reporte:
</h2>

<?php if ($_SESSION['cargo'] == 2): ?>
<div class="card p-4 mb-4 shadow-sm">
  <form action="./VIEWS/generar_pdf_dep.php" method="GET" class="row g-4">
    
 
    <div class="col-12">
      <label for="departamento_area" class="form-label fw-bold">Departamento (área):</label>
      <select name="departamento_area" id="departamento_area" class="form-select">
        <option value="1">Electricidad</option>
        <option value="2">Mantenimiento</option>
        <option value="3">Recursos Humanos</option>
        <option value="4">Contabilidad</option>
      </select>
    </div>

    
    <div class="col-12">
      <div class="row g-3">
        

        <div class="col-md-4">
          <div class="card p-3 text-center shadow-sm">
            <button type="submit" class="btn btn-warning w-100">
              Generar PDF por departamento
            </button>
          </div>
        </div>



        
        <div class="col-md-4">
          <div class="card p-3 text-center shadow-sm">
            <a href="./VIEWS/generar_pdf.php" class="btn btn-warning w-100">
              Generar PDF por usuario
            </a>
          </div>
        </div>

        <h2 class="reporte-title text-white text-center py-3 mb-4 shadow-sm">
  funcionalidades extra:
</h2>
                <div class="col-md-4">
          <div class="card p-3 text-center shadow-sm">
            <button type="button" onclick="agregarPersonas()" class="btn btn-success w-100">
              Agregar persona
            </button>
          </div>
        </div>

                        <div class="col-md-4">
          <div class="card p-3 text-center shadow-sm">
<button type="button" onclick="window.open('PUBLIC/grafico.html', '_blank')" class="btn btn-info w-100">
  Consultar Gráficos
</button>
          </div>
        </div>

      </div>
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

<h2 class="section-title mb-4">Lista de usuarios</h2>



  <?php endif; ?>



<div id="response"></div>
<div class="table-responsive">
  <table id="tablaPersonas" class="table table-striped table-bordered align-middle">
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
              <button type="button" class="btn btn-sm btn-primary mb-1" onclick="editarPersona(<?= $fila['id']; ?>)">
  Editar
</button>

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


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
  $(document).ready(function() {
    $('#tablaPersonas').DataTable({
      responsive: true,
      autoWidth: false,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
      }
    });
  });
</script>


<!-- 
                            <?php
                            $consultaCargos = $mysql->efectuarConsulta("SELECT id, nombre FROM cargo");
                            while($fila=$consultaCargos->fetch_assoc()): ?>
                            <?php echo $fila['id'];?>"> <?php echo $fila['nombre'];?> 
                            <?php endwhile; ?>

                        <?php
                        $consultaDepartamentos = $mysql->efectuarConsulta("SELECT id, nombre FROM departamento");
                        while($fila=$consultaDepartamentos->fetch_assoc()): ?>
 <?php echo $fila['nombre']; ?>
                            
                        <?php endwhile; ?>
 -->
<script>
    function agregarPersonas() {

        Swal.fire({
            title: 'Agregar Nueva Persona',
            html: `
                
                <form id="formAgregarPersona" class="text-start" action="agregar.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="documento" class="form-label">Número de documento</label>
                        <input type="text" class="form-control" id="num_documento" name="documento" required>
                    </div>
                    <div class="mb-3">
                        <label for="cargo" class="form-label">Cargo</label>
                        <select class="form-select" id="cargo" name="cargo" required>
                            <option value="" disabled selected>Seleccione un cargo</option>
                            <?php
                     
                            $consultaCargos = $mysql->efectuarConsulta("SELECT id, nombre FROM cargo");
                            while($fila=$consultaCargos->fetch_assoc()): ?>
                            <option value="<?php echo $fila['id'];?>"> <?php echo $fila['nombre'];?> </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Área o Departamento</label><br>
                        <?php
                     
                        $consultaDepartamentos = $mysql->efectuarConsulta("SELECT id, nombre FROM departamento");
                        while($fila=$consultaDepartamentos->fetch_assoc()): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="area" id="area_<?php echo $fila['id']; ?>" value="<?php echo $fila['id']; ?>" required>
                            <label class="form-check-label" for="area_<?php echo $fila['id']; ?>"><?php echo $fila['nombre']; ?></label>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="mb-3">
                        <label for="salario" class="form-label">Salario</label>
                        <input type="number" class="form-control" id="salario" name="salario" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha de ingreso</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>  
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Foto Empleado</label>
                        <input type="file" class="form-control" id="foto" name="imagen" accept=".jpg,.jpeg,.png" required>    
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo">
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>
                </form>

            `,
       
            confirmButtonText: 'Agregar',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            focusConfirm: false,
           
            preConfirm: () => {
                
                
                const nombre      = document.getElementById('nombre').value.trim();
                
                const contrasena  = document.getElementById('contrasena').value.trim(); 
                const documento   = document.getElementById('num_documento').value.trim();
               
                const cargo       = document.getElementById('cargo').value.trim();
               
                const area        = document.querySelector('input[name="area"]:checked')?.value || ''; 

                const salario     = document.getElementById('salario').value.trim();
                const fecha       = document.getElementById('fecha').value.trim();
                const imagen      = document.getElementById('foto').files[0];
                const correo      = document.getElementById('correo').value.trim();
                const telefono    = document.getElementById('telefono').value.trim();
                
              
                if (!nombre || !contrasena || !documento || !cargo || !area || !salario || !fecha || !imagen) {
                    Swal.showValidationMessage(' Por favor, complete todos los campos requeridos (incluyendo la foto).');
                    return false;
                }
                
               
                const formData = new FormData();
                formData.append("nombre", nombre);
             
                formData.append("password", contrasena); 
                formData.append("documento", documento);
                formData.append("cargo", cargo);
                formData.append("area", area); 
                formData.append("salario", salario);
                formData.append("fecha", fecha);
                formData.append("correo", correo);
                formData.append("telefono", telefono);
                
                if (imagen) {
                    formData.append("imagen", imagen); 
                }
                
                return formData;
            }
        }).then((result) => {
            if (result.isConfirmed){
                const formData = result.value; 
                
               
                if (!formData) return; 

                $.ajax({
                    url: 'CONTROLLERS/agregarPersona.php',
                    type: 'POST',
                    data: formData,     
                    contentType: false,   
                    processData: false,   
                    dataType: 'json',
                    success: function(response){
                        console.log("Respuesta del servidor:", response); 

                        if (response.success) {
                            
                            Swal.fire(' Éxito!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                           
                            Swal.fire(' Atención', response.message, 'warning');
                        }
                    },
                    error: function(xhr, status, error){
                        console.error("Error AJAX:", error, xhr.responseText);
                        Swal.fire(' Error', 'El servidor no respondió correctamente o hubo un fallo en el controlador.', 'error');
                    }
                });
            }
        });
    }
</script>


<script>
function editarPersona(id) {
    $.ajax({
        url: 'VIEWS/form_editar.php',  
        type: 'GET',
        data: { id: id },
        success: function(response) {
            Swal.fire({
                title: 'Editar Persona',
                html: response,
                showCancelButton: true,
                confirmButtonText: 'Guardar cambios',
                cancelButtonText: 'Cancelar',
                focusConfirm: false,
                preConfirm: () => {
                    const form = document.getElementById('formEditarPersona');
                    const formData = new FormData(form);

                  
                    if (!formData.get('nombre') || !formData.get('documento')) {
                        Swal.showValidationMessage(' Completa todos los campos obligatorios.');
                        return false;
                    }
                    return formData;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'CONTROLLERS/editarPersona.php',
                        type: 'POST',
                        data: result.value,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(res) {
                            if (res.success) {
                                Swal.fire(' Éxito', res.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(' Atención', res.message, 'warning');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(' Error', 'No se pudo actualizar.', 'error');
                        }
                    });
                }
            });
        },
        error: function() {
            Swal.fire(' Error', 'No se pudo cargar el formulario de edición.', 'error');
        }
    });
}
</script>





</body>
</html>