<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consultar Gráficos</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">


  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


  <style>
    body {
      background: linear-gradient(120deg, #007a33, #28a745, #f8f9fa);
      min-height: 100vh;
    }

    .card {
      background: rgba(255,255,255,0.85);
      backdrop-filter: blur(8px);
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .section-title {
      background: linear-gradient(90deg, #007a33, #28a745);
      color: white;
      text-align: center;
      padding: 12px;
      border-radius: 8px;
      font-weight: bold;
      letter-spacing: 1px;
      margin-bottom: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>
  <div class="container py-4">

 
    <h1 class="section-title">Consultar Gráficos</h1>

    <div class="row g-4">
   
      <div class="col-md-6">
        <div class="card p-4">
          <h4 class="text-success text-center mb-3">Empleados por departamento</h4>
          <canvas id="graficoDepartamento" height="200"></canvas>
        </div>
      </div>

     
      <div class="col-md-6">
        <div class="card p-4">
          <h4 class="text-success text-center mb-3">Empleados por cargo</h4>
          <canvas id="graficoCargo" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>

  <script src="../PUBLIC/JS/grafico.js"></script>
  <script src="../PUBLIC/JS/grafico_2.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



