<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">ARCHIVOS</h1>
		<a href="registrarArchivo.php" class="btn btn-primary">Nuevo</a>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>NOMBRE</th>
							<th>ARCHIVOS</th>
							<th>DESCARGA</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php 
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT * FROM archivos");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { 
								$rutadescarga = $data['archivos'];
								?>
								<tr>
									<td><?php echo $data['idarchivo']; ?></td>
									<td><?php echo $data['nombre']; ?></td>
                                    <?php if ($_SESSION['rol'] == 1) { ?>
									<td><?php echo '<embed src="'.$data['archivos'].'">' ?></td>
									<td>
									<a href="<?php echo $rutadescarga; ?>" download="<?php echo "descarga"; ?>" class="btn btn-success btn-sm">
								    <span class="fas fa-download"></span>
								    </a>
									</td>

									<td>
									    <a href="editar_archivo.php?id=<?php echo $data['idarchivo']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>

										<form action="eliminar_archivos.php?id=<?php echo $data['idarchivo']; ?>" method="post" class="confirmar d-inline">
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
