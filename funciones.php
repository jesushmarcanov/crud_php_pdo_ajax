<?php 
    //Funcion para subir las imagenes a la BD
    function subirImagenes(){
        if (isset($_FILES['imagen_usuario'])) {
            $extension = explode('.', $_FILES['imagen_usuario']['name']);
            $nuevo_nombre = rand() . '.' . $extension[1];
            $ubicacion = './imgs/' . $nuevo_nombre;
            move_uploaded_file($_FILES['imagen_usuario']['tmp_name'], $ubicacion);
            return $nuevo_nombre;
        }
    }

    //Funcion para obtener el nombre de la imagen
    function obtenerNombreUsuaro($id_usuario){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT imagen FROM usuarios WHERE idUsuario = $id_usuario");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach ($resultado as $fila) {
            return $fila['imagen'];
        }
    }
    
    //Funcion para obtener todos los registros
    function obtenerRegistros(){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return $stmt->rowCount();
    }