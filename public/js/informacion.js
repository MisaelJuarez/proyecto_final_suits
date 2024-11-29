const obtener_informacion = () => {
    let data = new FormData();
    data.append('metodo','obtener_informacion');
    fetch("app/controller/usuario.php",{
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then((respuesta) => {
        document.getElementById('nombre').value = respuesta['usuario_nombre'];
        document.getElementById('apellidos').value = respuesta['usuario_apellidos'];
        document.getElementById('usuario').value = respuesta['usuario_usuario'];
    });
}

const actualizar_informacion = () => {
    let data = new FormData(document.getElementById('formulario_usuario'));
    data.append('metodo','actualizar_informacion')
    fetch("app/controller/usuario.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`, text: `${respuesta[2]}`});
            cerrar_session();
        } else {
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    })
}

document.addEventListener('DOMContentLoaded',() => {
    obtener_informacion();
});

document.getElementById('btn-actualizar').addEventListener('click',() => {
    actualizar_informacion();
});