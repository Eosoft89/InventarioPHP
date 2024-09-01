<?php 
    require_once "main.php";
    require_once "messages.php";

    #almacenando datos

    $nombre = LimpiarCadena($_POST['usuario_nombre']);
    $apellido = LimpiarCadena($_POST['usuario_apellido']);
    $usuario = LimpiarCadena($_POST['usuario_usuario']);
    $email = LimpiarCadena($_POST['usuario_email']);
    $clave1 = $_POST['usuario_clave_1'];
    $clave2 = $_POST['usuario_clave_2'];

    if($nombre =="" || $apellido == "" || $usuario == "" || $clave1 == "" || $clave2 == "" ) {
        
        PrintError("No has llenado los datos que son obligatorios.");
        exit();
    }

    # Verificando integridad de los datos.

    if(VerificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)){
        PrintError("El <strong>Nombre</strong> no coincide con el formato solicitado.");
        exit();
    }
    if(VerificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)){
        PrintError("El <strong>Apellido</strong> no coincide con el formato solicitado.");
        exit();
    }
    if(VerificarDatos("[a-zA-Z0-9]{4,20}", $usuario)){
        PrintError("El <strong>Usuario</strong> no coincide con el formato solicitado.");
        exit();
    }
    if(VerificarDatos("[a-zA-Z0-9]{4,20}", $clave1) || VerificarDatos("[a-zA-Z0-9]{4,20}", $clave2)){
        PrintError("Las <strong>Claves</strong> no coinciden con el formato solicitado.");
        exit();
    }
    if ($clave1 != $clave2){
        PrintError("<strong>Las claves no coinciden.</strong>");
        exit();
    }
    else{
        $clave = password_hash($clave1, PASSWORD_BCRYPT, ["cost"=>10]);
    }

    # Verificando email
    if ($email != ""){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email = Conexion();
            $check_email = $check_email->query("SELECT email FROM usuario WHERE email = '$email'");
            if($check_email->rowCount() > 0){
                PrintError("El <strong>Email</strong> ya se encuentra registrado.");
            }
        }
        else{
            PrintError("El <strong>Email</strong> no es válido.");
            exit();
        }
    }

    # Verificar usuario
    $check_usario = Conexion();
    $check_usario = $check_usario->query("SELECT usuario FROM usuario WHERE usuario = '$usuario'");
    if($check_usario->rowCount() > 0){
        PrintError("El <strong>Usuario</strong> ya se encuentra registrado.");
        exit();
    }
    $check_usario = null;

    # Guardando datos

    $guardar_usuario = Conexion();
    $guardar_usuario = $guardar_usuario->prepare(
        "INSERT INTO usuario (nombre, apellido, usuario, clave, email) 
        VALUES (:nombre, :apellido, :usuario, :clave, :email)");

    $marcadores = [
        ":nombre" => $nombre,
        ":apellido" => $apellido,
        ":usuario" => $usuario,
        ":clave" => $clave,
        ":email" => $email
    ];
    $guardar_usuario->execute($marcadores);

    if($guardar_usuario->rowCount() == 1){
        echo('<article class="message is-success">
                <div class="message-header">
                    <p>Éxito</p>
                </div>
                <div class="message-body">
                    <strong>El usuario fue registrado exitosamente</strong>
                </div>
            </article>');
    }else{
        PrintError("El <strong>Usuario</strong> no pudo ser registrado.");
    }
    $guardar_usuario = null;

?>