<?php
 
 include ("mysql.php");

 //Cambiar el true por false si es un MySQL Nuevo (Por ejemplo XAMPP Recien Instalado) 
 $conexionDefectoA 	= false;

 //Conectamos con mysql
 $conexion = new mysql;
 $conexion->base 	= "codigotrigo";
 if ($conexionDefectoA){
 	$conexion->servidor	= "mysql.hostinger.co";
 	$conexion->usuario	= "u703085342_devel";
 	$conexion->clave 	= "W/1H!KpEcDNI";
 }
 $conexion->conectar();
 
?>