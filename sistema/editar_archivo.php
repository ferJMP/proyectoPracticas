<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['nombre']) || empty($_FILES['archivos'])) {
    $alert = '<div class="alert alert-primary" role="alert">
              Todo los campos son requeridos
            </div>';
  } else {
      $idarchivo = $_GET['id'];
      $nombre = $_POST['nombre'];
      $archivos=null;
      $ruta_archivo=null; //ruta de mi base de datos
      $query = mysqli_query($conexion, "SELECT * FROM archivos WHERE idarchivo = $idarchivo");
      $result = mysqli_num_rows($query);
      if ($result > 0) {
          if($data = mysqli_fetch_assoc($query)){
                $ruta_archivo=$data['archivos']; //obtengo el archivo -> ruta base de datos
          }
      }
      if($_FILES['archivos']['name']!=null){
        if(unlink($ruta_archivo)) { //elimino la ruta de mi base de datos/ proyecto
          $archivos = $_FILES['archivos']['name'];
          $ruta = $_FILES['archivos']['tmp_name'];
          $destino = "archivoSubidas/".$archivos;
          copy($ruta, $destino);
          $query_update = mysqli_query($conexion, "UPDATE archivos SET archivos = '$destino'  WHERE idarchivo = $idarchivo");
        }
      }
      $query_update = mysqli_query($conexion, "UPDATE archivos SET nombre = '$nombre'  WHERE idarchivo = $idarchivo");
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

// Validar archivo

if (empty($_REQUEST['id'])) {
  header("Location: listar_archivos.php");
} else {
  $idarchivo = $_REQUEST['id'];
  if (!is_numeric($idarchivo)) {
    header("Location: listar_archivos.php");
  }
  $query_archivo = mysqli_query($conexion, "SELECT nombre, archivos FROM archivos  WHERE idarchivo = $idarchivo");
  $result_archivo = mysqli_num_rows($query_archivo);

  if ($result_archivo > 0) {
    $data_archivo = mysqli_fetch_assoc($query_archivo);
  } else {
    header("Location: lista_productos.php");
  }
}
?>
<link rel="stylesheet" href="css/subidaFoto.css">
<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="row">
    <div class="col-lg-6 m-auto">

      <div class="card">
        <div class="card-header bg-primary text-white">
          MODIFICAR ARCHIVO
        </div>
        <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="form-group">
              <label for="precio">Nombre</label>
              <input type="text" placeholder="Ingrese nombre" class="form-control" name="nombre" id="nombre" value="<?php echo $data_archivo['nombre']; ?>">
            </div>
            <!--imagen-->
               <body>
                 <label for="fecha">Subir Archivo <span class="text-danger fw-bold">*</span></label>
                 <div class="main-container">
                   <div class="input-container">
                     Clic aquí para subir tu Archivo
                     <input type="file" id="archivo" name="archivos"/>
                   </div>
                   <div class="preview-container">
                     <embed src="<?php echo $data_archivo['archivos']; ?>" id="preview">
                   </div>
                 </div>
               </body>
            <!-- finish imagen-->
            <input type="submit" value="Actualizar Producto" class="btn btn-primary">
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</div>
<script type="text/javascript" src="js/subidaFoto.js"></script>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>