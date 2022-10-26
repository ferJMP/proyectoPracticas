<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['razonsocial']) || empty($_POST['telefono']) || empty($_POST['direccion']) || empty($_POST['personacontacto']) || empty($_POST['cargo']) || empty($_POST['area']) || empty($_POST['correo']) || empty($_POST['web'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                                    Todo los campos son obligatorio
                                </div>';
    } else {
        $ruc = $_POST['ruc'];
        $razonsocial = $_POST['razonsocial'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $personacontacto = $_POST['personacontacto'];
        $cargo = $_POST['cargo'];
        $area = $_POST['area'];
        $correo = $_POST['correo'];
        $web = $_POST['web'];
        $usuario_id = $_SESSION['idUser'];

        $result = 0;
        if (is_numeric($ruc) and $ruc != 0) {
            $query = mysqli_query($conexion, "SELECT * FROM cliente where ruc = '$ruc'");
            $result = mysqli_fetch_array($query);
        }
        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                                    El ruc ya existe
                                </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO cliente(ruc,razonsocial,telefono,direccion,personacontacto,cargo,area,correo,web,usuario_id) values ('$ruc', '$razonsocial', '$telefono', '$direccion', '$personacontacto', '$cargo', '$area', '$correo', '$web', '$usuario_id')");
            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                                    Cliente Registrado
                                </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                                    Error al Guardar
                            </div>';
            }
        }
    }
    mysqli_close($conexion);
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">PANEL REGISTRO CLIENTE</h1>
        <a href="lista_cliente.php" class="btn btn-primary">Regresar</a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <form action="" method="post" autocomplete="off">
                <?php echo isset($alert) ? $alert : ''; ?>
                <div class="form-group">
                    <label for="ruc">Ruc</label>
                    <input type="number" placeholder="Ingrese ruc" name="ruc" id="ruc" class="form-control">
                </div>
                <div class="form-group">
                    <label for="razonsocial">Razon Social</label>
                    <input type="text" placeholder="Ingrese Razon Social" name="razonsocial" id="razonsocial" class="form-control">
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="number" placeholder="Ingrese Teléfono" name="telefono" id="telefono" class="form-control">
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" placeholder="Ingrese Direccion" name="direccion" id="direccion" class="form-control">
                </div>
                <div class="form-group">
                    <label for="personacontacto">Persona Contacto</label>
                    <input type="text" placeholder="Ingrese la Persona Contacto" name="personacontacto" id="personacontacto" class="form-control">
                </div>
                <div class="form-group">
                    <label for="cargo">Cargo</label>
                    <input type="text" placeholder="Ingrese el Cargo" name="cargo" id="cargo" class="form-control">
                </div>
                <div class="form-group">
                    <label for="area">Area</label>
                    <input type="text" placeholder="Ingrese el Area" name="area" id="area" class="form-control">
                </div>
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" placeholder="Ingrese Correo" pattern=".+\.com" name="correo" id="correo" class="form-control">
                </div>
                <div class="form-group">
                    <label for="web">Web</label>
                    <input type="url" placeholder="Ingrese link de la pagina Web" name="web" id="web" class="form-control">
                </div>  
                <input type="submit" value="Guardar Cliente" class="btn btn-primary">
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>