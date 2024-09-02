<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Lista de usuarios</h2>
</div>

<div class="container pb-6 pt-6">

    <?php
        require_once "./php/main.php";

        if (!isset($_GET['page'])) {
            $page = 1;    
        } 
        else {
            $page = (int) $_GET['page'];
            if ($page <= 1) {
                $page = 1;
            }
        }
        
        $page = LimpiarCadena($page);
        $url = "index.php?view=user_list&page=";
        $regCount = 15;
        $search = "";

        require_once "./php/list_users.php";
    ?>

</div>