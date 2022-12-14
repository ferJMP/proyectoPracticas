 <?php include_once "includes/header.php";
  include "../conexion.php";
  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['proveedor']) || empty($_POST['servicio']) || empty($_POST['precio']) || $_POST['precio'] <  0 || empty($_POST['cantidad'] || $_POST['cantidad'] <  0) || $_FILES['imagen']['tmp_name'] == null) {
      $alert = '<div class="alert alert-danger" role="alert">
                Todo los campos son obligatorios
              </div>';
    } else {
      $proveedor = $_POST['proveedor'];
      $servicio = $_POST['servicio'];
      $precio = $_POST['precio'];
      $cantidad = $_POST['cantidad'];
      $usuario_id = $_SESSION['idUser'];

      $imagen = $_FILES['imagen']['name'];
      $ruta = $_FILES['imagen']['tmp_name'];
      $extensionArc = pathinfo($imagen, PATHINFO_EXTENSION); //obtener formato de la imagen .png, .jpg
      $nuevo_nombre_archivo = date('dmy') . "_" . date('Hs') . "_" . rand(10, 99) . "." . $extensionArc; //nombre imagen..., concatena la estensión
      $destino = "imagenSubidas/" . $nuevo_nombre_archivo;
      copy($ruta, $destino);

      $query_insert = mysqli_query($conexion, "INSERT INTO producto(codproveedor,servicio,precio,existencia,usuario_id,imagen) values ('$proveedor', '$servicio', '$precio', '$cantidad','$usuario_id','$destino')");
      if ($query_insert) {
        $alert = '<div class="alert alert-primary" role="alert">
                Servicio Registrado
              </div>';
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
                Error al registrar el servicio
              </div>';
      }
    }
  }
  ?>

 <link rel="stylesheet" href="css/subidaFoto.css">

 <!-- Begin Page Content -->
 <div class="container-fluid">

   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800"><i><i style="font-size: 60px" class="fas fa-server mb-8"></i> REGISTRO SERVICIOS</i></h1>
     <a href="lista_servicio.php" class="btn btn-primary">Lista Servicios</a>
   </div>

   <!-- Content Row -->
   <div class="row">
     <div class="col-lg-6 m-auto">
       <div class="card-header bg-primary text-white">
         REGISTRO SERVICIO
       </div>
       <div class="card">
         <form action="" method="post" autocomplete="off" enctype="multipart/form-data" class="card-body p-2">
           <?php echo isset($alert) ? $alert : ''; ?>
           <div class="form-group">
             <label>Proveedor</label>
             <?php
              $query_proveedor = mysqli_query($conexion, "SELECT codproveedor, proveedor FROM proveedor ORDER BY proveedor ASC");
              $resultado_proveedor = mysqli_num_rows($query_proveedor);
              mysqli_close($conexion);
              ?>
             <select id="proveedor" name="proveedor" class="form-control">
               <?php
                if ($resultado_proveedor > 0) {
                  while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                    // code...
                ?>
                   <option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
               <?php
                  }
                }
                ?>
             </select>
           </div>
           <div class="form-group">
             <label for="servicio">Servicio</label>
             <input type="text" placeholder="Ingrese nombre del servicio" name="servicio" id="servicio" class="form-control">
           </div>
           <div class="form-group">
             <label for="precio">Precio del Servicio</label>
             <input type="text" placeholder="Ingrese precio" class="form-control" name="precio" id="precio">
           </div>
           <div class="form-group">
             <label for="cantidad">Cantidad del Servicio</label>
             <input type="number" placeholder="Ingrese cantidad" class="form-control" name="cantidad" id="cantidad">
           </div>

           <!--imagen-->

           <body>
             <label for="fecha">Subir Imagen del Servicio <span class="text-danger fw-bold">*</span></label>
             <div class="mb-2">
               <input class='form-control form-control-sm' type="file" name="imagen" id="archivo" accept="jpg, .png">
             </div>
       </div>
       <div class="main-container">
         <div class="input-container">
           Aquí se muestra previsualización de la imagen
           <text type="text" id="" name="" accept="" />
         </div>
         <div class="preview-container">
           <img src="img/subirimagen.png" id="preview">
         </div>
       </div>
       </body>
       <!-- finish imagen-->
       <input type="submit" value="Guardar Servicio" class="btn btn-primary">
       </form>
     </div>
   </div>
 </div>
 <!-- /.container-fluid -->
 </br>
 <script type="text/javascript" src="js/subidaFoto.js"></script>
 <!-- End of Main Content -->
 <?php include_once "includes/footer.php"; ?>