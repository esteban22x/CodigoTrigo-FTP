<?php

//Clase conexion mysql
//Version 1.1 con MySQLi modificada por Esteban Delgado
class mysql {
    
    var $servidor = "";var $usuario = "";var $clave = "";var $base = "";var $conexion;
    var $bandera = false;
    function __construct(){
        $this->servidor = "localhost";
        $this->usuario = "root";
        $this->clave = "";
    }
    /*
     Conectar: Con los datos suministrador en el archivo conectar.php establece una conexion
     a la base de datos
    */
    function conectar()
	{

            $this->conexion = new PDO('mysql:host='.$this->servidor.';dbname='.$this->base.';charset=utf8',$this->usuario,$this->clave);
            $this->bandera = true;
            return $this->conexion;
    }
    /*
     Cerrar: Cierra la conexión previamente abierta
     Uso $conexion->cerrar();
    */
    function cerrar()
	{
        if($this->bandera)
		{
            $this->conexion->close();
        }
    }
    /*
     Consultar: Hace una consulta (query que tambien puede ser de modificacion,eliminacion o inserción) a la base de datos
     Uso: $consulta = $conexion->consultar("SELECT * FROM tabla");
    */
    function consultar($sql)
	{
        return $this->conexion->query($sql);
    }
    /*
     f_fila:Mostrara el resultado de una consulta en un array asociativo
     representado por el objeto de una fila especificada 
     Uso: $conexion->f_fila($consulta)->nombre;
    */

    function f_fila($sql)
	{
        $sth = $this->conexion->prepare($sql);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_OBJ);
    }
    /*
     f_arreglo: Mostrara el resultado de una consulta en un array asociativo
     donde el nombre de cada columna es representado por la clave dentro del array
    */

    function f_arreglo($sql)
	{
        return $sql->fetch_assoc();
    }
    /*
     f_total: Muestra el numero de filas resultantes en la consulta
     Uso: $conexion->f_total($consulta);
    */
    function f_total($sql)
	{
        return $sql->num_rows;
    }  
    /*
     liberar_consulta() cierra la conexion de una consulta especificada
     Uso : $conexion->liberar_consulta($consulta);
    */
    
    function liberar_consulta($sql)
	{
        mysqli_free_result($sql);
    }
    /*
     f_filtro: filtra caracteres indeseados que pueden ser utilizados 
     para inyecciones SQL en las variables de consulta 
     Uso: $conexion->f_filtro($cadena)
    */
    function f_filtro($cadena)
    {
        return $this->conexion->real_escape_string($cadena);
    }
    /* Este es el cambio * /
    */
    function PreparaEjecuta($sql){
        $sth = $this->conexion->prepare($sql);
        $sth->execute();
        return $sth;
    }

    function ultimoIdInsertado(){
        return $this->conexion->lastInsertId();
    }
    function preparar($sql){
        return $this->conexion->prepare($sql);
    }
    

}

?>