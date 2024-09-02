<?php
    require_once "messages.php";
    $search_module = LimpiarCadena($_POST['search_module']);

    echo $search_module;
    
    $modules = ["user", "category", "product"];

    if(in_array($search_module, $modules))
    {
        $modules_url = [
            "user" => "user_search",
            "category" => "category_search",
            "product" => "product_search"
        ];

        $modules_url=$modules_url[$search_module];

        $search_module = "search_" . $search_module;

        // Iniciar búsqueda
        if(isset($_POST['search_string'])){
            $txt = LimpiarCadena($_POST['search_string']);

            if($txt == "") {
                PrintError('Introduce un término de búsqueda');
            }
            else{
                if(VerificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}", $txt)){
                    PrintError('Búsqueda con formato incorrecto');
                }
                else{
                    $_SESSION[$search_module] = $txt;
            
                    if(headers_sent()){
                        echo "<script> window.location.href='index.php?view=$modules_url';</script>";
                    }
                    else{
                        header("Location: index.php?view=$modules_url", true, 303);
                    }
                    exit();
                }
            }
        }

        //Eliminar búsqueda
        if(isset($_POST['destroy_search'])){
            unset( $_SESSION[$search_module]);
            if(headers_sent()){
                echo "<script> window.location.href='index.php?view=$modules_url';</script>";
            }
            else{
                header("Location: index.php?view=$modules_url", true, 303);
            }
            exit();
        }
    }
    else{
        PrintError("No se puede procesar la petición");
    }
?>