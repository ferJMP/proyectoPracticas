<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<link rel="stylesheet" href="css/subidaFoto.css">

<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><i><i style="font-size: 60px" class="fas fa-server mb-8"></i> SERVICIOS</i></h1>
		<a href="registro_servicio.php" class="btn btn-primary">Nuevo Servicio</a>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>SERVICIOS</th>
							<th>PRECIO</th>
							<th>STOCK</th>
							<th>IMAGEN</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
								<th>ACCIONES</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT * FROM producto");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['codproducto']; ?></td>
									<td><?php echo $data['servicio']; ?></td>
									<td><?php echo $data['precio']; ?></td>
									<td><?php echo $data['existencia']; ?></td>
									<td><?php echo '<img  class="lista-img" src="' . $data['imagen'] . '">' ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
										<td>
											<a href="agregar_servicio.php?id=<?php echo $data['codproducto']; ?>" class="btn btn-primary"><i class='fas fa-biohazard'></i></a>

											<a href="editar_servicio.php?id=<?php echo $data['codproducto']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>

											<form action="eliminar_servicio.php?id=<?php echo $data['codproducto']; ?>" method="post" class="confirmar d-inline">
												<button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
											</form>
										</td>
									<?php } ?>
								</tr>
						<?php
							}
						} ?>
					</tbody>

				</table>
			</div>

		</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php include_once "includes/footer.php"; ?>