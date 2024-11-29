<?php
if (!isset($_SESSION['usuario'])) {
    header("location:login");
    exit();
}
?>
<head>
    <link rel="stylesheet" href="<?=CSS."table.css";?>">
    <link rel="stylesheet" href="<?=CSS."libros.css"?>">
    <title>Libros</title>
</head>
<body>
    
    <div class="p-4">
        <div class="container-fluid mt-3" id="contenedor-tabla">
            <table id="myTable" class="table table-dark table-striped p-5">
                <thead>
                    <tr>
                        <th scope="col">Titulo</th>
                        <th scope="col">Autor(es)</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Fecha de publicacion</th>
                        <th scope="col">Editorial</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody id="tabla_libros">
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalPrestar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Prestar libro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col">
                        <h3 class="text-center">Libro</h3>
                        <div class="d-flex justify-content-between">
                            <p><b>Titulo:</b> <span id="titulo-libro"></span></p>
                            <p><b>Autor(es):</b> <span id="autor-libro"></span></p>
                            <p><b>Categoria:</b> <span id="categoria-libro"></span></p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col me-5">
                        <h3 class="text-center">Alumno</h3>
                        <div class="d-flex">
                            <input type="text" class="form-control form-control-sm" id="nControl" placeholder="Numero de control" name="nControl">
                            <button type="button" class="btn btn-info ms-2" id="buscar-alumno">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <div class="mt-3">
                            <p><b>Nombre:</b> <span id="estudiante-nombre"></span></p>
                            <p><b>Apellidos:</b> <span id="estudiante-apellidos"></span></p>
                            <p><b>Carrera:</b> <span id="estudiante-carrera"></span></p>
                        </div>
                    </div>
                    <div class="col">
                        <h3 class="text-center">Fechas</h3>
                        <label for="fecha_prestamo" class="form-label">Fecha del prestamo</label>
                        <input type="date" class="form-control form-control-sm mb-3" id="fecha_prestamo" name="fecha_prestamo">
                        <label for="fecha_entrega" class="form-label">Fecha de entrega</label>
                        <input type="date" class="form-control form-control-sm" id="fecha_entrega" name="fecha_entrega">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="prestar-libro">Prestar Libro</button>
            </div>
            </div>
        </div>
    </div>

    <script src="<?=JS."jquery.js"?>"></script>
    <script src="<?=JS."table.js"?>"></script>
    <script src="<?=JS."libros.js"?>"></script>
</body>
</html>