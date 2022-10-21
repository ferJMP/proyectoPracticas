<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $id = $_GET['id'];
    $ruta_archivoEX=null;
    $query = mysqli_query($conexion, "SELECT * FROM archivo_ex WHERE idarchivoex = $id");
	$result = mysqli_num_rows($query);
	    if ($result > 0) {
			if($data = mysqli_fetch_assoc($query)){
            $ruta_archivoEX=$data['archivoex'];  
            }
            if($ruta_archivoEX!=null){
                $query_delete = mysqli_query($conexion, "DELETE FROM archivo_ex WHERE idarchivoex = $id");
                if(unlink($ruta_archivoEX)) {
                mysqli_close($conexion);
                header("location: listar_excel.php");
                // file was successfully deleted
                }else{
                echo 'error';
                }
            }
        }
}
?>