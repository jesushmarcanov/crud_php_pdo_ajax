<?php 
    include('conexion.php');
    include('funciones.php');


    if (isset($_POST['id_usuario'])) {
        $imagen =  obtenerNombreImagen($_POST['id_usuario']);
        if($imagen != ''){
            unlink("imgs/" . $imagen);
        }
        
        $stmt = $conexion->prepare("DELETE FROM usuarios WHERE idUsuario=:id_usuario");
        $resultado = $stmt->execute(
            array(
                ':id_usuario'   => $_POST['id_usuario']
            )
        );
        if(!empty($resultado)){
            echo 'Registro Borrado';
        }
    }
