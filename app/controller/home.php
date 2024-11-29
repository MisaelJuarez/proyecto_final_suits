<?php
require_once '../config/conexion.php';

class Home extends Conexion {
    public function obtener_datos() {
        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_libros");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }
    
    public function registrar_libro() {
        if (isset($_POST['titulo']) && !empty($_POST['titulo']) && 
            isset($_POST['autor']) && !empty($_POST['autor']) && 
            isset($_POST['categoria']) && !empty($_POST['categoria']) && 
            isset($_POST['publicacion']) && !empty($_POST['publicacion']) &&
            isset($_POST['editorial']) && !empty($_POST['editorial']) &&
            isset($_POST['cantidad']) && !empty($_POST['cantidad']))  {
            
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $categoria = $_POST['categoria'];
            $publicacion = $_POST['publicacion'];
            $editorial = $_POST['editorial'];
            $cantidad = $_POST['cantidad'];

            if (is_numeric($autor)) {
                echo json_encode([0,"No puedes ingresar numeros en autor"]);
            } else if(!is_numeric($publicacion)){
                echo json_encode([0,"Ingresa el año de publicacion"]);
            } else if(!is_numeric($cantidad)){
                echo json_encode([0,"Ingresa solo numeros en cantidad"]);
            } else if($cantidad <= 0){
                echo json_encode([0,"Solo numeros positivos en cantidad"]);
            } else {
                $insercion = $this->obtener_conexion()->prepare("INSERT INTO t_libros (libro_titulo,libro_autor,libro_categoria,
                                                                libro_publicacion, libro_editorial,libro_cantidad,libro_estado) 
                VALUES(:titulo,:autor,:categoria,:publicacion,:editorial,:cantidad,'disponible')");
                
                $insercion->bindParam(':titulo',$titulo);
                $insercion->bindParam(':autor',$autor);
                $insercion->bindParam(':categoria',$categoria);
                $insercion->bindParam(':publicacion',$publicacion);
                $insercion->bindParam(':editorial',$editorial);
                $insercion->bindParam(':cantidad',$cantidad);
                $insercion->execute();
                $this->cerrar_conexion();

                if ($insercion) {
                    echo json_encode([1,"Libro registrado"]);
                } else {
                    echo json_encode([0,"Libro NO registrado"]);
                }
            }

        } else {
            echo json_encode([0,"No puedes dejar campos vacios"]);
        }
    }

    public function prestar_libro() {
        if (isset($_POST['fecha_prestamo']) && !empty($_POST['fecha_prestamo']) && 
            isset($_POST['fecha_entrega']) && !empty($_POST['fecha_entrega']) && 
            isset($_POST['id_estudiante']) && !empty($_POST['id_estudiante']) && 
            isset($_POST['id_libro']) && !empty($_POST['id_libro']))  {

            $prestamo = $_POST['fecha_prestamo'];
            $entrega = $_POST['fecha_entrega'];
            $id_estudiante = $_POST['id_estudiante'];
            $id_libro = $_POST['id_libro'];

            $insercion = $this->obtener_conexion()->prepare("INSERT INTO t_prestamo (prestamo_fPrestamo,prestamo_fEntrega,
                                                            id_estudiante,id_libro) 
            VALUES(:prestamo,:entrega,:id_estudiante,:id_libro)");

            $insercion->bindParam(':prestamo',$prestamo);
            $insercion->bindParam(':entrega',$entrega);
            $insercion->bindParam(':id_estudiante',$id_estudiante);
            $insercion->bindParam(':id_libro',$id_libro);
            $insercion->execute();
            $this->cerrar_conexion();
            
            $cantidad = $this->obtener_conexion()->prepare("UPDATE t_libros SET libro_cantidad = libro_cantidad - 1 
                                                                WHERE libro_id = :id_libro");
            $cantidad->bindParam(':id_libro',$id_libro);
            $cantidad->execute();
            $this->cerrar_conexion();

            $consulta = $this->obtener_conexion()->prepare("SELECT libro_cantidad FROM t_libros WHERE libro_id = :id_libro");
            $consulta->bindParam(':id_libro',$id_libro);
            $consulta->execute();
            $cantidadLibros = $consulta->fetch(PDO::FETCH_ASSOC);
            $this->cerrar_conexion();
            
            if ($cantidadLibros['libro_cantidad'] == 0) {
                $estado = $this->obtener_conexion()->prepare("UPDATE t_libros SET libro_estado = 'prestado' 
                                                            WHERE libro_id = :id_libro");
                $estado->bindParam(':id_libro',$id_libro);
                $estado->execute();
                $this->cerrar_conexion();
            }


            if ($insercion) {
                echo json_encode([1,"Libro prestado"]);
            } else {
                echo json_encode([0,"El libro no se pudo prestar"]);
            }

        } else {
            echo json_encode([0,"No puedes dejar campos vacios"]);
        }
    }

    public function editar_libro() {
        $id = $_POST['id'];
        $titulo = $_POST['titulo-editar'];
        $autor = $_POST['autor-editar'];
        $categoria = $_POST['categoria-editar'];
        $publicacion = $_POST['publicacion-editar'];
        $editorial= $_POST['editorial-editar'];
        $cantidad= $_POST['cantidad-editar'];

        if (empty($titulo) || empty($autor) || empty($categoria) || 
            empty($publicacion) || empty($editorial) || empty($cantidad)) {
            echo json_encode([0,"Campos incompletos"]);
        } else if (is_numeric($autor)) {
            echo json_encode([0,"No puedes ingresar numeros en autor"]);
        } else if(!is_numeric($publicacion)){
            echo json_encode([0,"Ingresa el año de publicacion"]);
        } else if(!is_numeric($cantidad)){
            echo json_encode([0,"Ingresa solo numeros en cantidad"]);
        } else if($cantidad <= 0){
            echo json_encode([0,"Solo numeros positivos en cantidad"]);
        } else {

            $actualizacion = $this->obtener_conexion()->prepare("UPDATE t_libros 
            SET libro_titulo = :titulo, libro_autor = :autor, libro_categoria = :categoria, 
                libro_publicacion = :publicacion, libro_editorial = :editorial, libro_cantidad = :cantidad   
            WHERE libro_id = :id");
            
            $actualizacion->bindParam(':titulo',$titulo);
            $actualizacion->bindParam(':autor',$autor);
            $actualizacion->bindParam(':categoria',$categoria);
            $actualizacion->bindParam(':publicacion',$publicacion);
            $actualizacion->bindParam(':editorial',$editorial);
            $actualizacion->bindParam(':cantidad',$cantidad);
            $actualizacion->bindParam(':id',$id);
            $actualizacion->execute();
            $this->cerrar_conexion();
            echo json_encode([1,"Libro actualizado"]);
        }
    }

    public function eliminar_libro() {
        $id = $_POST['id'];

        $eliminar = $this->obtener_conexion()->prepare("DELETE FROM t_libros WHERE libro_id = :id");
        $eliminar->bindParam(':id',$id);
        $eliminar->execute();
        $this->cerrar_conexion();
        if ($eliminar) {
            echo json_encode([1,'Libro eliminado']);
        } else {
            echo json_encode([0,'Error al eliminar el libro']);
        }
    }

    public function obtener_datos_prestamo() {
        $consulta_prestamo = $this->obtener_conexion()->prepare("SELECT 
            t_prestamo.prestamo_id,
            t_prestamo.prestamo_fPrestamo,
            t_prestamo.prestamo_fEntrega,
            t_estudiantes.estudiante_id,
            t_estudiantes.estudiante_nombre,
            t_estudiantes.estudiante_apellidos,
            t_estudiantes.estudiante_semestre,
            t_estudiantes.estudiante_carrera,
            t_estudiantes.estudiante_nControl,
            t_estudiantes.estudiante_telefono,
            t_libros.libro_id,
            t_libros.libro_titulo,
            t_libros.libro_autor,
            t_libros.libro_categoria,
            t_libros.libro_editorial
            FROM 
                t_prestamo
            JOIN 
                t_estudiantes ON t_prestamo.id_estudiante = t_estudiantes.estudiante_id
            JOIN 
                t_libros ON t_prestamo.id_libro = t_libros.libro_id;");
        
        $consulta_prestamo->execute();
        $datos_prestamo = $consulta_prestamo->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos_prestamo);
    }

    public function libro_devuelto() {
        $id_prestamo = $_POST['id'];
        $id_libro = $_POST['id_libro'];

        $eliminar = $this->obtener_conexion()->prepare("DELETE FROM t_prestamo WHERE prestamo_id = :id");
        $eliminar->bindParam(':id',$id_prestamo);
        $eliminar->execute();
        $this->cerrar_conexion();

        $cantidad = $this->obtener_conexion()->prepare("UPDATE t_libros SET libro_cantidad = libro_cantidad + 1 
                                                                WHERE libro_id = :id_libro");
        $cantidad->bindParam(':id_libro',$id_libro);
        $cantidad->execute();
        $this->cerrar_conexion();

        $estado = $this->obtener_conexion()->prepare("UPDATE t_libros SET libro_estado = 'disponible' 
                                                            WHERE libro_id = :id_libro");
        $estado->bindParam(':id_libro',$id_libro);
        $estado->execute();
        $this->cerrar_conexion();

        if ($eliminar) {
            echo json_encode([1,'Libro devuelto correctamente']);
        } else {
            echo json_encode([0,'Error al devolver el libro']);
        }
    }

    public function cambiar_fecha() {
        if (isset($_POST['fecha-cambiar']) && !empty($_POST['fecha-cambiar']))  {

            $fecha = $_POST['fecha-cambiar'];
            $id = $_POST['id_prestamo'];

            $insercion = $this->obtener_conexion()->prepare("UPDATE t_prestamo SET prestamo_fEntrega = :fecha 
                                                            WHERE prestamo_id = :id");
            $insercion->bindParam(':fecha',$fecha);
            $insercion->bindParam(':id',$id);
            $insercion->execute();
            $this->cerrar_conexion();
            if ($insercion) {
                echo json_encode([1,"Fecha Actualizada"]);
            } else {
                echo json_encode([0,"Error al actualizar fecha"]);
            }
            

        } else {
            echo json_encode([0,"No puedes dejar campos vacios"]);
        }
    }
}

$consulta = new Home();
$metodo = $_POST['metodo'];
$consulta->$metodo();
?>