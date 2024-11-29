<?php
if (!isset($_SESSION['usuario'])) {
    header("location:login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="<?=CSS."table.css";?>">
    <link rel="stylesheet" href="<?=CSS."libros_prestados.css"?>">
    <title>Libros prestados</title>
</head>
<body>

    <div class="p-3">
        <div class="container-fluid mt-3" id="contenedor-tabla">
            <table id="myTable" class="table table-dark table-striped p-5">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Libro</th>
                        <th scope="col">Fecha que se presto</th>
                        <th scope="col">Fecha de entrega</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla_libros">
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="modal fade" id="cambio-fecha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambiar fecha de entrega</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario-cambiar-fecha">
                    <div class="input-group mb-3">
                        <i class="bi bi-calendar-heart-fill input-group-text fs-3"></i>
                        <input type="date" class="form-control" placeholder="Fecha de entrega" id="fecha-cambiar" name="fecha-cambiar">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary cambiar" id="cambiar-fecha">Guardar cambio</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mas-informacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Informacion</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <h4>Estudiante</h4>
                        <p><b>Nombre:</b> <span id="nombre_estudiante"></span></p>
                        <p><b>Apellidos:</b> <span id="apellidos_estudiante"></span></p>
                        <p><b>Numero de control:</b> <span id="nControl_estudiante"></span></p>
                        <p><b>Carrera:</b> <span id="carrera_estudiante"></span></p>
                        <p><b>Semestre:</b> <span id="semestre_estudiante"></span></p>
                        <p><b>Telefono:</b> <span id="telefono_estudiante"></span></p>
                    </div>
                    <div class="col">
                        <h4>Libro</h4>
                        <p><b>Titulo:</b> <span id="titulo_libro"></span></p>
                        <p><b>Autor(es):</b> <span id="autor_libro"></span></p>
                        <p><b>Editorial:</b> <span id="editorial_libro"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <script src="<?=JS."jquery.js"?>"></script>
    <script src="<?=JS."table.js"?>"></script>
    <script src="<?=JS."libros_prestados.js"?>"></script>
</body>
</html>