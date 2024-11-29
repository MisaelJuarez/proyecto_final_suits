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
    <link rel="stylesheet" href="<?=CSS."inventario.css"?>">
    <title>Inventario</title>
</head>
<body>
    <input type="text" value="<?php print_r($permisos_usuario['inventario']); ?>" id="inventario-permisos" hidden>
    <div class="p-3">
        <div class="container-fluid mt-3 p-3" id="contenedor-tabla">
            <table id="myTable" class="table table-dark table-striped p-5">
                <thead>
                    <tr>
                        <th scope="col">Titulo</th>
                        <th scope="col">Autor(es)</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Fecha de publicacion</th>
                        <th scope="col">Editorial</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla_libros">
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-agregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar nuevo libro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" novalidate id="forumulario-inventario">
                    <div class="col-md-6">
                        <label for="titulo" class="form-label">Titulo del libro</label>
                        <input type="text" class="form-control" name="titulo" id="titulo" required>
                    </div>
                    <div class="col-md-6">
                        <label for="autor" class="form-label">Autor(es)</label>
                        <input type="text" class="form-control" name="autor" id="autor" required>
                    </div>
                    <div class="col-md-3">
                        <label for="categoria" class="form-label">Categoria</label>
                        <select class="form-select" id="categoria" name="categoria" required>
                            <option selected disabled value="">categorias</option>
                            <option value="Ciencias Basicas">Ciencias Basicas</option>
                            <option value="Gestion Empresarial">Gestion Empresarial</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Sistemas Computacionales">Sistemas Computacionales</option>
                            <option value="Turismo">Turismo</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="publicacion" class="form-label">Año de publicacion</label>
                        <input type="text" class="form-control" name="publicacion" id="publicacion" required>
                    </div>
                    <div class="col-md-3">
                        <label for="editorial" class="form-label">Editorial</label>
                        <input type="text" class="form-control" name="editorial" id="editorial" required>
                    </div>
                    <div class="col-md-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="cantidad" id="cantidad" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="agregar-libro">Agregar Libro</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-editar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar libro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" novalidate id="forumulario-inventario-editar">
                    <div class="col-md-6">
                        <label for="titulo" class="form-label">Titulo del libro</label>
                        <input type="text" class="form-control" name="titulo-editar" id="titulo-editar" required>
                    </div>
                    <div class="col-md-6">
                        <label for="autor" class="form-label">Autor(es)</label>
                        <input type="text" class="form-control" name="autor-editar" id="autor-editar" required>
                    </div>
                    <div class="col-md-3">
                        <label for="categoria" class="form-label">Categoria</label>
                        <select class="form-select" id="categoria-editar" name="categoria-editar" required>
                            <option selected disabled value="">categorias</option>
                            <option value="Ciencias Basicas">Ciencias Basicas</option>
                            <option value="Gestion Empresarial">Gestion Empresarial</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Sistemas Computacionales">Sistemas Computacionales</option>
                            <option value="Turismo">Turismo</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="publicacion" class="form-label">Año de publicacion</label>
                        <input type="text" class="form-control" name="publicacion-editar" id="publicacion-editar" required>
                    </div>
                    <div class="col-md-3">
                        <label for="editorial" class="form-label">Editorial</label>
                        <input type="text" class="form-control" name="editorial-editar" id="editorial-editar" required>
                    </div>
                    <div class="col-md-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="cantidad-editar" id="cantidad-editar" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="editar-libro">Editar Libro</button>
            </div>
            </div>
        </div>
    </div>

    <script src="<?=JS."jquery.js"?>"></script>
    <script src="<?=JS."table.js"?>"></script>
    <script src="<?=JS."inventario.js"?>"></script>
</body>
</html>