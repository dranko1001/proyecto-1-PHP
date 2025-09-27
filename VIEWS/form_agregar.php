<!-- VIEWS/form_agregar.php -->
<form class="form-agregar" action="https://localhost/taller_1_crup_php/CONTROLLERS/insertar_empleado.php" method="POST" enctype="multipart/form-data">

  <div>
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" required />
  </div>

  <div>
    <label for="num_documento">Número de Documento</label>
    <input type="text" name="num_documento" id="num_documento" required />
  </div>

  <div>
    <label for="cargo">Cargo</label>
    <select name="cargo" id="cargo" required>
      <option value="1">Técnico</option>
      <option value="2">Administrador</option>
      <option value="3">Operario</option>
      <option value="4">Asistente</option>
    </select>
  </div>

  <div>
    <label for="departamento_area">Departamento (área)</label>
    <select name="departamento_area" id="departamento_area" required>
      <option value="1">Electricidad</option>
      <option value="2">Mantenimiento</option>
      <option value="3">Recursos Humanos</option>
      <option value="4">Contabilidad</option>
    </select>
  </div>

  <div>
    <label for="fecha">Fecha</label>
    <input type="date" name="fecha" id="fecha" required />
  </div>

  <div>
    <label for="salario">Salario</label>
    <input type="number" name="salario" id="salario" required />
  </div>

  <div>
    <label for="estado">Estado</label>
    <select name="estado" id="estado" required>
      <option value="activo">Activo</option>
      <option value="inactivo">Inactivo</option>
    </select>
  </div>

  <div>
    <label for="correo">Correo</label>
    <input type="email" name="correo" id="correo" required />
  </div>

  <div>
    <label for="telefono">Teléfono</label>
    <input type="text" name="telefono" id="telefono" required />
  </div>

  <div>
    <label for="foto">Foto</label>
    <input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png" required />
  </div>

  <div>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" required />
  </div>

  <div>
    <button type="submit">Agregar</button>
  </div>

</form>
