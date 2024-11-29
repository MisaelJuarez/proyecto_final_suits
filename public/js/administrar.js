let tabla,id_usuario;
const modal = document.getElementById('modal-agregar');
const modaleditar = document.getElementById('modal-editar');

const obtener_datos = () => {
    let data = new FormData();
    data.append('metodo', 'obtener_usuarios');
    
    fetch("app/controller/usuario.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then((respuesta) => {
        if (tabla) {
            tabla.clear().rows.add(respuesta).draw(); 
        } else {
            tabla = $('#myTable').DataTable({
                data: respuesta, 
                columns: [
                    { data: 'usuario_nombre' }, 
                    { data: 'usuario_apellidos' }, 
                    { data: 'usuario_usuario' }, 
                    {
                        data: 'usuario_id',
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-warning me-3 editar-usuario"
                                    data-bs-toggle="modal" data-bs-target="#modal-editar"
                                    data-id="${data}" 
                                    data-nombre="${row.usuario_nombre}" 
                                    data-apellidos="${row.usuario_apellidos}" 
                                    data-usuario="${row.usuario_usuario}"   
                                    data-permisos='${row.usuario_permisos}'   
                                >
                                    Editar
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger eliminar-usuario"
                                    data-id="${data}"
                                >
                                    Eliminar
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            `;
                        }
                    } 
                ],
                "lengthChange": false,
                "pageLength": 8,
                language: { url: "./public/json/lenguaje.json" },
                dom: '<"custom-toolbar"lf>tip', 
                initComplete: () => {
                    $("div.custom-toolbar").prepend(`
                        <div class="left-section">
                            <button class="btn btn-info"
                                    data-bs-toggle="modal" data-bs-target="#modal-agregar"
                            >
                                <i class="bi bi-plus-lg fs-5"></i>
                            </button>
                        </div>
                    `);
                    $("div.custom-toolbar .dataTables_filter").appendTo(".custom-toolbar").addClass("right-section");
                }
            });
        }
    });
};

const agregar_usuario = () => {
    let data = new FormData(document.getElementById('forumulario-agregar'));
    data.append('metodo','agregar_usuario');
    fetch("app/controller/usuario.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {        
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            const modalAgregar = bootstrap.Modal.getInstance(modal); 
            if (modalAgregar) {
                modalAgregar.hide();
                document.getElementById('forumulario-agregar').reset();
            }  
            obtener_datos();
        } else if(respuesta[0] == 0) {
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    })
}

const editar_usuario = () => {
    let data = new FormData(document.getElementById('forumulario-editar'));
    data.append("id_usuario",id_usuario);
    data.append("metodo","actualizar_datos");
    fetch("./app/controller/usuario.php",{
        method:"POST",
        body:data
    }).then(respuesta => respuesta.json())
    .then(async respuesta => { 
        if(respuesta[0] == 1){
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            const modalEditar = bootstrap.Modal.getInstance(modaleditar); 
            if (modalEditar) {
                modalEditar.hide();
            }  
            document.getElementById('forumulario-editar').reset();
            obtener_datos();
        }else if (respuesta[0] == 0){
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    });
}

const eliminar_usuario = (id) => {
    let data = new FormData();
        data.append("id_usuario",id);
        data.append("metodo","eliminar_usuario");
        fetch("./app/controller/usuario.php",{
            method:"POST",
            body:data
        }).then(respuesta => respuesta.json())
        .then(async respuesta => { 
            if(respuesta[0] == 1){
                await Swal.fire({icon: "success",title:`${respuesta[1]}`});
                obtener_datos();
            }else if(respuesta[0] == 0){
                Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    obtener_datos();
});

document.getElementById('agregar-usuario').addEventListener('click',() => {
    agregar_usuario();
});

document.getElementById('editar-usuario').addEventListener('click',() => {
    editar_usuario();
});

document.getElementById('myTable').addEventListener('click', (e) => {
    const botonEditar = e.target.closest('.editar-usuario');
    const botonEliminar = e.target.closest('.eliminar-usuario');
    if (botonEditar) {
        id_usuario = botonEditar.dataset.id;
        document.getElementById('nombre-editar').value = botonEditar.dataset.nombre;
        document.getElementById('apellidos-editar').value = botonEditar.dataset.apellidos;
        document.getElementById('usuario-editar').value = botonEditar.dataset.usuario;

        const permisos = JSON.parse(botonEditar.dataset.permisos);
        document.getElementById('inventario_agregar-edit').checked = (permisos.inventario.agregar == 'true') ? true : false;
        document.getElementById('inventario_editar-edit').checked = (permisos.inventario.editar == 'true') ? true : false;
        document.getElementById('inventario_eliminar-edit').checked = (permisos.inventario.eliminar == 'true') ? true : false;

        document.getElementById('estudiante_agregar-edit').checked = (permisos.estudiantes.agregar == 'true') ? true : false;
        document.getElementById('estudiante_editar-edit').checked = (permisos.estudiantes.editar == 'true') ? true : false;
        document.getElementById('estudiante_eliminar-edit').checked = (permisos.estudiantes.eliminar == 'true') ? true : false;
        
        document.getElementById('actualizar_informacion-edit').checked = (permisos.actualizar_informacion.permiso == 'true') ? true : false;
        document.getElementById('administrar_usuarios-edit').checked = (permisos.administrar.permiso == 'true') ? true : false;
    }
    if (botonEliminar) {
        Swal.fire({
            icon: "warning",
            text: "Quieres eliminar este usuario?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar"
          }).then((result) => {
            if (result.isConfirmed) {
                eliminar_usuario(botonEliminar.dataset.id);
            }
        });
    }
});