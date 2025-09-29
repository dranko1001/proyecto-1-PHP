<?php
require_once '../MODELO/MySQL.php';
$mysql = new MySQL();
$mysql->conectar();

$id = intval($_GET['id']);
$consulta = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE id = $id");
$empleado = $consulta->fetch_assoc();

$cargos = $mysql->efectuarConsulta("SELECT id, nombre FROM cargo");

$departamentos = $mysql->efectuarConsulta("SELECT id, nombre FROM departamento");
?>

<div class="p-3">
  <h5 class="text-center mb-4 text-success fw-bold">
    ✏️ Editar Empleado
  </h5>

  <form id="formEditarPersona" class="text-start">
      <input type="hidden" name="id" value="<?= $empleado['id'] ?>">

      <div class="mb-3">
          <label for="nombre" class="form-label fw-semibold">👤 Nombre completo</label>
          <input type="text" class="form-control shadow-sm" id="nombre" name="nombre" 
                 value="<?= $empleado['nombre'] ?>" required>
      </div>

      <div class="mb-3">
          <label for="documento" class="form-label fw-semibold">🆔 Número de documento</label>
          <input type="text" class="form-control shadow-sm" id="documento" name="documento" 
                 value="<?= $empleado['num_documento'] ?>" required>
      </div>

      <div class="mb-3">
          <label for="correo" class="form-label fw-semibold">📧 Correo electrónico</label>
          <input type="email" class="form-control shadow-sm" id="correo" name="correo" 
                 value="<?= $empleado['correo'] ?>">
      </div>

      <div class="mb-3">
          <label for="telefono" class="form-label fw-semibold">📞 Teléfono</label>
          <input type="text" class="form-control shadow-sm" id="telefono" name="telefono" 
                 value="<?= $empleado['telefono'] ?>">
      </div>

      <div class="mb-3">
          <label for="cargo" class="form-label fw-semibold">💼 Cargo</label>
          <select class="form-select shadow-sm" id="cargo" name="cargo" required>
              <option disabled>Seleccione un cargo</option>
              <?php while($fila = $cargos->fetch_assoc()): ?>
                  <option value="<?= $fila['id'] ?>" 
                      <?= ($empleado['cargo_id'] == $fila['id']) ? 'selected' : '' ?>>
                      <?= $fila['nombre'] ?>
                  </option>
              <?php endwhile; ?>
          </select>
      </div>

      <div class="mb-3">
          <label class="form-label fw-semibold">🏢 Área o Departamento</label><br>
          <?php while($fila = $departamentos->fetch_assoc()): ?>
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" 
                         name="area" id="area_<?= $fila['id'] ?>" value="<?= $fila['id'] ?>"
                         <?= ($empleado['departamento_id'] == $fila['id']) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="area_<?= $fila['id'] ?>">
                      <?= $fila['nombre'] ?>
                  </label>
              </div>
          <?php endwhile; ?>
      </div>

      <div class="mb-3">
          <label for="salario" class="form-label fw-semibold">💲 Salario</label>
          <input type="number" class="form-control shadow-sm" id="salario" name="salario" 
                 value="<?= $empleado['salario'] ?>" required>
      </div>

      <div class="mb-3">
          <label for="fecha" class="form-label fw-semibold">📅 Fecha de ingreso</label>
          <input type="date" class="form-control shadow-sm" id="fecha" name="fecha" 
                 value="<?= $empleado['fecha'] ?>" required>
      </div>

      <div class="mb-3">
          <label for="foto" class="form-label fw-semibold">🖼️ Foto del empleado</label>
          <input type="file" class="form-control shadow-sm" id="foto" name="imagen" accept=".jpg,.jpeg,.png">
          <?php if (!empty($empleado['foto'])): ?>
          <?php endif; ?>
      </div>
  </form>
</div>


