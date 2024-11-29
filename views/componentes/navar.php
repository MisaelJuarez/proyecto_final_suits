<ul class="nav justify-content-between p-3">
    <div class="nav-item">
        <a class="nav-link text" href="<?=url('inicio')?>">Inventario de libros</a>
    </div>
    <div class="d-flex">
        <?php if($permisos_usuario['administrar']['permiso'] == 'true'): ?>
        <a class="nav-link text" href="<?=url('administrar')?>">
            Administrar
        </a>
        <?php endif; ?>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text" data-bs-toggle="dropdown" href="#" role="button">
                <?=$_SESSION['usuario']['usuario_nombre']?>
            </a>
            <ul class="dropdown-menu">
                <?php if($permisos_usuario['actualizar_informacion']['permiso'] == 'true'): ?>
                <li><a class="dropdown-item" href="<?=url('informacion')?>">Informacion</a></li>
                <?php endif; ?>
                <li><button class="dropdown-item" id="cerrar_session" href="<?=url('cerrar_session')?>">Cerrar session</button></li>
            </ul>
        </li>
    </div>
</ul>