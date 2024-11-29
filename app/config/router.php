<?php
    if (isset($_REQUEST['viewLogin'])) {
        $vistaLogin = $_REQUEST['viewLogin'];
    }else {
        $vistaLogin = "login";
    }
    switch ($vistaLogin) {
        case "login":{
            require_once './views/login.php';
            break;
        }
        case "inicio":{
            require_once './views/home.php';
            break;
        }
        case "libros":{
            require_once './views/libros.php';
            break;
        }
        case "libros_prestados":{
            require_once './views/libros_prestados.php';
            break;
        }
        case "inventario":{
            require_once './views/inventario.php';
            break;
        }
        case "estudiantes":{
            require_once './views/estudiantes.php';
            break;
        }
        case "informacion":{
            require_once './views/informacion.php';
            break;
        }
        case "administrar":{
            require_once './views/administrar.php';
            break;
        }
        default:{
            require_once './views/error404.php';
        }
        break;
    }
?>