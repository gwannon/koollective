<?php
/*
Template Name: Koollective
*/
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Movimiento KOOLLECTIVE</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
    integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
    crossorigin="anonymous"></script>
  <!--<link rel="stylesheet" href="style.css">-->
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet" />
  <link href="images/favicon.png" rel="icon" />
  <script>
    $(document).ready(function () {
      var menu = $('.menu');
      var origOffsetY = menu.offset().top;

      function scroll() {
        if ($(window).width() >= 768) {
          if ($(window).scrollTop() >= origOffsetY) {
            menu.addClass('sticky');
          } else {
            menu.removeClass('sticky');
          }
        } else {
          // Si la resolución es menor, quitamos la clase sticky
          menu.removeClass('sticky');
        }
      }

      // Ejecutar al hacer scroll
      $(document).on('scroll', scroll);

      // Ejecutar al redimensionar la ventana
      $(window).on('resize', scroll);

      // Ejecutar al cargar la página
      scroll();
    });
  </script>
  <script>


    $(document).ready(function () {
      // Función para comprobar y aplicar/quitar el estilo
      function actualizarEstiloAncla() {
        if ($('header').hasClass('sticky')) {
          $('span.ancla_fixed').css('scroll-margin-top', '178px');
        } else {
          $('span.ancla_fixed').css('scroll-margin-top', '');
        }
      }

      // Ejecutar al cargar la página
      actualizarEstiloAncla();

      // Observar cambios en el header (por si sticky se añade/quita dinámicamente)
      const observer = new MutationObserver(actualizarEstiloAncla);

      observer.observe(document.querySelector('header'), {
        attributes: true,
        attributeFilter: ['class']
      });

      // También puedes ejecutar en scroll si el sticky se activa con el desplazamiento
      $(window).on('scroll', actualizarEstiloAncla);
    });



  </script>
  <?php wp_head(); ?>
</head>

<body>

  <!-- Encabezado -->
  <div class="landing">
    <div class="container">
      <div class="container_form mx-auto  w-100">
        <header id="header" class="menu"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/logo-kollective.png" alt="kollective" class="w-100">
          <ul class="nav nav-list affix" id="navbar-example">
            <?php $args = [
              'hide_empty' => 1,
            ];
            $ciudades = get_terms('ciudad', $args ); 
            
            foreach($ciudades as $ciudad) { if($ciudad->parent != 0) { ?>
              <li class="nav-item"><a class="nav-link" href="#<?php echo $ciudad->slug; ?>">EVENTOS <?php echo strtoupper($ciudad->name); ?></a> </li>
            <?php } } ?>
            <li class="nav-item"><a class="nav-link" href="#MOVIMIENTO">MOVIMIENTO KOOLECTIVE</a> </li>
            <li class="nav-item"><a class="nav-link" href="#CONTACTO">CONTACTO</a> </li>
          </ul>
        </header>
        <section> <span id="INTRO" class="py-4 ancla_fixed"></span>
          <div class="container  my-0 my-md-5 py-5">
            <div class="row">
              <div class="col-12">
                <div class="cardheader text-center">
                  <h1>Innovación comercial para la transformación social </h1>
                  <p>Koollective es la nueva marca con la que Koopera da vida a un proyecto
                    pionero que transforma la forma en que entendemos y practicamos el consumo
                    de moda. Una iniciativa que impulsa una cultura más creativa, sostenible,
                    inclusiva y participativa.</p>
                  <!-- <p><a href="#listado" class="btn btn_primary">DESCUBRE TODOS LOS EVENTOS</a></p> -->
                </div>
              </div>
            </div>
          </div>
        </section>

      <!-- ---------------------------------------------- -->
        <?php if (have_posts()) :
          while (have_posts()) :
              the_post();
              the_content();
          endwhile;
        endif; ?>
      <!-- ---------------------------------------------- -->

        <section> <span id="MOVIMIENTO" class=" ancla_fixed"></span>
          <div class="container">
            <div class="row">
              <div class="col-12 text-center slidecarrusel p-0">
                <div class="decoimage"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/
decofoto.png" alt="koollective" /></div>
                <div id="mainCarousel" class="carousel slide carousel-fade" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="carousel-item active"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/
/Property-1-Variant2.jpg" class="d-block w-100"
                        alt="..."> </div>
                    <div class="carousel-item"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/
Property-1-Variant3.jpg" class="d-block w-100"
                        alt="..."> </div>
                    <div class="carousel-item"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/
Property-1-Variant4.jpg" class="d-block w-100"
                        alt="..."> </div>
                  </div>
                </div>
                <script>
                  // Sets interval...what is transition slide speed?
                  $('#mainCarousel').carousel({
                    interval: 2000
                  });
                </script>
              </div>
            </div>
          </div>
        </section>
        <section id="ESPACIO">
          <div class="container">
            <div class="row">
              <div class="col-12 col-md-6 pr-0 "> <img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/
Capa_1.png" alt="koollective" class="w-100" /> </div>
              <div class="col-12 col-md-6 pl-0 ">
                <div class="p-5 h-100 d-flex flex-column justify-content-center">
                  <h2>KOOLLECTIVE BILBAO</h2>
                  <h3 class="mb-4"> Un espacio vivo y colectivo</h3>
                  <p>KOOLLECTIVE abre su primer espacio en Bilbao, dentro de la Koopera Store de Fernández del Campo. Un
                    lugar donde la moda circular se une a la creatividad y la acción colectiva.</p>
                  <p>Aquí no vienes solo a vestirte. Ven y participa en talleres, charlas y encuentros con personas
                    creadoras y comunidades que impulsan un consumo más consciente y sostenible.</p>
                  <p><a href="#BILBAO" class="btn btn_primary">Descubre todos los eventos</a></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 pr-0"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/
decofoto.png" alt="koollective" class="w-100" />
              </div>
              <div class="col-12 col-md-6 pl-0 bg_blue">
                <div class="p-5 h-100 d-flex flex-column justify-content-center">
                  <h2>KOOLLECTIVE</h2>
                  <h3 class="mb-4">Una red viva y en movimiento</h3>
                  <p>KOOLLECTIVE crece como una comunidad creativa y transformadora que impulsa el consumo consciente en
                    Bilbao y Donosti actualmente, y dentro de poco, en muchas más ciudades.</p>
                  <p>Nuestra programación combina acción y sensibilización: talleres de reparación, upcycling y
                    customización, charlas sobre sostenibilidad y moda ética, y colaboraciones artísticas que reinventan
                    lo usado.</p>
                  <p>Porque la moda circular también es una forma de expresión colectiva.</p>
                  <p><a href="#BILBAO" class="btn btn_terciary">Descubre todos los eventos</a></p>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section class="py-5"> <span id="CONTACTO" class="ancla_fixed"></span>
          <div class="container text-center">
            <div class="row mb-4">
              <div class="col-12 text-center">
                <p class="fonttitulo">Alguna duda / sugerencia / idea</p>
                <p class="fonttitulo mb-4">TE ESCUCHAMOS</p>
                <p class="fonttitulo mailto"><a href="mailto:koopera@koopera.org">koopera@koopera.org</a></p>
              </div>
            </div>
            <div class="row pt-5">
              <div class="col-12 text-center"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/
logo-.kooepera.png" alt="koopera" class="mb-3" />
                <p class="mb-0">&copy; 2025 Koopera.</p>
              </div>
            </div>
          </div>
        </section>
        <button id="btnSubir">↑ <span class="sr-only">Subir</span></button>
        <script>
          const btnSubir = document.getElementById('btnSubir');
          window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
              btnSubir.style.display = 'block';
            } else {
              btnSubir.style.display = 'none';
            }
          });
          btnSubir.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
          });
        </script>
      </div>
    </div>
  </div>
  <script id="rendered-js">
    (function () {
      $(document).ready(function () {
        return $('body').scrollspy(function () {
          return {
            target: '#navbar-example'
          };
        });
      });

    }).call(this);
  </script>
  <style>
    <?php include(__DIR__."/koollective-nuevo/style.php"); ?>
  </style>
  <?php wp_footer(); ?>
</body>
</html>