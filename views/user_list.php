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
    
    <p class="has-text-right">Mostrando usuarios <strong>1</strong> al <strong>9</strong> de un <strong>total de 9</strong></p>

    <nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">
        <a class="pagination-previous" href="#">Anterior</a>

        <ul class="pagination-list">
            <li><a class="pagination-link" href="#">1</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a class="pagination-link is-current" href="#">2</a></li>
            <li><a class="pagination-link" href="#">3</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a class="pagination-link" href="#">3</a></li>
        </ul>

        <a class="pagination-next" href="#">Siguiente</a>
    </nav>

</div>