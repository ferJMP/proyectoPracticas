 <?php include_once "includes/header.php";
  include "../conexion.php";
  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['proveedor']) || empty($_POST['producto']) || empty($_POST['precio']) || $_POST['precio'] <  0 || empty($_POST['cantidad'] || $_POST['cantidad'] <  0) || empty($_FILES['imagen'])) {
      $alert = '<div class="alert alert-danger" role="alert">
                Todo los campos son obligatorios
              </div>';
    } else {
      $proveedor = $_POST['proveedor'];
      $producto = $_POST['producto'];
      $precio = $_POST['precio'];
      $cantidad = $_POST['cantidad'];
      $usuario_id = $_SESSION['idUser'];

      $imagen = $_FILES['imagen']['name'];
      $ruta = $_FILES['imagen']['tmp_name'];
      $destino = "imagenSubidas/".$imagen;
      copy($ruta, $destino);
  
      $query_insert = mysqli_query($conexion, "INSERT INTO producto(proveedor,descripcion,precio,existencia,usuario_id,imagen) values ('$proveedor', '$producto', '$precio', '$cantidad','$usuario_id','$destino')");
      if ($query_insert) {
        $alert = '<div class="alert alert-primary" role="alert">
                Producto Registrado
              </div>';
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
                Error al registrar el producto
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
     <h1 class="h3 mb-0 text-gray-800">PANEL REGISTRO PRODUCTOS</h1>
     <a href="lista_productos.php" class="btn btn-primary">Regresar</a>
   </div>

   <!-- Content Row -->
   <div class="row">
     <div class="col-lg-6 m-auto">
       <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
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
           <label for="producto">PRODUCTO</label>
           <input type="text" placeholder="Ingrese nombre del producto" name="producto" id="producto" class="form-control">
         </div>
         <div class="form-group">
           <label for="precio">Precio</label>
           <input type="text" placeholder="Ingrese precio" class="form-control" name="precio" id="precio">
         </div>
         <div class="form-group">
           <label for="cantidad">Cantidad</label>
           <input type="number" placeholder="Ingrese cantidad" class="form-control" name="cantidad" id="cantidad">
         </div>
         <!--imagen-->
         <body>
           <label for="fecha">Subir Imagen <span class="text-danger fw-bold">*</span></label>
           <div class="main-container">
             <div class="input-container">
               Clic aquí para subir tu imagen
               <input type="file" id="archivo" name="imagen" accept=".jpg, .png"/>
             </div>
             <div class="preview-container">
               <img src="img/subirimagen.png" id="preview">
             </div>
           </div>
         </body>
         <!-- finish imagen-->

         <input type="submit" value="Guardar Producto" class="btn btn-primary">
       </form>
     </div>
   </div>
 </div>
 <!-- /.container-fluid -->
 </div>
 <script type="text/javascript" src="js/subidaFoto.js"></script>
 <!-- End of Main Content -->
 <?php include_once "includes/footer.php"; ?>