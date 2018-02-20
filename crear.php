<html lang="es">
<head>
    <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-67509521-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-67509521-2');
</script>
	
	<title> Crear Nuevo Modelo </title>
	<?php
  include('includers/navbar.php');
  ?>
  <script src='https://www.google.com/recaptcha/api.js'></script>

  <form>
    <h2>Crear Nuevo Modelo</h2>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="titulo">Titulo</label>
          <input type="text" class="form-control" placeholder="" id="titulo">
        </div>
      </div>
      <!--  col-md-6   -->

      <div class="col-md-6">
        <div class="form-group">
          <label for="categoria">Categoría</label>
          <input type="text" class="form-control" placeholder="" id="categoria">
        </div>
      </div>
      <!--  col-md-6   -->
    </div>


    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="descripcion">Descripción</label>
          <textarea class="form-control" id="descripcion" rows="10"></textarea>
        </div>


      </div>
      <!--  col-md-6   -->

      <div class="col-md-6">

        <div class="form-group">
          <label for="linkModelo">Link del modelo <small>http://</small></label>
          <input type="url" class="form-control" id="linkModelo" placeholder="">
        </div>

        <div class="g-recaptcha" data-sitekey="6LdXWDoUAAAAAMJYx4qAIe4Ec4MhnuF6E6cNiLJx"></div>

      </div>
      <!--  col-md-6   -->

      


    </div>
    <!--  row   -->
<button id="boton" type="submit" class="btn btn-primary">Crear</button>
  </form>
<div class="row justify-content-md-center">
<div class="col-md-6">
<div class="alert alert-secondary" role="alert" id="mensaje" style="display:none;">
  El modelo se creó en la dirección ...
</div>
</div>
</div>


</div>
<?php
  include('includers/footer.php');
?>


</body>
</html>