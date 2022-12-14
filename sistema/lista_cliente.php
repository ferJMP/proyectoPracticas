<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><i><i style="font-size: 60px" class="fas fa-users mb-8"></i> CLIENTES</i></h1>
		<a href="registro_cliente.php" class="btn btn-primary">Nuevo Cliente</a>
	</div>

	<div class="row">
		<div class="col-lg-12">

			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>RUC</th>
							<th>RAZON</th>
							<th>TELEFONO</th>
							<th>DIRECCIÓN</th>
							<th>CONTACTO</th>
							<th>CARGO</th>
							<th>AREA</th>
							<th>CORREO</th>
							<th>WEB</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
								<th>ACCIONES</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT * FROM cliente");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['idcliente']; ?></td>
									<td><?php echo $data['ruc']; ?></td>
									<td><?php echo $data['razonsocial']; ?></td>
									<td><?php echo $data['telefono']; ?></td>
									<td><?php echo $data['direccion']; ?></td>
									<td><?php echo $data['personacontacto']; ?></td>
									<td><?php echo $data['cargo']; ?></td>
									<td><?php echo $data['area']; ?></td>
									<td><?php echo $data['correo']; ?></td>
									<td><?php echo $data['web']; ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
										<td>
											<a href="editar_cliente.php?id=<?php echo $data['idcliente']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
											<form action="eliminar_cliente.php?id=<?php echo $data['idcliente']; ?>" method="post" class="confirmar d-inline">
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