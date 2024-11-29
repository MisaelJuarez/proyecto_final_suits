<?php
require_once "./app/config/dependencias.php";
session_start();
require_once "./app/config/rutas.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=CSS."bootstrap.min.css"?>">
    <link rel="stylesheet" href="<?=CSS."icons/font/bootstrap-icons.min.css"?>">
    <link rel="stylesheet" href="<?=CSS."navar.css"?>">
</head>

<?php 
    if (isset($_SESSION['usuario'])) {
        $permisos_usuario = json_decode($_SESSION['usuario']['usuario_permisos'], true);
        require_once("./views/componentes/navar.php");
    } 
    ?>
    <?php require_once("./app/config/router.php") ?>

    <script src="<?=JS."bootstrap.bundle.min.js"?>"></script>
    <script src="<?=JS."navar.js"?>"></script>
    <script src="<?=JS."alerts.js"?>"></script>
</html>