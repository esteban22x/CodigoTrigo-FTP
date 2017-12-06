<!DOCTYPE html>

<?php
  require '../../modelo/conectar.php';
  
?>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="esteban22x">
    <link rel="icon" href="">

    <title>Bluuee</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/new-style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    <link href="css/lightbox.min.css" rel="stylesheet">
    <link href="css/lity.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../css/jquery.auto-complete.css">
  </head>
  <body>
  <!-- Top small banner -->
  <header class="float-left w-100">
    <div class="small-top float-left w-100">
      <div class="container-fluid">
        <div class="row px-3">
          <div class="col-lg-4 date-sec">
            
          </div>
          <div class="col-lg-3 ml-auto">
            <div class="social-icon">
              
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="top-head left">
      <div class="container-fluid">
        <div class="row px-3">
          <div class="col-md-6 col-lg-4 mt-2">
            <img src="img/bluee-logo.png" width="500px" height="100px">
          </div>
          <?php

            session_start();

            if (isset($_SESSION['token']) && $_SESSION['token']=='abc123') {

          ?>
          <div class="col-md-6 col-lg-5 admin-bar ml-auto mt-2">
            <nav class="nav justify-content-end">
              <a href="#" id="cierraLink" class="nav-link">Cerrar Sesión</a>
              <a href="#" class="nav-link pr-0">Administrador<span class="ping"></span> </a> 
            </nav>
          </div>

          <?php

          }
          else{
            ?>
            <div class="col-md-6 col-lg-5 admin-bar ml-auto mt-2">
            <nav class="nav justify-content-end">
              <a href="../admin"  class="nav-link">Inicia Sesión</a>
              
            </nav>
          </div>
          <?php
            }

          ?>


          


        </div>
      </div>
    </div>
  </header>

  <!-- Top Navigation -->
  <section class="top-nav">
    <nav class="navbar navbar-expand-lg py-0">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item active"> <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a> </li>
            
            <li class="nav-item"> <a class="nav-link" href="index.php?categoria=1">Ciencia</a> </li>
            <li class="nav-item"> <a class="nav-link" href="index.php?categoria=2">Anatomia</a> </li>
            <li class="nav-item"> <a class="nav-link" href="index.php?categoria=3">Biología</a> </li>
            
          </ul>
          <form name="cuadro" class="ml-auto">
            <div class="search">
              
              <input type="text" name="busqueda" class="form-control" maxlength="64" placeholder="Buscar" />
              <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
            
            </div>
          </form>
        </div>
      </div>
    </nav>
  </section>



  <!-- Info Block-01 -->
  <section class="banner-sec float-left w-100 pt-4 pb-5">
    <div class="container-fluid">
      <div class="row px-3">
        
        <?php

        $cons = "SELECT * FROM modelo_aprobado LIMIT 4";

        if (isset($_GET['categoria']) && $_GET['categoria']>0 &&  $_GET['categoria']<4){

          switch ($_GET['categoria']) {
            case '1':
              $categoria = 'ciencia';
              break;
              case '2':
              $categoria = 'Anatomia';
              break;
              case '3':
              $categoria = 'Biologia';

            
            default:
              $categoria = 'Biologia';
              break;
          }
          $cons = "SELECT * FROM modelo_aprobado WHERE categoria='".$categoria."' LIMIT 4";


        }

         
         $contador  = 0; 
         foreach ($conexion->consultar($cons) as $fila) {
          if ($contador==0 || $contador==2){
            echo '<div class="col-md-3">';
          } 


          
          $contenido = json_decode(file_get_contents('https://sketchfab.com/oembed?url=https://sketchfab.com/models/'.$fila['modelo']),true);
          

           
        ?>

        
          <div class="card mb-4"> <img class="img-fluid" src="<?php echo $contenido['thumbnail_url']; ?>" alt="<?php echo $fila['titulo']; ?>">
            <div class="card-img-overlay"> 
              <span class="badge badge-pill badge-danger"><?php echo $fila['categoria']; ?></span> 
            </div>
            <div class="card-body p-2">
              <div class="news-title">
                <h2 class=" title-small"><a href="../../index.php?id=<?php echo $fila['modelo']; ?>"><?php echo $fila['titulo']; ?></a></h2>
              </div>
              <p class="card-text"><small class="text-time"></small></p>
            </div>
          </div>
          <?php
            
            if ($contador==1 || $contador==3){
              echo '</div>';
            }
            $contador++;
          }
          ?> 
        

        <div class="col-md-6 top-slider">
          <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"> 
            <!-- Indicators -->
            <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <div class="news-block">
                  <div class="news-media"><img class="img-fluid" src="img/motor.jpeg" alt=""></div>
                  <div class="news-title">
                    <h2 class=" title-large"><a href="#">Aprender nunca fue tan entretenido</a></h2>
                  </div>
                  <div class="news-des">Tener una animación 3D para aprender es ahora la mejor forma de tener un aprendizaje interactivo</div>
                  <div class="time-text"><strong>Razón 1/3 para querer Bluuee</strong></div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="news-block">
                  <div class="news-media"><img class="img-fluid" src="img/mariposa.jpeg" alt=""></div>
                  <div class="news-title">
                    <h2 class=" title-large"><a href="#">Tú Puedes aumentar el catalogo</a></h2>
                  </div>
                  <div class="news-des">Como una Wiki pero interactivamente todos pueden colaborar para ayudar a crecer Bluuee. Después se seleccionarán los mejores</div>
                  <div class="time-text"><strong>Razón 2/3 para querer Bluuee</strong></div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="news-block">
                  <div class="news-media"><img class="img-fluid" src="img/celula.png" alt=""></div>
                  <div class="news-title">
                    <h2 class=" title-large"><a href="#">Cuéntanos Tú</a></h2>
                  </div>
                  <div class="news-des">Comienza a explorar..</div>
                  <div class="time-text"><strong>Razón 3/3 para querer Bluuee</strong></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- widget block -->
  <section class="widget-block flasher-sec float-left w-100">
    <div class="container-fluid">
      <div class="row px-3">
        <div class="col-md-2 pr-0">
          <div class="heading-box">Tips para Aprender</div>
        </div>
        <div class="col-md-10 pl-0">
            <div class="content-box">
              <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <span class="time-box">1.</span>Todo modelo ingresado pasará a revisión por un moderador
                  </div>
                  <div class="carousel-item">
                    <span class="time-box">2.</span>Los modelos deben ser puestos en su correspondiente categoría
                  </div>
                  <div class="carousel-item">
                    <span class="time-box">3.</span>Cada persona puede subir hasta 50 modelos por día para evitar Spam
                  </div>
                  
                </div>
                <div class="control-box">
                  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                    <span class="sr-only">Anterior</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                    <span class="sr-only">Siguiente</span>
                  </a>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </section>


  <!-- Footer Section -->
  <footer>
    <div class="container-fluid">
      <div class="row px-3">
        <div class="col-lg-4 col-md-12">
          <h6 class="heading-footer">Sobre Nosotros</h6>
          <p>Bluee es un proyecto educativo </p>
          
          <p><i class="fa fa-envelope"></i> <span>Email :</span> </p>
        </div>
        <div class="col-lg-2 col-md-4">
          
        </div>
        <div class="col-lg-4 col-md-4">
          
        </div>
        <div class="col-lg-2 col-md-4 social-icons">
          <h6 class="heading-footer">Redes Sociales</h6>
          <ul class="footer-ul">
            <li><a href="#"><i class=" fa fa-facebook"></i> Facebook</a></li>
            <li><a href="#"><i class=" fa fa-twitter"></i> Twitter</a></li>
            
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- Copy footer start from here-->
  <div class="copyright">
    <div class="container-fluid">
      <div class="row px-3">
        <div class="col-lg-6 col-md-4">
          <p>© 2017</p>
        </div>
        <div class="col-lg-6 col-md-8">
          <ul class="bottom_ul">
            
          </ul>
        </div>
      </div>
    </div>
  </div>

<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="js/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
<script src="js/popper.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/core.js"></script>
<script src="js/lightbox-plus-jquery.min.js"></script> 
<script src="js/lity.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="../admin/js/script.js"></script>
<script type="text/javascript" src="../../js/jquery.timeago.js"></script>
<script type="text/javascript" src="../../js/jquery.auto-complete.min.js"></script>
<script type="text/javascript" src="../../js/crear.js"></script>

</body>
</html>