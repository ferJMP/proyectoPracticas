<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['servicio']) || empty($_POST['precio']) || empty($_FILES['imagen'])) {
    $alert = '<div class="alert alert-primary" role="alert">
              Todo los campos son requeridos
            </div>';
  } else {
    $codproducto = $_GET['id'];
    $proveedor = $_POST['proveedor'];
    $servicio = $_POST['servicio'];
    $precio = $_POST['precio'];
    $imagen=null;
    if($_FILES['imagen']['name']!=null){
        $imagen = $_FILES['imagen']['name'];
        $ruta = $_FILES['imagen']['tmp_name'];
        $destino = "imagenSubidas/".$imagen;
        copy($ruta, $destino);
        $query_update = mysqli_query($conexion, "UPDATE producto SET imagen='$destino' WHERE codproducto = $codproducto");
    }

    $query_update = mysqli_query($conexion, "UPDATE producto SET servicio = '$servicio', codproveedor= $proveedor,precio= $precio WHERE codproducto = $codproducto");
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

// Validar producto

if (empty($_REQUEST['id'])) {
  header("Location: lista_productos.php");
} else {
  $id_producto = $_REQUEST['id'];
  if (!is_numeric($id_producto)) {
    header("Location: lista_productos.php");
  }
  $query_producto = mysqli_query($conexion, "SELECT p.codproducto, p.servicio, p.precio, p.imagen, pr.codproveedor, pr.proveedor 
  FROM producto p INNER JOIN proveedor pr ON p.codproveedor = pr.codproveedor WHERE p.codproducto = $id_producto");
  $result_producto = mysqli_num_rows($query_producto);

  if ($result_producto > 0) {
    $data_producto = mysqli_fetch_assoc($query_producto);
  } else {
    header("Location: lista_productos.php");
  }
}
?>
<link rel="stylesheet" href="css/subidaFoto.css">
<!-- Begin Page Content -->
<div class="container-fluid">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">PANEL EDITAR SERVICIO</h1>
        <a href="lista_servicio.php" class="btn btn-primary">Lista Servicios</a>
      </div>

  <div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card-header bg-primary text-white">
          MODIFICAR SERVICIO
        </div>
        <div class="card">
        <form action="" method="post" enctype="multipart/form-data" class="card-body p-2">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="form-group">
              <label for="nombre">Proveedor</label>
              <?php $query_proveedor = mysqli_query($conexion, "SELECT * FROM proveedor ORDER BY proveedor ASC");
              $resultado_proveedor = mysqli_num_rows($query_proveedor);
              mysqli_close($conexion);
              ?>
              <select id="proveedor" name="proveedor" class="form-control">
                <?php
                if ($resultado_proveedor > 0) {
                  while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                    // code...
                ?>
                    <option <?php if ($data_producto['codproveedor'] == $proveedor['codproveedor']){echo "selected";} ?> value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
                <?php
                  }
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="servicio">Servicio</label>
              <input type="text" class="form-control" placeholder="Ingrese nombre del servicio" name="servicio" id="servicio" value="<?php echo $data_producto['servicio']; ?>">
            </div>
            <div class="form-group">
              <label for="precio">Precio</label>
              <input type="text" placeholder="Ingrese precio" class="form-control" name="precio" id="precio" value="<?php echo $data_producto['precio']; ?>">
            </div>
            <!--imagen-->
               <body>
                 <label for="fecha">Subir Imagen <span class="text-danger fw-bold">*</span></label>
                 </div>
                 <div class="main-container">
                   <div class="input-container">
                     Clic aquí para subir tu imagen
                     <input type="file" id="archivo" name="imagen" />
                   </div>
                   <div class="preview-container">
                     <img src="<?php echo $data_producto['imagen']; ?>" id="preview">
                   </div>
                 </div>
               </body>
            <!-- finish imagen-->
            <input type="submit" value="Actualizar Producto" class="btn btn-primary">
        </form>
        </div>
      </div>
</div>
<!-- /.container-fluid -->
</br> 
<script type="text/javascript" src="js/subidaFoto.js"></script>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>