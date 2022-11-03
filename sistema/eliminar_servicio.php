<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $codproducto = $_GET['id'];
    $ruta_imagen=null;
    $query = mysqli_query($conexion, "SELECT * FROM producto WHERE codproducto = $codproducto");
    $result = mysqli_num_rows($query);
    if ($result > 0) {
        if($data = mysqli_fetch_assoc($query)){
        $ruta_imagen=$data['imagen'];  
        }
        if($ruta_imagen!=null){
            $query_delete = mysqli_query($conexion, "DELETE FROM producto WHERE codproducto = $codproducto");
            if(unlink($ruta_imagen)) {
            mysqli_close($conexion);
            header("location: lista_servicio.php");
            // file was successfully deleted
            }else{
            echo 'error';
            }
        }
    }
}
?>