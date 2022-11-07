<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['id_rol']) || $_POST['nombre']==null || $_FILES['archivoex']['tmp_name']==null) {
        $alert = '<div class="alert alert-danger" role="alert">
                                    Todo los campos son obligatorios
                                </div>';
    } else {
        $id_rol = $_POST['id_rol'];
        $nombre = $_POST['nombre'];
        $archivoex = $_FILES['archivoex']['name'];
        /*$usuario_id = $_SESSION['idUser'];*/
        $rutaarchivoex = $_FILES['archivoex']['tmp_name'];
        $extensionArc = pathinfo($archivoex, PATHINFO_EXTENSION); //obtener formato del archivo .xlsx
        $nuevo_nombre_archivo=date('dmy')."_".date('Hs')."_".rand(10, 99).".".$extensionArc; //nombre archivo..., concatena la estensión
        $destinoEX = "archivosExcel/".$nuevo_nombre_archivo;//se guarda en la BD
        copy($rutaarchivoex, $destinoEX);

            $query_insert = mysqli_query($conexion, "INSERT INTO archivo_ex(idrol,nombre,archivoex) values ('$id_rol', '$nombre', '$destinoEX')");
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

<link rel="stylesheet" href="css/imagenExcel.css">
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800"><i><i style="font-size: 60px" class="fas fa-file-excel mb-8"></i> PANEL ARCHIVOS EXCEL</i></h1>
  <a href="listar_excel.php" class="btn btn-primary">Lista Excel</a>
</div>

<!-- Content Row -->
<div class="row">
  <div class="col-lg-6 m-auto">
            <div class="card-header bg-primary text-white">
                REGISTRAR EXCEL
            </div>
   <div class="card">
    <form action="" method="post" autocomplete="off" enctype="multipart/form-data" class="card-body p-2">
      <?php echo isset($alert) ? $alert : ''; ?>
      <div class="form-group">
        <!--roles-->
        <label>Asignador</label>
           <?php
            $query_archivoexcel = mysqli_query($conexion, "SELECT idrol, rol FROM rol ORDER BY rol ASC");
            $resultado_excel = mysqli_num_rows($query_archivoexcel);
            mysqli_close($conexion);
            ?>
           <select id="id_rol" name="id_rol" class="form-control">
             <?php
              if ($resultado_excel > 0) {
                while ($excelArchico = mysqli_fetch_array($query_archivoexcel)) {
                  // code...
              ?>
                 <option value="<?php echo $excelArchico['idrol']; ?>"><?php echo $excelArchico['rol']; ?></option>
             <?php
                }
              }
              ?>
           </select></br>
        <!--roles finish-->
        <label for="">Nombre</label>
        <input type="text" placeholder="Ingrese nombre del archivo" name="nombre" id="nombre" class="form-control">
      </div>
         <label for="">Subir Excel <span class="text-danger fw-bold">*</span></label>
                         <div class="mb-2">
                            <input class='form-control form-control-sm' type="file" name="archivoex" id="archivo" accept=".xlsx, .csv"/>
                         </div>
                         <input type="submit" value="Guardar Excel" class="btn btn-primary">
    </div> 
        <body>
          <div class="main-container">
          <div class="input-container">
                   No se puede mostrar previsualización del Excel</br>
                    "Una vez escrito el nombre y seleccionado el Excel,</br> 
                    haga click en 'Guardar Excel'"
                  </div>
                  <div class="preview-container">
                    <embed src="img/excel.png" id="preview">
                  </div>
          </div>
        </body>
    </div>
    </form>
  </div>
</div>
<!-- /.container-fluid -->
</br>
<!-- End of Main Content -->
<script type="text/javascript" src="js/imagenExcel.js"></script>
<?php include_once "includes/footer.php"; ?>


