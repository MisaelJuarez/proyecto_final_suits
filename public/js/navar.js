const cerrar_session = () => {
    fetch("app/controller/cerrar_sesion.php")
    .then(respuesta => respuesta.json())
    .then(async (respuesta) => {
        await Swal.fire({icon: "success",title:`${respuesta[1]}`});
        window.location = "login";
    });
}

document.getElementById('cerrar_session').addEventListener('click',() => {
    cerrar_session();
});