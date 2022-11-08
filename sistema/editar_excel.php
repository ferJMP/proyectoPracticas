<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (($_POST['nombre'] == null) || empty($_FILES['archivoex'])) {
    $alert = '<div class="alert alert-primary" role="alert">
              Todo los campos son requeridos
            </div>';
  } else {
    $idarchivoex = $_GET['id'];
    $nombre = $_POST['nombre'];
    $archivoex = null;
    $ruta_archivoEX = null; //ruta de mi base de datos
    $query = mysqli_query($conexion, "SELECT * FROM archivo_ex WHERE idarchivoex = $idarchivoex");
    $result = mysqli_num_rows($query);
    if ($result > 0) {
      if ($data = mysqli_fetch_assoc($query)) {
        $ruta_archivoEX = $data['archivoex']; //obtengo el archivo -> ruta base de datos
      }
    }
    if ($_FILES['archivoex']['name'] != null) {
      if (unlink($ruta_archivoEX)) { //elimino la ruta de mi base de datos/ proyecto
        $archivoex = $_FILES['archivoex']['name'];
        $rutaEX = $_FILES['archivoex']['tmp_name'];
        $extensionArc = pathinfo($archivoex, PATHINFO_EXTENSION);
        $nuevo_nombre_archivo = date('dmy') . "_" . date('Hs') . "_" . rand(10, 99) . "." . $extensionArc;
        $destinoEX = "archivosExcel/" . $nuevo_nombre_archivo;
        copy($rutaEX, $destinoEX);
        $query_update = mysqli_query($conexion, "UPDATE archivo_ex SET archivoex = '$destinoEX'  WHERE idarchivoex = $idarchivoex");
      }
    }
    $query_update = mysqli_query($conexion, "UPDATE archivo_ex SET nombre = '$nombre'  WHERE idarchivoex = $idarchivoex");
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
  header("Location: listar_excel.php");
} else {
  $idarchivoex = $_REQUEST['id'];
  if (!is_numeric($idarchivoex)) {
    header("Location: listar_excel.php");
  }
  $query_archivo = mysqli_query($conexion, "SELECT nombre, archivoex FROM archivo_ex  WHERE idarchivoex = $idarchivoex");
  $result_archivo = mysqli_num_rows($query_archivo);

  if ($result_archivo > 0) {
    $data_archivo = mysqli_fetch_assoc($query_archivo);
  } else {
    header("Location: listar_excel.php");
  }
}
?>
<link rel="stylesheet" href="css/imagenExcel.css">
<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i><i style="font-size: 60px" class="fas fa-file-excel mb-8"></i> PANEL EDITAR PDF</i></h1>
    <a href="listar_excel.php" class="btn btn-primary">Lista Excel</a>
  </div>

  <div class="row">
    <div class="col-lg-6 m-auto">

      <div class="card">
        <div class="card-header bg-primary text-white">
          MODIFICAR ARCHIVO EXCEL
        </div>
        <form action="" method="post" enctype="multipart/form-data" class="card-body p-2">
          <?php echo isset($alert) ? $alert : ''; ?>
          <div class="form-group">
            <label for="precio">Nombre</label>
            <input type="text" placeholder="Ingrese nombre del archivo" class="form-control" name="nombre" id="nombre" value="<?php echo $data_archivo['nombre']; ?>">
          </div>
          <label for="">Subir Excel <span class="text-danger fw-bold">*</span></label>
          <div class="mb-2">
            <input class='form-control form-control-sm' type="file" name="archivoex" id="" accept=".xlsx, .csv" value="<?php echo $data_archivo['nombre']; ?>">
          </div>
          <input type="submit" value="Actualizar Excel" class="btn btn-primary">
      </div>

      <body>
        <div class="main-container">
          <div class="input-container">
            No se puede mostrar previsualización del Excel</br>
            "Una vez modificado el nombre y seleccionado el Excel,</br>
            haga click en 'Actualizar Excel'"
          </div>
          <div class="preview-container">
            <embed src="img/excel.png" id="preview">
          </div>
        </div>
      </body>
      </form>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</br>
<script type="text/javascript" src="js/subidaFoto.js"></script>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>