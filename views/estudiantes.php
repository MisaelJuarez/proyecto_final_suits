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
    <link rel="stylesheet" href="<?=CSS."estudiantes.css"?>">
    <title>Estidiantes</title>
</head>
<body>
    <input type="text" value="<?php print_r($permisos_usuario['estudiantes']); ?>" id="inventario-permisos" hidden>
    <div class="d-flex flex-column contenedor-principal p-2 mt-3" id="contenedor">

        <div class="contenedor-tabla p-3">
            <div class="container-fluid p-3" id="contenedor-tabla">
                <table id="myTable" class="table table-dark table-striped p-5">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Semestre</th>
                            <th scope="col">Carrera</th>
                            <th scope="col">Numero de control</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla_libros">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-agregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar nuevo Estudiante</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" novalidate id="forumulario-estudiantes">
                    <div class="col-md-4">
                        <label for="titulo" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" required>
                    </div>
                    <div class="col-md-4">
                        <label for="autor" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" id="apellidos" required>
                    </div>
                    <div class="col-md-4">
                        <label for="categoria" class="form-label">Semestre</label>
                        <select class="form-select" id="semestre" name="semestre" required>
                            <option selected disabled value="">semestre</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="categoria" class="form-label">Carrera</label>
                        <select class="form-select" id="carrera" name="carrera" required>
                            <option selected disabled value="">carreras</option>
                            <option value="Gestion Empresarial">Gestion Empresarial</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Sistemas Computacionales">Sistemas Computacionales</option>
                            <option value="Turismo">Turismo</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="editorial" class="form-label">Numero de control</label>
                        <input type="text" class="form-control" name="nControl" id="nControl" required>
                    </div>
                    <div class="col-md-4">
                        <label for="cantidad" class="form-label">Telefono</label>
                        <input type="text" class="form-control" name="telefono" id="telefono" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="agregar-estudiante">Agregar Estudiante</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-editar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Estudiante</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" novalidate id="forumulario-inventario-editar">
                    <div class="col-md-4">
                        <label for="titulo" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre-editar" id="nombre-editar" required>
                    </div>
                    <div class="col-md-4">
                        <label for="autor" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos-editar" id="apellidos-editar" required>
                    </div>
                    <div class="col-md-4">
                        <label for="categoria" class="form-label">Semestre</label>
                        <select class="form-select" id="semestre-editar" name="semestre-editar" required>
                            <option selected disabled value="">semestre</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="categoria" class="form-label">Carrera</label>
                        <select class="form-select" id="carrera-editar" name="carrera-editar" required>
                            <option selected disabled value="">carreras</option>
                            <option value="Gestion Empresarial">Gestion Empresarial</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Sistemas Computacionales">Sistemas Computacionales</option>
                            <option value="Turismo">Turismo</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="editorial" class="form-label">Numero de control</label>
                        <input type="text" class="form-control" name="nControl-editar" id="nControl-editar" required>
                    </div>
                    <div class="col-md-4">
                        <label for="cantidad" class="form-label">Telefono</label>
                        <input type="text" class="form-control" name="telefono-editar" id="telefono-editar" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="editar-estudiante">Editar Estudiante</button>
            </div>
            </div>
        </div>
    </div>

    <script src="<?=JS."jquery.js"?>"></script>
    <script src="<?=JS."table.js"?>"></script>
    <script src="<?=JS."estudiantes.js"?>"></script>
</body>
</html>