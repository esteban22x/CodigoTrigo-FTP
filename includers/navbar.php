	
    <!-- ESTILOS DE CSS -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	  <link rel="stylesheet" type="text/css" href="css/indice.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.auto-complete.css">
    <link rel="stylesheet" type="text/css" href="css/crear.css">
    <!-- FIN DE ESTILOS CSS -->

</head>
<body>

  
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="landing/inicio/index.php">Bluuee</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      
      <li class="nav-item">
        <a class="nav-link" href="crear.php">Agregar</a>

      </li>
      <?php
        session_start();

        if (isset($_SESSION['token']) && $_SESSION['token']=='abc123'){

          if (isset($modeloU)){

      ?>

      <li class="nav-item">
        <a class="nav-link" href="editar.php?id=<?php echo $modeloU; ?>">Modificar</a>
      <?php
          }

      ?>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="revision.php">Revisar</a>

      </li>
      <?php

      }

      ?>
      
    </ul>
    <form name="busca-modelo" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" name="busqueda" placeholder="Busca Modelo" aria-label="Search">
      
    </form>
  </div>
</nav>
<div id="container">