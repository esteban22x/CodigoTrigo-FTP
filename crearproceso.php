<?php
session_start();

require 'modelo/conectar.php';




if (!isset($_POST)){
    echo "NO SE HAN ENVIADO LOS CAMPOS";
    exit();
}


//Variables definidas
if (isset($_POST['titulo'])){
    $titulo         = $_POST['titulo'];
    $descripcion    = $_POST['descripcion'];
    $categoria      = $_POST['categoria'];
}

    $accion         = $_POST['accion'];
try {
    

    if ($accion=="editar"){
        

        $idModelo   = $_POST['idModelo'];
        $id_modelo  = $_POST['idReal'];
        $query = "UPDATE modelo SET id_modelo=".$id_modelo.",titulo='".$titulo."',descripcion='".$descripcion."',categoria='".$categoria."' WHERE modelo='".$idModelo."'";
        $stmt = $conexion->prepare($query);
        $stmt->execute();
        $stmt = null;
        

        echo "Modelo Correctamente Editado. Miralo <a href='./index.php?id=".$idModelo."' target='_blank'>Click aqui</a> ";


    
    }else if ($accion=="eliminar"){

        $idModelo = $_POST['idModelo'];
        $query = "DELETE FROM modelo WHERE modelo='".$idModelo."'";
        $stmt = $conexion->prepare($query);
        $stmt->execute();
        $stmt = null;

        echo "Modelo Correctamente Eliminado. Vuelve al Inicio <a href='./index.php'>Presionando aquí</a>";


        //Falta el de Eliminar

    }else if ($accion=="crear"){

        $link = $_POST['link'];

        $stmt= $conexion->prepare("INSERT INTO revision (id_revision,id_admin,estado,fecha_consulta) VALUES (NULL,NULL,'N',NOW())");
        $stmt->execute();
        $id_insertado = $conexion->lastInsertId();
        $stmt = null;


        $stmt = $conexion->prepare("INSERT INTO modelo (modelo, titulo, descripcion, categoria, id_revision) VALUES (?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $modeloU);
        $stmt->bindParam(2, $titulo);
        $stmt->bindParam(3, $descripcion);
        $stmt->bindParam(4, $categoria);
        $stmt->bindParam(5, $id_insertado);
        if (parse_url($link, PHP_URL_PATH)){
            $tokens = explode('/', $link);
            $modeloU = end($tokens);
        }else{
            echo "Lo ingresado no era un link";
            exit();
        }
        $stmt->execute();
        echo "El Modelo que has creado pasara a revisión por la administración";


    }else if ($accion=="busqueda"){

        $termino = $_POST['consulta'];
        $query = "SELECT * FROM modelo_aprobado WHERE titulo LIKE '%".$termino."%'";
        $objeto = array();
        foreach ($conexion->query($query) as $fila) {
            $objeto[] = array($fila["titulo"],$fila["modelo"]);
        }
        $objetoJson = json_encode($objeto);
        echo $objetoJson;
    }
    else if ($accion == "modal"){
        $idModelo   = $_POST['idModelo'];
        $query = "SELECT * FROM modelo_revision WHERE modelo='".$idModelo."' LIMIT 1";
        $objeto = array();
        foreach ($conexion->query($query) as $fila) {
             $objeto[] = array($fila["descripcion"],$fila["modelo"]);

         }
         $objeto = json_encode($objeto);
         echo $objeto;
    }
    else if ($accion == "revisado"){

        $estado = $_POST['estado'];
        $idAdmin = $_POST['idAdmin'];
        $estado = ($estado == 'N') ? 'R' : 'A';
        $idModelo   = $_POST['idModelo'];
        $query = "SELECT id_revision FROM modelo_revision WHERE modelo='".$idModelo."'";
        $sth = $conexion->prepare($query);
        $sth->execute();
        $revision = $sth->fetch(PDO::FETCH_OBJ)->id_revision;
        echo $revision;
        $query = "UPDATE revision SET estado='".$estado."',id_admin='".$idAdmin."' WHERE id_revision='".$revision."'";
        $stmt = $conexion->prepare($query);
        $stmt->execute();
        $stmt = null;
        

    }else if ($accion == "abreSesion"){

        $usuario    = $_POST['usuario'];
        $password   = $_POST['password'];
        $query = "SELECT COUNT(*) FROM admin WHERE usuario='".$usuario."' AND pass='".$password."'";
        $sth = $conexion->query($query)->fetchColumn();
        $objeto = array();
        if ($sth == 1){
            $objeto['estado'] = 1; 
            $_SESSION['token'] = 'abc123';
        
        }else{
            $objeto['estado'] = 0;
            $objeto['error'] = $sth; 
        }
        echo json_encode($objeto);



    }
    else if ($accion == "cierraSesion"){
        session_destroy();
        $objeto = array();
        $objeto["estado"]=1;
        echo json_encode($objeto);
    }
    else{
        echo "La accion ".$accion." no es una accion valida";
    }





$dbh = null;


} catch (Exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";

    die();
}


?>