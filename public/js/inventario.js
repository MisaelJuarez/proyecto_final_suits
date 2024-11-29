let tabla,id_libro;
const modal = document.getElementById('modal-agregar');
const modaleditar = document.getElementById('modal-editar');

const obtener_permisos = () => {
    const inventario = document.getElementById('inventario-permisos').value;
    const textoFormateado = inventario
    .replace(/Array\(|\)/g, '')
    .replace(/\s*\[\s*(\w+)\s*\]\s*=>\s*(\w+)\s*/g, '"$1": $2,') 
    .trim() 
    .replace(/,(?=\s*$)/, '');

    const permisos = `{${textoFormateado}}`;
    return JSON.parse(permisos);
}

const obtener_datos = () => {
    let data = new FormData();
    data.append('metodo', 'obtener_datos');
    
    fetch("app/controller/home.php", {
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
                    { data: 'libro_titulo' }, 
                    { data: 'libro_autor' }, 
                    { data: 'libro_categoria' }, 
                    { data: 'libro_publicacion' }, 
                    { data: 'libro_editorial' }, 
                    { data: 'libro_cantidad' }, 
                    {
                        data: 'libro_id',
                        render: (data, type, row) => {
                            let botones = `<div class="d-flex">`;
                            if (obtener_permisos().editar) {
                                botones+= `
                                    <button class="btn btn-warning me-2 editar-libro" data-btn="prestamo" 
                                        data-bs-toggle="modal" data-bs-target="#modal-editar" 
                                        data-id="${data}" 
                                        data-titulo="${row.libro_titulo}" 
                                        data-autor="${row.libro_autor}" 
                                        data-categoria="${row.libro_categoria}" 
                                        data-publicacion="${row.libro_publicacion}" 
                                        data-editorial="${row.libro_editorial}" 
                                        data-cantidad="${row.libro_cantidad}" 
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                `;    
                            }
                            if (obtener_permisos().eliminar) {
                                botones+= `
                                    <button class="btn btn-danger eliminar-libro" data-btn="prestamo" 
                                        data-id="${data}" 
                                    >
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                `;
                            }
                            botones+= `</div>`;
                            return botones;
                        }
                    }
                ],
                "lengthChange": false,
                "pageLength": 5,
                language: { url: "./public/json/lenguaje.json" },
                dom: '<"custom-toolbar"lf>tip', 
                initComplete: () => {
                    if (obtener_permisos().agregar) {
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
                }
            });
        }
    });
};

const agregar_libro = () => {
    let data = new FormData(document.getElementById('forumulario-inventario'));
    data.append('metodo','registrar_libro');
    fetch("app/controller/home.php",{
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
                document.getElementById('forumulario-inventario').reset();
            }  
            obtener_datos();
        } else if(respuesta[0] == 0) {
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    })
}

const editar_libro = () => {
    let data = new FormData(document.getElementById('forumulario-inventario-editar'));
    data.append('id',id_libro);
    data.append('metodo','editar_libro');
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            const modalEditar = bootstrap.Modal.getInstance(modaleditar); 
            if (modalEditar) modalEditar.hide();
            obtener_datos();
        } else if(respuesta[0] == 0) {
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    })
} 

const eliminar_libro = (id) => {
    let data = new FormData();
    data.append('id',id);
    data.append('metodo','eliminar_libro')
    fetch('app/controller/home.php', {
        method: 'POST',
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            obtener_datos();
        } else if(respuesta[0] == 0) {
            await Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    })
}

document.addEventListener('DOMContentLoaded', async () => {
    obtener_datos();
});

document.getElementById('agregar-libro').addEventListener('click', () => {
    agregar_libro();
});

document.getElementById('editar-libro').addEventListener('click', () => {
    editar_libro();
});

document.getElementById('myTable').addEventListener('click', (e) => {
    const botonEditar = e.target.closest('.editar-libro');
    const botonEliminar = e.target.closest('.eliminar-libro');
    if (botonEditar) {
        id_libro = botonEditar.dataset.id;
        document.getElementById('titulo-editar').value = botonEditar.dataset.titulo;
        document.getElementById('autor-editar').value = botonEditar.dataset.autor;
        document.getElementById('categoria-editar').value = botonEditar.dataset.categoria;
        document.getElementById('publicacion-editar').value = botonEditar.dataset.publicacion;
        document.getElementById('editorial-editar').value = botonEditar.dataset.editorial;
        document.getElementById('cantidad-editar').value = botonEditar.dataset.cantidad;
    }
    if (botonEliminar) {
        Swal.fire({
            icon: "warning",
            text: "Quieres eliminar este libro?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar"
          }).then((result) => {
            if (result.isConfirmed) {
                eliminar_libro(botonEliminar.dataset.id);
            }
        });
    }
});