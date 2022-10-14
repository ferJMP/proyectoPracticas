<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $idnota = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM notas WHERE idnota = $idnota");
    mysqli_close($conexion);
    header("location: listar_notas.php");
}
?>