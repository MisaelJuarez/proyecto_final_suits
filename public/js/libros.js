let tabla, id_libro, id_alumno;
const modal = document.getElementById('modalPrestar');

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
                    { data: 'libro_estado',
                        render: (data,type,row) => (row.libro_cantidad!=0) ? `<span class="badge bg-success">${data}</span>` : `<span class="badge bg-danger">${data}</span>`
                     }, 
                    {
                        data: 'libro_id',
                        render: (data,type,row) => {
                            if (row.libro_cantidad != 0) {
                                return `
                                    <button class="btn btn-info prestamo" data-bs-toggle="modal" data-bs-target="#modalPrestar"
                                        data-id="${data}" 
                                        data-titulo="${row.libro_titulo}" 
                                        data-autor="${row.libro_autor}" 
                                        data-categoria="${row.libro_categoria}" 
                                        
                                    >
                                        Prestar
                                    </button>
                                `;
                            }else {
                                return '';
                            }
                        }
                        }
                ],
                "lengthChange": false,
                "pageLength": 5,
                language: { url: "./public/json/lenguaje.json" }
            });
        }
    });
};

const buscar_Alumno = (nControl) => {
    let data = new FormData();

    data.append('nControl', `${nControl}`);
    data.append('metodo', 'buscar_alumno');
    
    fetch("app/controller/estudiantes.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then((respuesta) => {
        if (respuesta[0] == 1) {
            id_alumno = respuesta[1]['estudiante_id'];
            document.getElementById('estudiante-nombre').textContent = respuesta[1]['estudiante_nombre'];
            document.getElementById('estudiante-apellidos').textContent = respuesta[1]['estudiante_apellidos'];
            document.getElementById('estudiante-carrera').textContent = respuesta[1]['estudiante_carrera'];
            document.getElementById('nControl').value = '';
        }else if(respuesta[0] == 0){
            Swal.fire({icon: "info",title:`${respuesta[1]}`, text:'Alparecer el alumno no esta registrado',footer: '<a href="estudiantes">Registrar Alumno</a>'});
        }
    });
}

const prestamo_libro = () => {
    let data = new FormData();
    data.append('metodo','prestar_libro');
    data.append('fecha_prestamo', document.getElementById('fecha_prestamo').value);
    data.append('fecha_entrega', document.getElementById('fecha_entrega').value);
    data.append('id_estudiante', `${id_alumno}`);
    data.append('id_libro', `${id_libro}`);
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            const modalPrestar = bootstrap.Modal.getInstance(modal); 
            document.getElementById('estudiante-nombre').textContent = '';
            document.getElementById('estudiante-apellidos').textContent = '';
            document.getElementById('estudiante-carrera').textContent = '';
            document.getElementById('fecha_prestamo').value = '';
            document.getElementById('fecha_entrega').value = '';
            if (modalPrestar){
                modalPrestar.hide();
            }  
            obtener_datos();
        } else if(respuesta[0] == 0) {
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    })
}

document.addEventListener('DOMContentLoaded', () => {
    obtener_datos();
});

document.getElementById('myTable').addEventListener('click', (e) => {
    if (e.target.matches('.prestamo')) {
        id_libro = e.target.dataset.id;
        document.getElementById('titulo-libro').textContent = e.target.dataset.titulo;
        document.getElementById('autor-libro').textContent = e.target.dataset.autor;
        document.getElementById('categoria-libro').textContent = e.target.dataset.categoria;
    }
});

document.getElementById('buscar-alumno').addEventListener('click', () => {
    buscar_Alumno(document.getElementById('nControl').value);
});

document.getElementById('prestar-libro').addEventListener('click', () => {
    if (id_alumno) {
        prestamo_libro();
    }else {
        Swal.fire({icon: "info",title:'Aun no seleccionas un alumno'});
    }
});