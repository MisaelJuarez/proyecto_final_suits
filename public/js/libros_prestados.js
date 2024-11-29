let tabla;
const modal = document.getElementById('cambio-fecha');

const obtener_datos = () => {
    let data = new FormData();
    data.append('metodo', 'obtener_datos_prestamo');
    
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
                    { data: 'estudiante_nombre' },
                    { data: 'estudiante_apellidos' },
                    { data: 'libro_titulo' },
                    {
                        data: 'prestamo_fPrestamo',
                        render: function(data) {
                            const fecha = data.split('-');
                            return `${fecha[2]}-${fecha[1]}-${fecha[0]}`;
                        }
                    },
                    {
                        data: 'prestamo_fEntrega',
                        render: function(data, type, row) {
                            const fecha = data.split('-');
                            const fechaFormateada = `${fecha[2]}-${fecha[1]}-${fecha[0]}`;
                            return `
                                ${fechaFormateada}
                                <button type="button" class="btn btn-warning cambiar-fecha" data-bs-toggle="modal" 
                                    data-bs-target="#cambio-fecha"
                                    data-id="${row.prestamo_id}" 
                                    data-fecha="${row.prestamo_fEntrega}"
                                >
                                        <i class="bi bi-calendar-week cambiar-fecha" data-id="${row.prestamo_id}"
                                            data-fecha="${row.prestamo_fEntrega}"
                                        >
                                        </i>
                                </button>
                            `;
                        }
                    },
                    {
                        data: 'prestamo_id',
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-info mas-informacion" data-btn="mas-informacion" 
                                        data-bs-toggle="modal" data-bs-target="#mas-informacion"
                                        data-id="${data}" 
                                        data-nombre="${row.estudiante_nombre}"
                                        data-apellidos="${row.estudiante_apellidos}"
                                        data-ncontrol="${row.estudiante_nControl}"
                                        data-carrera="${row.estudiante_carrera}"
                                        data-semestre="${row.estudiante_semestre}"
                                        data-telefono="${row.estudiante_telefono}"

                                        data-titulo="${row.libro_titulo}"
                                        data-autor="${row.libro_autor}"
                                        data-editorial="${row.libro_editorial}"
                                >
                                    Mas informacion
                                </button>
                                <button class="btn btn-secondary devuelto" data-btn="devuelto" 
                                        data-id="${data}" 
                                        data-id_libro="${row.libro_id}"
                                >
                                    Devuelto
                                </button>
                            `;
                        }
                    }
                ],
                "lengthChange": false,
                "info": false,
                "pageLength": 5,
                language: { url: "./public/json/lenguaje.json" }
            });            
        }
    });
};

const libro_devuelto = (id_prestamo,id_libro) => {
    let data = new FormData();
    data.append('id',id_prestamo);
    data.append('id_libro',id_libro);
    data.append('metodo','libro_devuelto')
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

const cambiar_fecha = (id_prestamo) => {    
    let data = new FormData(document.getElementById('formulario-cambiar-fecha'));
    data.append('id_prestamo',id_prestamo);
    data.append('metodo','cambiar_fecha');
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            const modalFecha = bootstrap.Modal.getInstance(modal); 
            if (modalFecha) modalFecha.hide(); 
            obtener_datos();
        } else if(respuesta[0] == 0) {
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    })
}

document.addEventListener('DOMContentLoaded', () => {
    obtener_datos();
});

document.getElementById('contenedor-tabla').addEventListener('click', (e) => { 
    if (e.target.matches('.mas-informacion')) {        
        document.getElementById('nombre_estudiante').textContent = e.target.dataset.nombre;
        document.getElementById('apellidos_estudiante').textContent = e.target.dataset.apellidos;
        document.getElementById('nControl_estudiante').textContent = e.target.dataset.ncontrol;
        document.getElementById('carrera_estudiante').textContent = e.target.dataset.carrera;
        document.getElementById('semestre_estudiante').textContent = e.target.dataset.semestre;
        document.getElementById('telefono_estudiante').textContent = e.target.dataset.telefono;

        document.getElementById('titulo_libro').textContent = e.target.dataset.titulo;
        document.getElementById('autor_libro').textContent = e.target.dataset.autor;
        document.getElementById('editorial_libro').textContent = e.target.dataset.editorial;
    }
    if (e.target.matches('.devuelto')) {
        Swal.fire({
            icon: "warning",
            text: "Confirmas que la persona devolvio el libro",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, lo devolvio"
          }).then((result) => {
            if (result.isConfirmed) {
                libro_devuelto(e.target.dataset.id,e.target.dataset.id_libro);
            }
        });
    }

    if (e.target.matches('.cambiar-fecha')) {
        document.getElementById('fecha-cambiar').value = e.target.dataset.fecha;
        document.getElementById('cambiar-fecha').dataset.id = e.target.dataset.id;
    }
});

document.getElementById('cambio-fecha').addEventListener('click',(e) => {
    if (e.target.classList.contains('cambiar')) {
        cambiar_fecha(e.target.dataset.id);
    }
});
