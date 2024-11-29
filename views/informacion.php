<?php
if (!isset($_SESSION['usuario'])) {
    header("location:login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="<?=CSS."informacion.css"?>">
    <title>Informacion</title>
</head>
<body>
    
    <div class="container p-5 d-flex justify-content-around">

        <div class="contenedor">
            <div class="text-center mb-3">
                <i class="bi bi-person-circle"></i>
            </div>
            <p class="text-center nombre-usuario">
                <?php
                    echo $_SESSION['usuario']['usuario_nombre']." ".
                    $_SESSION['usuario']['usuario_apellidos']." "
                ?>
            </p>
        </div>

        <form class="contenedor p-3" id="formulario_usuario">
            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="nombre" id="nombre" placeholder="">
                <label for="nombre" class="text-white">Ingrese su nombre</label>
            </div> 
            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="apellidos" id="apellidos" placeholder="">
                <label for="apellidos" class="text-white">Ingrese sus apellidos</label>
            </div> 
            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="usuario" id="usuario" placeholder="">
                <label for="usuario" class="text-white">Ingrese su nombre de usuario</label>
            </div> 
            <div class="form-floating mb-3">
                <input class="form-control" type="password" name="pass" id="pass" placeholder="">
                <label for="pass" class="text-white">Ingrese su nueva contraseña</label>
            </div> 
            <button type="button" class="btn btn-secondary w-100" id="btn-actualizar">Acualizar informacion</button>
        </form>

    </div>

    <script src="<?=JS."informacion.js"?>"></script>
</body>
</html>