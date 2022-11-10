<?php
$alert = '';
session_start();
if (!empty($_SESSION['active'])) {
  header('location: sistema/');
} else {
  if (!empty($_POST)) {
    if (empty($_POST['usuario']) || empty($_POST['clave'])) {
      $alert = '<div class="alert alert-danger" role="alert">
  Ingrese su usuario y su clave
</div>';
    } else {
      require_once "conexion.php";
      $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
      $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave']));
      $query = mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo,u.usuario,r.idrol,r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.usuario = '$user' AND u.clave = '$clave'");
      mysqli_close($conexion);
      $resultado = mysqli_num_rows($query);
      if ($resultado > 0) {
        $dato = mysqli_fetch_array($query);
        $_SESSION['active'] = true;
        $_SESSION['idUser'] = $dato['idusuario'];
        $_SESSION['nombre'] = $dato['nombre'];
        $_SESSION['email'] = $dato['correo'];
        $_SESSION['user'] = $dato['usuario'];
        $_SESSION['rol'] = $dato['idrol'];
        $_SESSION['rol_name'] = $dato['rol'];
        header('location: sistema/');
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
              Usuario o Contraseña Incorrecta
            </div>';
        session_destroy();
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" href="sistema/css/loaderIndex.css">
<head>
	<title>Login/CIC</title>
	<link rel="stylesheet" type="text/css" href="sistema/login/estilo/main.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <!--<link rel="stylesheet" href="sistema/css/style.css">-->
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="lds-ring loaderR" id="loaderR"><div></div><div></div><div></div><div></div></div>
</body>
<body>    
	<img class="wave" src="sistema/login/img/wave2.png">
	<div class="container">
		<div class="img">
			<img src="sistema/login/img/siste.svg">
		</div>
		<div class="login-content">
			<form method="POST">
			 <?php echo isset($alert) ? $alert : ""; ?>>
				<img src="sistema/login/img/avatar2.svg">
        <img src="sistema/login/img/avatar3.jpg">
				<h2 class="title">Bienvenido</h2>
           		<div class="input-div one">
           		   <div class="i" >
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Usuario</h5>
           		   		<input type="text" name="usuario"  id="usuario" class="input">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Contraseña</h5>
           		    	<input type="password" class="input"  name="clave">
            	   </div>
            	</div>
            	<input type="submit" class="btn" value="Iniciar">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="sistema/login/js/main.js"></script>
    <script type="text/javascript" src="sistema/js/loaderIndex.js"></script>
</body>
</html>
