let tabla,id_estudiante;
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
    
    fetch("app/controller/estudiantes.php", {
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
                    { data: 'estudiante_nombre' }, 
                    { data: 'estudiante_apellidos' },
                    { data: 'estudiante_semestre' },
                    { data: 'estudiante_carrera' },
                    { data: 'estudiante_nControl' },
                    { data: 'estudiante_telefono' },
                    {
                    data: 'estudiante_id',
                    render: function(data, type, row) {
                        let botones = `<div class="d-flex">`;
                            if (obtener_permisos().editar) {
                                botones+= `
                                    <button class="btn btn-warning editar-estudiante me-2" 
                                        data-bs-toggle="modal" data-bs-target="#modal-editar"
                                        data-id="${data}" 
                                        data-nombre="${row.estudiante_nombre}" 
                                        data-apellidos="${row.estudiante_apellidos}" 
                                        data-semestre="${row.estudiante_semestre}" 
                                        data-carrera="${row.estudiante_carrera}" 
                                        data-ncontrol="${row.estudiante_nControl}" 
                                        data-telefono="${row.estudiante_telefono}" 
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                `;    
                            }
                            if (obtener_permisos().eliminar) {
                                botones+= `
                                    <button class="btn btn-danger eliminar-estudiante" 
                                        data-id="${data}" 
                                    >
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                    `;
                            }
                        botones+= `</div>`;
                        return botones
                    }
                    }
                ],
                "lengthChange": false,
                "pageLength": 6, 
                language: { url: "./public/json/lenguaje.json" },
                dom: '<"custom-toolbar"lf>tip', 
                initComplete: function() {
                    if (obtener_permisos().agregar) {
                        $("div.custom-toolbar").prepend(`
                            <div class="left-section">
                                <button id="custom-button" class="btn btn-info" 
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

const agregar_estudiante = () => {
    let data = new FormData(document.getElementById('forumulario-estudiantes'));
    data.append('metodo','registrar_estudiante');
    fetch("app/controller/estudiantes.php",{
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
                document.getElementById('forumulario-estudiantes').reset();
            }  
            obtener_datos();
        } else if(respuesta[0] == 0) {
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    })
}

const editar_estudiante = () => {
    let data = new FormData(document.getElementById('forumulario-inventario-editar'));
    data.append('id',id_estudiante);
    data.append('metodo','editar_estudiante');
    fetch("app/controller/estudiantes.php",{
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

const eliminar_estudiante = (id) => {
    let data = new FormData();
    data.append('id',id);
    data.append('metodo','eliminar_estudiante')
    fetch('app/controller/estudiantes.php', {
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

document.addEventListener('DOMContentLoaded', () => {
    obtener_datos();
});

document.getElementById('agregar-estudiante').addEventListener('click', () => {
    agregar_estudiante();
});

document.getElementById('editar-estudiante').addEventListener('click', () => {
    editar_estudiante();
});

document.getElementById('myTable').addEventListener('click', (e) => {
    const botonEditar = e.target.closest('.editar-estudiante');
    const botonEliminar = e.target.closest('.eliminar-estudiante');
    if (botonEditar) {
        id_estudiante = botonEditar.dataset.id;
        document.getElementById('nombre-editar').value = botonEditar.dataset.nombre;
        document.getElementById('apellidos-editar').value = botonEditar.dataset.apellidos;
        document.getElementById('semestre-editar').value = botonEditar.dataset.semestre;
        document.getElementById('carrera-editar').value = botonEditar.dataset.carrera;
        document.getElementById('nControl-editar').value = botonEditar.dataset.ncontrol;
        document.getElementById('telefono-editar').value = botonEditar.dataset.telefono;
    }
    if (botonEliminar) {
        Swal.fire({
            icon: "warning",
            text: "Quieres eliminar este estudiante?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar"
          }).then((result) => {
            if (result.isConfirmed) {
                eliminar_estudiante(botonEliminar.dataset.id);
            }
        });
    }
});