<?php

use Dotenv\Dotenv;

    require("./vendor/autoload.php");
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    require_once "./layout/sessionStart.php"; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "./layout/head.php"; ?>
</head>
<body>
   <?php

        if (!isset($_GET['view']) || $_GET['view'] == "") {
            $_GET['view'] = "login";
        }

        if (is_file("./views/".$_GET['view'].".php") && $_GET['view'] != "login" && $_GET['view'] != "notFound") {
            
            #Cerrar sesión forzada para no logueados
            if(!isset($_SESSION['id']) || $_SESSION['id'] == ""){
                include "./views/logout.php";     
                exit();
            }

            include "./layout/navbar.php";
            include "./views/" . $_GET['view'] . ".php";
            include "./layout/script.php";
        }
        else {
            if ($_GET['view'] == "login"){
                include "./views/login.php";   
            }
            else{
                include "./views/notFound.php";
            }  
        }
        
   ?>
</body>
</html>