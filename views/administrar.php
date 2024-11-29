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
    <link rel="stylesheet" href="<?=CSS."administrar.css"?>">
    <title>Administracion de usuarios</title>
</head>
<body>

    <div class="container mt-4 p-3" id="contenedor-tabla">
        <table id="myTable" class="table table-dark table-striped p-5">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Nombre de Usuario</th>
                    <th scope="col">Acciones</th> 
                </tr>
            </thead>
            <tbody id="tabla_libros">
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modal-agregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar nuevo Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" novalidate id="forumulario-agregar">
                    <div class="col-md-3">
                        <label for="titulo" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" required>
                    </div>
                    <div class="col-md-3">
                        <label for="autor" class="form-label">Apellido</label>
                        <input type="text" class="form-control" name="apellidos" id="apellidos" required>
                    </div>
                    <div class="col-md-3">
                        <label for="publicacion" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" name="usuario" id="usuario" required>
                    </div>
                    <div class="col-md-3">
                        <label for="editorial" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="pass" id="pass" required>
                    </div>
                    <hr>
                    <h4>Permisos De Usuario</h4>
                    <div class="col-md-3 d-flex">
                        <p class="me-3 fs-3">Inventario:</p>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" id="inventario_agregar" name="inventario_agregar">
                                <label class="form-check-label" for="inventario_agregar">
                                    Agregar
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" id="inventario_editar" name="inventario_editar">
                                <label class="form-check-label" for="inventario_editar">
                                    Editar
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" id="inventario_eliminar" name="inventario_eliminar">
                                <label class="form-check-label" for="inventario_eliminar">
                                    Eliminar
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex">
                        <p class="me-3 fs-3">Estudiantes:</p>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" id="estudiante_agregar" name="estudiante_agregar">
                                <label class="form-check-label" for="estudiante_agregar">
                                    Agregar
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" id="estudiante_editar" name="estudiante_editar">
                                <label class="form-check-label" for="estudiante_editar">
                                    Editar
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" id="estudiante_eliminar" name="estudiante_eliminar">
                                <label class="form-check-label" for="estudiante_eliminar">
                                    Eliminar
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="true" id="actualizar_informacion" name="actualizar_informacion">
                            <label class="form-check-label" for="actualizar_informacion">
                                Actualizar su informacion
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="true" id="administrar_usuarios" name="administrar_usuarios">
                            <label class="form-check-label" for="administrar_usuarios">
                                Administrar usuarios
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="agregar-usuario">Agregar Usuario</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-editar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" novalidate id="forumulario-editar">
                    <div class="col-md-3">
                        <label for="titulo" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre-editar" id="nombre-editar" required>
                    </div>
                    <div class="col-md-3">
                        <label for="autor" class="form-label">Apellido</label>
                        <input type="text" class="form-control" name="apellidos-editar" id="apellidos-editar" required>
                    </div>
                    <div class="col-md-3">
                        <label for="publicacion" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" name="usuario-editar" id="usuario-editar" required>
                    </div>
                    <div class="col-md-3">
                        <label for="editorial" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="pass-editar" id="pass-editar" required>
                    </div>
                    <hr>
                    <h4>Permisos De Usuario</h4>
                    <div class="col-md-3 d-flex">
                        <p class="me-3 fs-3">Inventario:</p>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" id="inventario_agregar-edit" name="inventario_agregar-edit">
                                <label class="form-check-label" for="inventario_agregar">
                                    Agregar
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" id="inventario_editar-edit" name="inventario_editar-edit">
                                <label class="form-check-label" for="inventario_editar">
                                    Editar
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" id="inventario_eliminar-edit" name="inventario_eliminar-edit">
                                <label class="form-check-label" for="inventario_eliminar">
                                    Eliminar
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex">
                        <p class="me-3 fs-3">Estudiantes:</p>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" id="estudiante_agregar-edit" name="estudiante_agregar-edit">
                                <label class="form-check-label" for="estudiante_agregar">
                                    Agregar
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" id="estudiante_editar-edit" name="estudiante_editar-edit">
                                <label class="form-check-label" for="estudiante_editar">
                                    Editar
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" id="estudiante_eliminar-edit" name="estudiante_eliminar-edit">
                                <label class="form-check-label" for="estudiante_eliminar">
                                    Eliminar
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="true" id="actualizar_informacion-edit" name="actualizar_informacion-edit">
                            <label class="form-check-label" for="actualizar_informacion">
                                Actualizar su informacion
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="true" id="administrar_usuarios-edit" name="administrar_usuarios-edit">
                            <label class="form-check-label" for="administrar_usuarios">
                                Administrar usuarios
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="editar-usuario">Editar Usuario</button>
            </div>
            </div>
        </div>
    </div>
    

    <script src="<?=JS."jquery.js"?>"></script>
    <script src="<?=JS."table.js"?>"></script>
    <script src="<?=JS."administrar.js"?>"></script>
</body>
</html>