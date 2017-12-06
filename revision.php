
<html>
<head>
	
	<title> Administrar </title>
<?php
  include 'modelo/conectar.php';
  include 'includers/navbar.php';
?>


  <form>
    <h2>Tabla de Modelos Pendientes de Revisión</h2>
    <div class="row">

      <div class="col-md-12">
<?php


    $numeroFilas          = $conexion->preparaEjecuta("SELECT COUNT(*) FROM modelo_revision")->fetchColumn(); 
    
    if ($numeroFilas>0){



?>
        <table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Titulo</th>
      <th scope="col">Categoría</th>
      <th scope="col">Fecha</th>
      <th scope="col">Ver más</th>
    </tr>
  </thead>
  <tbody>
<?php




    foreach ($conexion->consultar('SELECT * FROM modelo_revision') as $fila) {
        $numero = 1;
        
        echo"
            <tr>
              <th scope='row'>".$numero."</th>
              <td>".$fila['titulo']."</td>
              <td>".$fila['categoria']."</td>
              <td><time class='timeago' datetime=".$fila['fecha_consulta']."></time></td>
              <td><button type='button' data-toggle='modal' data-titulo='".$fila['titulo']."' data-target='#ModalInformativo' data-modelo='".$fila['modelo']."' class='btn btn-outline-secondary btn-sm'><img src='open-iconic/svg/plus.svg'></button></td>
            </tr>
        ";
        $numero++;

    }
    echo "</tbody></table>";

    $dbh = null;
  }
  else{
    echo "<div class='offset-md-6'><h3>No hay modelos pendientes de revisión</h3></div>";
  }



?>


        
      </div>
      <!--  col-md-6   -->

      

      


    </div>
    <!--  row   -->
<div class="modal fade" id="ModalInformativo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Aprobar Entrada</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <input type="hidden" id="idModalRevision" value=""/>

          <div class="row">
            <div class="col-md-11 ml-auto">
              <div class="card" style="width: 20rem;">
                  <img class="card-img-top" id="miniaturaModalRevision" src="..." alt="Imagen">
                  <div class="card-body">
                    <p class="card-text" id="descripcionModalRevision">Aqui iria la descripcion total</p>
                  </div>
              </div>
            </div>
        </div>


        </div>
          <!-- fila body -->
      </div>
      <!-- body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="borrarRevision" data-estado="N" class="btn btn-danger">Borrar</button>
        <button type="button" id="aprobarRevision" data-estado="A" class="btn btn-success">Aprobar</button>
      </div>
    </div>
  </div>
</div>
<div class="row justify-content-md-center">
<div class="col-md-6">
<div class="alert alert-secondary" role="alert" id="mensaje" style="display:none;">
  El modelo se creó en la dirección ...
</div>
</div>
</div>


</div>

<?php
  include 'includers/footer.php';
?>
</body>
</html>