<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['rol']) || empty($_POST['tarea']) || empty($_POST['descripcion']) || empty($_POST['fecha_inicio']) || empty($_POST['fecha_entrega']) || empty($_POST['hora'])) {
    $alert = '<div class="alert alert-primary" role="alert">
              Todo los campos son requeridos
            </div>';
  } else {
    $idnota= $_GET['id'];
    $rol = $_POST['rol'];
    $tarea = $_POST['tarea'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $hora = $_POST['hora'];

    $query_update = mysqli_query($conexion, "UPDATE notas SET id_rol = '$rol', tarea= '$tarea', descripcion= '$descripcion', fecha_inicio= '$fecha_inicio', fecha_entrega= '$fecha_entrega', hora='$hora' WHERE idnota='$idnota'");
    if ($query_update) {
      $alert = '<div class="alert alert-primary" role="alert">
              Modificado
            </div>';
    } else {
      $alert = '<div class="alert alert-primary" role="alert">
                Error al Modificar
              </div>';
    }
  }
}

// Validar nota

if (empty($_REQUEST['id'])) {
  header("Location: listar_notas.php");
} else {
  $idnota = $_REQUEST['id'];
  if (!is_numeric($idnota)) {
    header("Location: listar_notas.php");
  }
  $query_notas = mysqli_query($conexion, "SELECT n.idnota, n.tarea, n.descripcion, n.fecha_inicio, n.fecha_entrega, n.hora, r.idrol, r.rol 
  FROM notas n INNER JOIN rol r ON n.id_rol = r.idrol  WHERE n.idnota = $idnota");
  $result_notas = mysqli_num_rows($query_notas);

  if ($result_notas > 0) {
    $data_notas = mysqli_fetch_assoc($query_notas);
  } else {
    header("Location: listar_notas.php");
  }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white">
          Modificar Nota
        </div>
        <div class="card-body">
          <form action="" method="post">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="form-group">
              <label for="nombre">Roles</label>
              <?php $query_notas = mysqli_query($conexion, "SELECT * FROM rol");
              $resultado_notas = mysqli_num_rows($query_notas);
              mysqli_close($conexion);
              ?>
              <select id="rol" name="rol" class="form-control">
               
                <?php
                if ($resultado_notas > 0) {
                  while ($rs = mysqli_fetch_array($query_notas)) {
                    // code...
                ?>
                    <option <?php if ($data_notas['idrol'] == $rs['idrol']){echo "selected";} ?> value="<?php echo $rs['idrol']; ?>"><?php echo $rs['rol']; ?></option>
                    
                <?php
                  }
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="tarea">Tarea</label>
              <input type="text" class="form-control" placeholder="Ingrese Nota" name="tarea" id="tarea" value="<?php echo $data_notas['tarea']; ?>">
            </div>
            <div class="form-group">
              <label for="descripcion">Descripcion</label>
              <input type="text" placeholder="Ingrese descripcion" class="form-control" name="descripcion" id="descripcion" value="<?php echo $data_notas['descripcion']; ?>">
            </div>
            <div class="col-md-5">
               <div class="form-group">
                 <label for="fecha_inicio">Modificar Fecha de Inicio <span class="text-danger fw-bold">*</span></label>
                 <input id="fecha_inicio" class="form-control" type="date" name="fecha_inicio"  value="<?php echo $data_notas['fecha_inicio']; ?>">
               </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                  <label for="fecha_entrega">Modificar Fecha de Entrega <span class="text-danger fw-bold">*</span></label>
                  <input id="fecha_entrega" class="form-control" type="date" name="fecha_entrega" value="<?php echo $data_notas['fecha_entrega']; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating mb-4">
                   <label for="hora">Hora Entrega <span class="text-danger fw-bold">*</span></label>
                   <input id="hora" class="form-control" type="time" name="hora" value="<?php echo date($data_notas['hora']); ?>" required>
                </div>
            </div>
            <input type="submit" value="Actualizar Nota" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
  </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>