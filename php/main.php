<?php
    #Conexión a la base de datos

    function Conexion()
    {
        $db = new PDO('mysql:host=' . $_ENV['DB_HOST'] .';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        return $db;
    }
    
    #Verificar datos

    function VerificarDatos($filtro, $cadena)
    {
        if(preg_match("/^" . $filtro . "$/", $cadena)){
            return false;
        }
        else{
            return true;
        }
    }

    #Limpiar cadenas de texto

    function LimpiarCadena($cadena)
    {
        $cadena = FiltrarCadena($cadena);
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);

        return $cadena;
    }
    
    function FiltrarCadena($string)
    {
        $pattern = '/(DROP TABLE|SELECT \* FROM|TRUNCATE TABLE|SHOW TABLES|\<|==|\s|\<?php|\?|\/|--|\:|\;|script|\>|\^|\[|\]|DELETE FROM|INSERT INTO|DROP DATABASE|SHOW DATABASE)/i';
        $string =  preg_replace($pattern, '', $string);
        return  $string;
    }

    #Renombrar fotos
    function RenombrarFoto($nombre)
    {
        $pattern = '/(\/|\#|\-|\$|\.|\,|\ )/i';
        $ext = pathinfo($nombre, PATHINFO_EXTENSION);
        $nombre = pathinfo($nombre, PATHINFO_FILENAME);
        $nombre = preg_replace($pattern, '_', $nombre);
        $nombre = $nombre . "_" . time() . "." . $ext;
        
        return $nombre;
    }

    #Paginador de tablas
    function PaginadorTablas($pagina, $nPaginas, $url, $botones)
    {
        $tabla='<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

		if($pagina<=1){
			$tabla.='
			<a class="pagination-previous is-disabled" disabled >Anterior</a>
			<ul class="pagination-list">';
		}else{
			$tabla.='
			<a class="pagination-previous" href="'.$url.($pagina-1).'" >Anterior</a>
			<ul class="pagination-list">
				<li><a class="pagination-link" href="'.$url.'1">1</a></li>
				<li><span class="pagination-ellipsis">&hellip;</span></li>
			';
		}

		$ci=0;
		for($i=$pagina; $i<=$nPaginas; $i++){
			if($ci>=$botones){
				break;
			}
			if($pagina==$i){
				$tabla.='<li><a class="pagination-link is-current" href="'.$url.$i.'">'.$i.'</a></li>';
			}else{
				$tabla.='<li><a class="pagination-link" href="'.$url.$i.'">'.$i.'</a></li>';
			}
			$ci++;
		}

		if($pagina==$nPaginas){
			$tabla.='
			</ul>
			<a class="pagination-next is-disabled" disabled >Siguiente</a>
			';
		}else{
			$tabla.='
				<li><span class="pagination-ellipsis">&hellip;</span></li>
				<li><a class="pagination-link" href="'.$url.$nPaginas.'">'.$nPaginas.'</a></li>
			</ul>
			<a class="pagination-next" href="'.$url.($pagina+1).'" >Siguiente</a>
			';
		}

		$tabla.='</nav>';
		return $tabla;
	}
    


?>