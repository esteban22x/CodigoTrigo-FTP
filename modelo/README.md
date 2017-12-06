# Modelo PHP
##Modelo de Conexion MySQLi

Es un modelo de conexión con MySQLi para agilizar métodos simples como: 
- Hacer Consultas
- Consultar Resultado de una Fila
- Devolver todos los resultados de una consulta
- Consultar el número total de resultados
- Liberar Consultas
- Cerrar Conexión

##Comienzo Básico:
Se debe iniciar llenando los datos especficos de conexión en el archivo *conectar.php*, si quieres entrar a un MySQL
con sus datos por defecto se debe poner la variable $conexionDefectoA en false, solo poner el nombre de la base de datos
en la variable $conexion->base y ya. 

##Inclusión
Para incluirlo se puede recurrir al require , include, include_once o require_once 

Ejemplo:

```
<?php
  require 'modelo/conectar.php';
  $conecto = $conexion->consultar("SELECT * FROM tabla");
?>

```
