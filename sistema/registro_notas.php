<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['id_rol']) || empty($_POST['tarea']) || empty($_POST['descripcion']) || empty($_POST['fecha_inicio']) || empty($_POST['fecha_entrega']) || empty($_POST['hora'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                                    Todo los campos son obligatorio
                                </div>';
    } else {
        
        $id_rol = $_POST['id_rol'];
        $tarea = $_POST['tarea'];
        $descripcion = $_POST['descripcion'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_entrega = $_POST['fecha_entrega'];
        $hora = $_POST['hora'];

            $query_insert = mysqli_query($conexion, "INSERT INTO notas(idrol,tarea,descripcion,fecha_inicio,fecha_entrega,hora) values ('$id_rol', '$tarea', '$descripcion', '$fecha_inicio', '$fecha_entrega', '$hora')");
            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                                    Nota Registrada
                                </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                                    Error al Guardar
                            </div>';
            }
        
    }
    
}
/* include_once "includes/header.php";
  include "../conexion.php";
  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['asignador']) || empty($_POST['tarea']) || empty($_POST['descripcion'])) {
      $alert = '<div class="alert alert-danger" role="alert">
                Todo los campos son obligatorios
              </div>';
    } else {
      $asignador = $_POST['asignador'];
      $tarea = $_POST['tarea'];
      $descripcion = $_POST['descripcion'];
     

      $query_insert = mysqli_query($conexion, "INSERT INTO notas(idnota,asignador,tarea,descripcion) values ('$idnota', '$asignador', '$tarea', '$descripciòn')");
      if ($query_insert) {
        $alert = '<div class="alert alert-primary" role="alert">
                Nota Registrada
              </div>';
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
                Error al registrar la nota
              </div>';
      }
    }
  }
  */?>

 <!-- Begin Page Content -->
 <div class="container-fluid">

   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800">PANEL REGISTRO NOTAS</h1>
     <a href="listar_notas.php" class="btn btn-primary">Regresar</a>
   </div>

   <!-- Content Row -->
   <div class="row">
     <div class="col-lg-6 m-auto">
       <form action="" method="post" autocomplete="off">
         <?php echo isset($alert) ? $alert : ''; ?>
         <div class="form-group">
           <label>Asignador</label>
           <?php
            $query_proveedor =  mysqli_query($conexion, "SELECT idrol, rol FROM rol ORDER BY rol ASC");
            $resultado_proveedor = mysqli_num_rows($query_proveedor);
            mysqli_close($conexion);
            ?>
           <select id="id_rol" name="id_rol" class="form-control">
             <?php
              if ($resultado_proveedor > 0) {
                while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                  // code...
              ?>
                 <option value="<?php echo $proveedor['idrol']; ?>"><?php echo $proveedor['rol']; ?></option>
             <?php
                }
              }
              ?>
           </select>
         </div>
         <div class="form-group">
           <label for="">Tarea</label>
           <input type="text" placeholder="Ingrese nombre de la tarea" name="tarea" id="tarea" class="form-control">
         </div>
         <div class="form-group">
           <label for="">Descripcion</label>
           <input type="text" placeholder="Ingrese Descripciòn" class="form-control" name="descripcion" id="descripcion">
         </div>
         <div class="col-md-4">
            <div class="form-group">
              <label for="fecha">Fecha Inicio de Nota <span class="text-danger fw-bold">*</span></label>
              <input id="fecha_inicio" class="form-control" type="date" name="fecha_inicio" value="<?php echo date('d-m-Y'); ?>" required>
            </div>
         </div>

         <div class="col-md-4">
            <div class="form-group">
              <label for="fecha">Fecha Entrega de Nota <span class="text-danger fw-bold">*</span></label>
              <input id="fecha_enterga" class="form-control" type="date" name="fecha_entrega" value="<?php echo date('d-m-Y'); ?>" required>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-floating mb-4">
              <label for="hora">Hora Entrega <span class="text-danger fw-bold">*</span></label>
              <input id="hora" class="" type="time" name="hora" value="<?php echo date('H:i'); ?>" required>
            </div>
         </div>
         <input type="submit" value="Guardar Nota" class="btn btn-primary">
       </form>
     </div>
   </div>


 </div>
 <!-- /.container-fluid -->

 </div>
 <!-- End of Main Content -->
 <?php include_once "includes/footer.php"; ?>
