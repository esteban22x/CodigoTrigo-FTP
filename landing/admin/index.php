<html>
<head>
  <title>Bluuee</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<body>

  <div class="container">


  <div class="login-logo off-canvas">
    <a href="../inicio/index.php"><img src="../inicio/img/bluee-logo.png" alt="Bluuee" width="320px" height="120px"></a>
  </div>
  
  <div class="form-container off-canvas">

     <?php
      session_start();
      if (isset($_SESSION['token']) && $_SESSION['token']=='abc123') {
        echo "<h2>Sesión ya iniciada</h2>";
        echo '<button class="btn btn-md btn-danger " id="cerrarSesion">Cerrar Sesión</button>';

      }
      else{

    ?>
  

    <form name="form-login" role="form" class="form-signin">
      <h2>Inicio de Sesión</h2>

      <div class="form-group">
        <label for="EmailAddress"><span>*</span> Usuario</label>
        <input type="email" class="form-control" name="EmailAddress" id="usuario" aria-required="true" aria-invalid="true" required>
      </div>

      <div class="form-group">
        <label for="EmailAddress"><span>*</span> Contraseña</label>
        <input type="password" class="form-control" name="password" id="password" aria-required="true" aria-invalid="true" required>
      </div>

      <div class="checkbox">
        <label>
          <input type="checkbox" value="remember-me"> Recuerdame
        </label>
      </div>

      <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar Sesión</button>

    </form>
    <?php
      }
    ?>
  </div> <!-- /container -->
  
</div>

</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</html>