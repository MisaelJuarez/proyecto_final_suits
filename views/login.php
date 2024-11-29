<?php
if (isset($_SESSION['usuario'])) {
    header("location:inicio");
    exit();
}
?>
<head>
    <link rel="stylesheet" href="<?=CSS."login.css"?>">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-center mt-5">
            <form class="p-3 mt-5" id="formulario_login">
                <div class="text-center icon-user">
                    <i class="bi bi-person-circle text-white"></i>
                </div>
                <div class="input-group mb-3 mt-4">
                    <i class="bi bi-person-fill input-group-text fs-3"></i>
                    <input type="text" class="form-control" placeholder="Ingrese su nombre de usuario" id="usuario" name="usuario">
                </div>
                <div class="input-group mb-3">
                    <i class="bi bi-lock-fill input-group-text fs-3"></i>
                    <input type="password" class="form-control" placeholder="Ingrese su contraseña" id="pass" name="pass">
                </div>
                <div class="mt-5 c-button">
                    <button type="button" id="btn-ingresar" class="btn w-100 text-white fs-4">Ingresar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?=JS."login.js"?>"></script>
</body>