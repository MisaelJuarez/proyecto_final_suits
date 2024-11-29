<?php
if (!isset($_SESSION['usuario'])) {
    header("location:login");
    exit();
}
?>
<head>
    <link rel="stylesheet" href="<?=CSS."home.css"?>">
    <title>Inicio</title>
</head>
<body>
    
    <div class="container">
        <div class="contenedor-card p-5 d-flex justify-content-evenly">

            <div class="card mb-3" id="libros" style="width: 15rem;">
                <div class="card-header header-libros">Libros</div>
                <div class="card-body">
                    <h5 class="card-title w-100"><i class="bi bi-book"></i></h5>
                    <p class="card-text"></p>
                 </div>
            </div>

            <div class="card mb-3" id="libros_prestados" style="width: 15rem;">
                <div class="card-header header-prestamos">Libros prestados</div>
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-journal-arrow-down"></i></i></h5>
                    <p class="card-text"></p>
                 </div>
            </div>

            <div class="card mb-3" id="inventario" style="width: 15rem;">
                <div class="card-header header-inventario">Inventario</div>
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-boxes"></i></i></h5>
                    <p class="card-text"></p>
                 </div>
            </div>

            <div class="card mb-3" id="estudiantes" style="width: 15rem;">
                <div class="card-header header-estudiantes">Estudiantes</div>
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-mortarboard-fill"></i></i></h5>
                    <p class="card-text"></p>
                 </div>
            </div>

        </div>
    </div>

    <script src="<?=JS."home.js"?>"></script>
</body>
