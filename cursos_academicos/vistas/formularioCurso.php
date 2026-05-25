<?php
require_once __DIR__ . '/../modelos/Docente.php';

$docenteModel = new Docente();
$docentes = $docenteModel->listar();

$isEdit = isset($curso) && !empty($curso);
$id = $isEdit ? $curso['id'] : '';
$cursoNombre = $isEdit ? htmlspecialchars($curso['curso']) : '';
$docenteId = $isEdit ? $curso['docente_id'] : '';
$creditos = $isEdit ? $curso['creditos'] : '';
$action = $isEdit ? '../controladores/actualizarcurso.php' : '../controladores/registrarcurso.php';
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?php echo $isEdit ? 'Editar Curso Académico' : 'Registrar Curso Académico'; ?></title>
</head>
<body>
  <h2><?php echo $isEdit ? 'Editar Curso Académico' : 'Registrar Curso Académico'; ?></h2>
  <form method="post" action="<?php echo $action; ?>">
    <?php if ($isEdit): ?>
      <input type="hidden" name="id" value="<?php echo $id; ?>">
    <?php endif; ?>

    <label>Curso:<br>
      <input type="text" name="curso" value="<?php echo $cursoNombre; ?>" required>
    </label>
    <br>
    <label>Docente:<br>
      <select name="docente_id" required>
        <option value="">Seleccionar docente</option>
        <?php foreach ($docentes as $d): ?>
          <option value="<?php echo $d['id']; ?>" <?php echo $docenteId == $d['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($d['nombre']); ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <br>
    <label>Créditos:<br>
      <input type="number" name="creditos" value="<?php echo $creditos; ?>" required>
    </label>
    <br><br>
    <button type="submit"><?php echo $isEdit ? 'Actualizar' : 'Registrar'; ?></button>
    <a href="../index.php">Volver</a>
  </form>
</body>
</html>
