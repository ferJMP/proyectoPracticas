<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['razonsocial']) || empty($_POST['telefono']) || empty($_POST['direccion']) || empty($_POST['personacontacto']) || empty($_POST['cargo']) || empty($_POST['area']) || empty($_POST['correo']) || empty($_POST['web'])) {
    $alert = '<div class="alert alert-primary" role="alert">
                      Todos los Campos son Requeridos</div>';
  } else {
    $idcliente = $_POST['id'];
    $ruc = $_POST['ruc'];
    $razonsocial = $_POST['razonsocial'];
    $telefono = $_POST['telefono'];
    $personacontacto = $_POST['personacontacto'];
    $cargo = $_POST['cargo'];
    $area = $_POST['area'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $web = $_POST['web'];

    $result = 0;
    if (is_numeric($ruc) && $ruc != "") {

      $query = mysqli_query($conexion, "SELECT * FROM cliente where (ruc = '$ruc' AND idcliente != $idcliente)");
      $result = mysqli_fetch_array($query);
      $resul = mysqli_num_rows($query);
    }

    if ($resul >= 1) {
      $alert = '<div class="alert alert-primary" role="alert">
                        El Ruc ya existe</div>';
    } else {
      /*if ($ruc == '') {
        $ruc = 0;
      }*/
      $sql_update = mysqli_query($conexion, "UPDATE cliente SET ruc = $ruc, razonsocial = '$razonsocial' , telefono = '$telefono', direccion = '$direccion', personacontacto = '$personacontacto', cargo = '$cargo', area = '$area', correo = '$correo', web = '$web' WHERE idcliente = $idcliente");

      if ($sql_update) {
        $alert = '<div class="alert alert-primary" role="alert">
                            Cliente Actualizado Correctamente</div>';
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
                            Error al Actualizar</div>';
      }
    }
  }
}
//}
// Mostrar Datos

if (empty($_REQUEST['id'])) {
  header("Location: lista_cliente.php");
}
$idcliente = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM cliente WHERE idcliente = $idcliente");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_cliente.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idcliente = $data['idcliente'];
    $ruc = $data['ruc'];
    $razonsocial = $data['razonsocial'];
    $telefono = $data['telefono'];
    $direccion = $data['direccion'];
    $personacontacto = $data['personacontacto'];
    $cargo = $data['cargo'];
    $area = $data['area'];
    $correo = $data['correo'];
    $web = $data['web'];
  }
}
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i>PANEL EDITAR CLIENTE</i></h1>
        <a href="lista_cliente.php" class="btn btn-primary">Lista Clientes</a>
        </div>
          <div class="row">
            <div class="col-lg-6 m-auto">
            <div class="card-header bg-primary text-white">
                EDITAR CLIENTES
            </div>
            <div class="card">
              <form action="" method="post" class="card-body p-2">
                <?php echo isset($alert) ? $alert : ''; ?>
                <input type="hidden" name="id" value="<?php echo $idcliente; ?>">
                <div class="form-group">
                  <label for="ruc">Ruc</label>
                  <input type="number" placeholder="Ingrese Ruc" name="ruc" id="ruc" class="form-control" value="<?php echo $ruc; ?>">
                </div>
                <div class="form-group">
                  <label for="razonsocial">Razon Social</label>
                  <input type="text" placeholder="Ingrese Razon Social" name="razonsocial" class="form-control" id="razonsocial" value="<?php echo $razonsocial; ?>">
                </div>
                <div class="form-group">
                  <label for="telefono">Teléfono</label>
                  <input type="number" placeholder="Ingrese Teléfono" name="telefono" class="form-control" id="telefono" value="<?php echo $telefono; ?>">
                </div>
                <div class="form-group">
                  <label for="direccion">Dirección</label>
                  <input type="text" placeholder="Ingrese Direccion" name="direccion" class="form-control" id="direccion" value="<?php echo $direccion; ?>">
                </div>
                <div class="form-group">
                  <label for="personacontacto">Persona Contacto</label>
                  <input type="text" placeholder="Ingrese la Persona Contacto" name="personacontacto" class="form-control" id="personacontacto" value="<?php echo $personacontacto; ?>">
                </div>
                <div class="form-group">
                  <label for="cargo">Cargo</label>
                  <input type="text" placeholder="Ingrese el Cargo" name="cargo" class="form-control" id="cargo" value="<?php echo $cargo; ?>">
                </div>
                <div class="form-group">
                  <label for="area">Area</label>
                  <input type="text" placeholder="Ingrese el Area" name="area" class="form-control" id="area" value="<?php echo $area; ?>">
                </div>
                <div class="form-group">
                  <label for="email">Correo</label>
                  <input type="text" placeholder="Ingrese Correo" name="correo" class="form-control" id="correo" value="<?php echo $correo; ?>">
                </div>
                <div class="form-group">
                  <label for="web">Web</label>
                  <input type="url" placeholder="Ingrese Web" name="web" class="form-control" id="web" value="<?php echo $web; ?>">
                </div>
                </div>
                </br>
                <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Editar Cliente</button>
              </form>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
        </br> 
      <!-- End of Main Content -->
      <?php include_once "includes/footer.php"; ?>