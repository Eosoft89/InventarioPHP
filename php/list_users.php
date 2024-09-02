<?php
    $start = ($page > 0) ? (($page * $regCount)-$regCount) : 0;
    $table = "";

    if (isset($search) && $search != "") {
        $query = "SELECT * FROM usuario WHERE ((id !='" . $_SESSION['id'] . "') AND 
            (usuario LIKE '%$search%' OR nombre LIKE '%$search%' OR apellido LIKE '%$search%')) ORDER BY nombre ASC LIMIT $start, $regCount";
        $countQuery = "SELECT COUNT(id) FROM usuario WHERE ((id !='" . $_SESSION['id'] . "') AND 
            (usuario LIKE '%$search%' OR nombre LIKE '%$search%' OR apellido LIKE '%$search%'))";
    } 
    else {
        $query = "SELECT * FROM usuario WHERE id !='" . $_SESSION['id'] . "' ORDER BY nombre ASC LIMIT $start, $regCount";
        $countQuery = "SELECT COUNT(id) FROM usuario WHERE id !='" . $_SESSION['id'] . "'";
    }
    
    $connection = Conexion();
    $data = $connection->query($query)->fetchAll();
    $dataCount = $connection->query($countQuery);
    $dataCount = (int) $dataCount->fetchColumn();

    $nPages = ceil($dataCount / $regCount);

    $table .= '
        <div class="table-container">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered">
                        <th>#</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th colspan="2">Opciones</th>
                    </tr>
                </thead>
                <tbody>';

    if($dataCount >= 1 && $page <= $nPages){
        $count = $start + 1;
        $pagStart = $start + 1;

        foreach ($data as $row) {
            $table .= '
                <tr class="has-text-centered" >
					<td>' . $count . '</td>
                    <td>' . $row['nombre'] . '</td>
                    <td>' . $row['apellido'] . '</td>
                    <td>' . $row['usuario'] . '</td>
                    <td>' . $row['email'] . '</td>
                    <td>
                        <a href="index.php?view=user_update&user_id=' . $row['id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="' . $url . $page . '&user_id=' . $row['id'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>';
            $count++;
        }
        $pagEnd = $count - 1;
    }
    else{
        if($dataCount >= 1){
            $table .= 
                '<tr class="has-text-centered" >
                    <td colspan="7">
                        <a href="'. $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                            Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>';
        }
        else{
            $table .= 
                '<tr class="has-text-centered" >
                    <td colspan="7">
                        No hay registros en el sistema
                    </td>
                </tr>';
        }
    }

    $table .= '
                </tbody>
            </table>
        </div>';

        if($dataCount >= 1 && $page <= $nPages){
            $table .= 
                '<p class="has-text-right">Mostrando usuarios <strong>'. $pagStart .'</strong> al <strong>' . $pagEnd .'</strong> de un <strong>total de '. $dataCount . '</strong></p>';
        }

    $connection = null;
    echo $table;
    
    if($dataCount >= 1 && $page <= $nPages){
        echo PaginadorTablas($page, $nPages, $url, 5);
    }

?>