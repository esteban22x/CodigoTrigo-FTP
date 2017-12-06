<?php
require 'modelo/conectar.php';
$modelo=$_GET['id'];
$bandera = false;


if (!isset($_GET['id'])){
    echo "ID INVALIDO";
    exit();
}
//Variables definidas
$modeloU = null;
$titulo = null;
$descripcion = null;
try {
    foreach ($conexion->consultar('SELECT * FROM modelo WHERE modelo="'.$modelo.'"') as $fila) {

        $idReal       = $fila['id_modelo'];
        $modeloU      = $fila['modelo'];
        $titulo       = $fila['titulo'];
        $descripcion  = $fila['descripcion'];
        $categoria    = $fila['categoria'];
    }


    
    
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}


?>

<html>
<head>
	
	<title> Editar Modelo </title>
<?php
  include('includers/navbar.php');
?>


  <form>
    <h2>Editar Modelo</h2>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="titulo">Titulo</label>
          <?php
            echo '<input type="text" class="form-control" value="'.$titulo.'" id="titulo">';

          ?>
          
        </div>
      </div>
      <input type="hidden" value="<?php echo $modeloU; ?>" id="idModelo">
      <input type="hidden" value="<?php echo $idReal; ?>" id="idReal">
      <!--  col-md-6   -->

      <div class="col-md-6">
        <div class="form-group">
          <label for="categoria">Categoría</label>
          <?php
            echo '<input type="text" class="form-control" value="'.$categoria.'" id="categoria">';

          ?>
        </div>
      </div>
      <!--  col-md-6   -->
    </div>


    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="descripcion">Descripción</label>
          <textarea class="form-control" id="descripcion" rows="10">
          <?php
            echo trim($descripcion);

          ?>
        </textarea>
        </div>


      </div>
      <!--  col-md-6   -->

      <div class="col-md-6">

        <div class="form-group">
          <label for="linkModelo">Link del modelo <small>http://</small></label>
          <input type="url" class="form-control" id="linkModelo" value="https://sketchfab.com/models/<?php echo $modeloU;?>" disabled>
        </div>
      </div>
      <!--  col-md-6   -->

      


    </div>
    <!--  row   -->
<button type="button" id="editar" class="btn btn-primary">Editar</button>
<button type="button" id="eliminar" class="btn btn-primary">Eliminar</button>
  </form>
<div class="row justify-content-md-center">
<div class="col-md-6">
<div class="alert alert-secondary" role="alert" id="mensaje" style="display:none;">
  
</div>
</div>
</div>


</div>
<?php
  include('includers/footer.php');

  ?>

</body>
</html>