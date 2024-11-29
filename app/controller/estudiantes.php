<?php
require_once '../config/conexion.php';

class Estudiante extends Conexion {
    public function obtener_datos() {
        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_estudiantes");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }

    public function registrar_estudiante() {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $semestre = $_POST['semestre'];
        $carrera = $_POST['carrera'];
        $nControl = $_POST['nControl'];
        $telefono = $_POST['telefono'];

        if (empty($nombre) || empty($apellidos) || empty($semestre) || 
            empty($carrera) || empty($nControl) || empty($telefono)) {
            echo json_encode([0,"Campos incompletos"]);
        } else if (is_numeric($nombre) || is_numeric($apellidos)) {
            echo json_encode([0,"No puedes ingresar numeros en nombre y apellidos"]);
        } else if(!is_numeric($nControl)){
            echo json_encode([0,"Ingresa solo nuemeros en numero de control"]);
        } else if(!is_numeric($telefono)){
            echo json_encode([0,"Ingresa solo numeros en telefono"]);
        } else {
            $insercion = $this->obtener_conexion()->prepare("INSERT INTO t_estudiantes (estudiante_nombre,estudiante_apellidos,
                            estudiante_semestre,estudiante_carrera,estudiante_nControl,estudiante_telefono) 
                VALUES(:nombre,:apellidos,:semestre,:carrera,:nControl,:telefono)");
                
            $insercion->bindParam(':nombre',$nombre);
            $insercion->bindParam(':apellidos',$apellidos);
            $insercion->bindParam(':semestre',$semestre);
            $insercion->bindParam(':carrera',$carrera);
            $insercion->bindParam(':nControl',$nControl);
            $insercion->bindParam(':telefono',$telefono);
            $insercion->execute();
            $this->cerrar_conexion();

            if ($insercion) {
                echo json_encode([1,"Estudiante registrado"]);
            } else {
                echo json_encode([0,"Estudiante NO registrado"]);
            }
        }
    }

    public function editar_estudiante() {
        $id = $_POST['id'];
        $nombre = $_POST['nombre-editar'];
        $apellidos = $_POST['apellidos-editar'];
        $semestre = $_POST['semestre-editar'];
        $carrera = $_POST['carrera-editar'];
        $nControl = $_POST['nControl-editar'];
        $telefono = $_POST['telefono-editar'];

        if (empty($nombre) || empty($apellidos) || empty($semestre) || 
            empty($carrera) || empty($nControl) || empty($telefono)) {
            echo json_encode([0,"Campos incompletos"]);
        } else if (is_numeric($nombre) || is_numeric($apellidos)) {
            echo json_encode([0,"No puedes ingresar numeros en nombre y apellidos"]);
        } else if(!is_numeric($nControl)){
            echo json_encode([0,"Ingresa solo nuemeros en numero de control"]);
        } else if(!is_numeric($telefono)){
            echo json_encode([0,"Ingresa solo numeros en telefono"]);
        } else {

            $actualizacion = $this->obtener_conexion()->prepare("UPDATE t_estudiantes 
            SET estudiante_nombre = :nombre,estudiante_apellidos = :apellidos,estudiante_semestre = :semestre, 
                estudiante_carrera = :carrera,estudiante_nControl = :nControl,estudiante_telefono = :telefono   
            WHERE estudiante_id = :id");
            
            $actualizacion->bindParam(':nombre',$nombre);
            $actualizacion->bindParam(':apellidos',$apellidos);
            $actualizacion->bindParam(':semestre',$semestre);
            $actualizacion->bindParam(':carrera',$carrera);
            $actualizacion->bindParam(':nControl',$nControl);
            $actualizacion->bindParam(':telefono',$telefono);
            $actualizacion->bindParam(':id',$id);
            $actualizacion->execute();
            $this->cerrar_conexion();
            echo json_encode([1,"Estudiante actualizado"]);
        }
    }

    public function eliminar_estudiante() {
        $id = $_POST['id'];

        $eliminar = $this->obtener_conexion()->prepare("DELETE FROM t_estudiantes WHERE estudiante_id = :id");
        $eliminar->bindParam(':id',$id);
        $eliminar->execute();
        $this->cerrar_conexion();
        if ($eliminar) {
            echo json_encode([1,'Estudiante eliminado']);
        } else {
            echo json_encode([0,'Error al eliminar el Estudiante']);
        }
    }

    public function buscar_alumno() {
        if (isset($_POST['nControl']) && !empty($_POST['nControl']) ){
            $nControl = $_POST['nControl'];

            $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_estudiantes WHERE estudiante_nControl = :nControl");
            $consulta->bindParam(':nControl',$nControl);
            $consulta->execute();
            $datos = $consulta->fetch(PDO::FETCH_ASSOC);
            $this->cerrar_conexion();

            if ($datos) {
                echo json_encode([1,$datos]);
            }else {
                echo json_encode([0,'Numero de control no encontrado']);
            }
        } else {
            echo json_encode([0,'Ingrese el numero de control']);
        }
    }
}

$consulta = new Estudiante();
$metodo = $_POST['metodo'];
$consulta->$metodo();
?>