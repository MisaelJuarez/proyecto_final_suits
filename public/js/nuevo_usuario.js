const registrar_usuario = () => {
    let data = new FormData(document.getElementById('formulario_registro_usuario'));
    data.append('metodo','registrar_usuario');
    fetch("app/controller/usuario.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            window.location = "inicio";
        } else if(respuesta[0] == 0) {
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    })
}

document.getElementById('btn-nuevo-usuario').addEventListener('click', () => {
    registrar_usuario();
});