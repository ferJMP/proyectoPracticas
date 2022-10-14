<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $id = $_GET['id'];
    $ruta_archivo=null;
    $query = mysqli_query($conexion, "SELECT * FROM archivos WHERE idarchivo = $id");
	$result = mysqli_num_rows($query);
	    if ($result > 0) {
			if($data = mysqli_fetch_assoc($query)){
            $ruta_archivo=$data['archivos'];  
            }
            if($ruta_archivo!=null){
                $query_delete = mysqli_query($conexion, "DELETE FROM archivos WHERE idarchivo = $id");
                if(unlink($ruta_archivo)) {
                mysqli_close($conexion);
                header("location: listar_archivos.php");
                // file was successfully deleted
                }else{
                echo 'error';
                }
            }
        }
}
?>