<?php

    require_once "messages.php";

    $usuario = LimpiarCadena($_POST['usuario']);
    $clave = LimpiarCadena($_POST['clave']);

    if ($usuario == "" || $clave == ""){
        PrintError('No has indicado los campos solicitados');
        exit();
    }

    if(VerificarDatos("[a-zA-Z0-9]{4,20}", $usuario)){
        PrintError("El <strong>Usuario</strong> no coincide con el formato solicitado.");
        exit();
    }
    if(VerificarDatos("[a-zA-Z0-9]{4,20}", $clave)){
        PrintError("La <strong>Clave</strong> no coincide con el formato solicitado.");
        exit();
    }

    $check_user = Conexion();
    $check_user = $check_user->query("SELECT * FROM usuario WHERE usuario = '$usuario'");
    
    if($check_user->rowCount() == 1){
        $check_user = $check_user->fetch();
        if($check_user['usuario'] == $usuario && password_verify($clave, $check_user['clave'])){
            $_SESSION['id'] = $check_user['id'];
            $_SESSION['nombre'] = $check_user['nombre'];
            $_SESSION['usuario'] = $check_user['usuario'];

            if(headers_sent()){
                echo "<script> window.location.href='index.php?view=home';</script>";
            }
            else{
                header("Location: index.php?view=home");
            }
        }
        else{
            PrintError("Clave incorrecta");
        }
    }
    else{
        PrintError("El usuario no existe");
    }

    $check_user = null;

?>