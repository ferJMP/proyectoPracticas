<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if ($_POST['nombre']==null || $_FILES['archivos']['tmp_name']==null) {
        $alert = '<div class="alert alert-danger" role="alert">
                                    Todo los campos son obligatorios
                                </div>';
    } else {
        $nombre = $_POST['nombre'];
        $archivos = $_FILES['archivos']['name'];
        /*$usuario_id = $_SESSION['idUser'];*/
        $rutaarchivos = $_FILES['archivos']['tmp_name'];
        $destinoX = "archivoSubidas/".$archivos;
        copy($rutaarchivos, $destinoX);

            $query_insert = mysqli_query($conexion, "INSERT INTO archivos(nombre,archivos) values ('$nombre', '$destinoX')");
            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                                    Archivo Registrado
                                </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                                    Error al Guardar
                            </div>';
            }
    }
}
?>

<link rel="stylesheet" href="css/subidaArchivo.css">
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">PANEL ARCHIVOS</h1>
  <a href="listar_archivos.php" class="btn btn-primary">Regresar</a>
</div>

<!-- Content Row -->
<div class="row">
  <div class="col-lg-6 m-auto">
    <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
      <?php echo isset($alert) ? $alert : ''; ?>
      <div class="form-group">
        <label for="">Nombre</label>
        <input type="text" placeholder="Ingrese nombre del archivo" name="nombre" id="nombre" class="form-control">
      </div>
      <!--archivo-->
         <body>
           <label for="fecha">Subir Archivo <span class="text-danger fw-bold">*</span></label>
           <div class="main-container">
           <div class="input-container">
                     Clic aquí para subir tu Archivo
                     <input type="file" id="archivo" name="archivos" accept=".pdf, .xlsx, .csv" />
                   </div>
                   <div class="preview-container">
                     <embed src="img/archivo.png" id="preview">
                   </div>
           </div>
         </body>
          <!--finish archivo-->
          <input type="submit" value="Guardar Archivo" class="btn btn-primary">
    </form>
  </div>
</div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<script type="text/javascript" src="js/subidaFoto.js"></script>
<?php include_once "includes/footer.php"; ?>


