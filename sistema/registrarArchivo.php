<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['id_rol']) || empty($_POST['nombre']) || empty($_FILES['archivos']['tmp_name'])) {
    $alert = '<div class="alert alert-danger" role="alert">
                                    Todo los campos son obligatorios
                                </div>';
  } else {
    $id_rol = $_POST['id_rol'];
    $nombre = $_POST['nombre'];
    $archivos = $_FILES['archivos']['name'];
    /*$usuario_id = $_SESSION['idUser'];*/
    $rutaarchivos = $_FILES['archivos']['tmp_name'];
    $extensionArc = pathinfo($archivos, PATHINFO_EXTENSION); //obtener formato del archivo .pdf
    $nuevo_nombre_archivo = date('dmy') . "_" . date('Hs') . "_" . rand(10, 99) . "." . $extensionArc; //nombre archivo..., concatena la estensión $extensionArc
    $destinoX = "archivoSubidas/" . $nuevo_nombre_archivo; //se guarda en la BD
    copy($rutaarchivos, $destinoX);

    $query_insert = mysqli_query($conexion, "INSERT INTO archivos(idrol,nombre,archivos) values ('$id_rol','$nombre', '$destinoX')");
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
    <h1 class="h3 mb-0 text-gray-800"><i><i style="font-size: 60px" class="fas fa-file-pdf mb-8"></i> PANEL ARCHIVOS PDF</i></h1>
    <a href="listar_archivos.php" class="btn btn-primary">Lista PDF</a>
  </div>

  <!--ventana flotante-->
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
    Nota Importante
  </button>
  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">"Para subir el pdf"</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Es posible que no se previsualicen algunos archivos, solo es necesario:
          Escribir el nombre y seleccionar el PDF, luego
          haga click en "Guardar PDF", el registro se mostrará en "Lista PDF"
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  </br>
  </br>
  <!--termina vetana flotante-->
  <!-- Content Row -->
  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card-header bg-primary text-white">
        REGISTRAR PDF
      </div>
      <div class="card">
        <form action="" method="post" autocomplete="off" enctype="multipart/form-data" class="card-body p-2">
          <?php echo isset($alert) ? $alert : ''; ?>
          <div class="form-group">
            <!--roles-->
            <label>Asignador</label>
            <?php
            $query_archivopdf = mysqli_query($conexion, "SELECT idrol, rol FROM rol ORDER BY rol ASC");
            $resultado_pdf = mysqli_num_rows($query_archivopdf);
            mysqli_close($conexion);
            ?>
            <select id="id_rol" name="id_rol" class="form-control">
              <?php
              if ($resultado_pdf > 0) {
                while ($pdfArchico = mysqli_fetch_array($query_archivopdf)) {
                  // code...
              ?>
                  <option value="<?php echo $pdfArchico['idrol']; ?>"><?php echo $pdfArchico['rol']; ?></option>
              <?php
                }
              }
              ?>
            </select></br>
            <!--roles finish-->
            <label for="">Nombre</label>
            <input type="text" placeholder="Ingrese nombre del archivo" name="nombre" id="nombre" class="form-control">
          </div>
          <!--archivo-->

          <body>
            <label for="">Subir Archivo <span class="text-danger fw-bold">*</span></label>
            <div class="mb-2">
              <input class='form-control form-control-sm' type="file" name="archivos" id="archivo" accept=".pdf">
            </div>
            <input type="submit" value="Guardar PDF" class="btn btn-primary">
      </div>
      <div class="main-container">
        <div class="input-container">
          "Aquí se previsualiza el documento PDF"
        </div>
      </div>
      </body>
      <!--finish archivo-->
      </form>
    </div>
  </div>
  <iframe class='w-100' height='600' frameborder='0' id="preview"></iframe>
</div>
<!-- /.container-fluid -->
</br>
<!-- End of Main Content -->
<script type="text/javascript" src="js/subidaFoto.js"></script>
<?php include_once "includes/footer.php"; ?>