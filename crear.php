<?php 
    include('conexion.php');
    include('funciones.php');

    if ($_POST['operacion'] == "Crear") {
        $imagen = '';
        if($_FILES['imagen_usuario']['name'] != ''){
            $imagen = subirImagenes();
        }

        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, apellidos, imagen, telefono, email) VALUES (:nombre, :apellidos, :imagen, :telefono, :email)");
        $resultado = $stmt->execute(
            array(
                ':nombre'    => $_POST["nombre"],
                ':apellidos' => $_POST["apellidos"],
                ':telefono'  => $_POST["telefono"],
                ':email'     => $_POST["email"],
                ':imagen'    => $imagen
            )
        );
        if(!empty($resultado)){
            echo 'Registro Creado';
        }
    }

    if ($_POST['operacion'] == "Editar") {
        $imagen = '';
        if($_FILES['imagen_usuario']['name'] != ''){
            $imagen = subirImagenes();
        }else{
            $imagen = $_POST['img_usr_oculta'];
        }

        $stmt = $conexion->prepare("UPDATE usuarios SET nombre=:nombre, apellidos=:apellidos, imagen=:imagen, telefono=:telefono, email=:email WHERE idUsuario=:id_usuario");
        $resultado = $stmt->execute(
            array(
                ':nombre'       => $_POST['nombre'],
                ':apellidos'    => $_POST['apellidos'],
                ':telefono'     => $_POST['telefono'],
                ':email'        => $_POST['email'],
                ':imagen'       => $imagen,
                ':id_usuario'   => $_POST['id_usuario']
            )
        );
        if(!empty($resultado)){
            echo 'Registro Actualizado';
        }
    }