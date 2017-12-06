<?php
require 'modelo/conectar.php';
$modelo=$_GET['id'];
$bandera = false;

if (isset($_COOKIE['token']) && $_COOKIE['token']=="abc123"){

    $bandera = true;

}
if (!isset($_GET['id'])){
    header('Location: landing/inicio/index.php');
    exit();
}
//Variables definidas
$modeloU = null;
$titulo = null;
$descripcion = null;
try {
    foreach ($conexion->f_arreglo('SELECT * FROM modelo_aprobado WHERE modelo="'.$modelo.'"') as $fila) {
        $modeloU      = $fila['modelo'];
        $titulo       = $fila['titulo'];
        $descripcion  = $fila['descripcion'];
        $categoria    = $fila['categoria'];
        $siguiente    = $fila['id_modelo'];
    }
    foreach ($conexion->f_arreglo('SELECT * FROM modelo_aprobado WHERE id_modelo > '.$siguiente.' ORDER BY id_modelo LIMIT 1') as $fila) {
        $modeloUSiguiente     = $fila['modelo'];
        $tituloSiguiente      = $fila['titulo'];
        
    }
    if (!isset($modeloUSiguiente)){
      $sth = $dbh->prepare("SELECT * FROM modelo_aprobado WHERE id_modelo < '".$siguiente."' ORDER BY id_modelo LIMIT 1");
      $sth->execute();
      $res = $sth->fetch(PDO::FETCH_OBJ);
      $modeloUSiguiente = $res->modelo;
      $tituloSiguiente = $res->titulo;
    }

    $dbh = null;

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}


?>

<html>
<head>
	   <title> <?php echo $titulo; ?> </title>
<?php 
  include('./includers/navbar.php');
?>
</div>
<input type="hidden" value="<?php echo $modeloUSiguiente; ?>" id="modeloSiguiente"/>
  <input type="hidden" value="<?php echo $tituloSiguiente; ?>" id="tituloSiguiente"/>
	<div id="visor-animacion">

		<div class="sketchfab-embed-wrapper">
            <?php
                echo '<iframe id="animacion" src="https://sketchfab.com/models/'.$modeloU.'/embed?ui_controls=0&ui_theatre=0&ui_stop=0&ui_help=0&ui_settings=0&ui_fullscreen=0&ui_watermark=0&ui_annotations=0&scrollwheel=0&ui_snapshots=0&ui_animations=0&internal=1&autostart=1&ui_infos=0&sound_enable=0&ui_fadeout=0&transparent=1"  width="500" height="300" allowtransparency="true" allowvr="" allowfullscreen="" mozallowfullscreen="true" webkitallowfullscreen="true" onmousewheel="">
            </iframe>';

            ?>

			

	</div>


	<div class="sidebar">

        <p>

        </p>

                
            

		<h5><?php echo $titulo; ?></h5>

            <div class="contenido-sidebar">

                <p>
                    <?php echo $descripcion; ?>
                </p>
                <p>

                    <b>Categoría:</b>

                    <span class="badge badge-pill badge-info"><?php echo $categoria; ?></span>

                    

                    
             
                </p>


            </div>



		

	</div>

    <div class="containerImg">
  <div class="div-img" >
    <a id="linkFoto5" href="">
    <img class="img" id="Foto5" src="" title="Foto5" alt="Foto5"></a>
    <div class="text"></div>
  </div>
</div>




</body>
<?php
  include('includers/footer.php');
?>

</html>