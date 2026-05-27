<?php

/*

Template Name: Koollective Detalle

*/

?><!DOCTYPE html>

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

  <meta name="robots" content="nofollow,noindex">

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

        <header id="header" class="menu"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/logo-kollective.png" alt="kollective" class="w-50">

          <div class="d-flex w-100">

            <ul class="w-100 flex-grow-1  nav nav-list affix" id="navbar-example">

              <li class="nav-item"><a class="nav-link" href="#info">INFORMACIÓN</a> </li>

              <li class="nav-item"><a class="nav-link" href="#formulario">INSCRIPCIÓN</a> </li>





            </ul>

            <p class="flex-grow-1  flex-shrink-1  mt-3"><a href="<?php echo get_permalink(get_option("_koollective_list_page_id")); ?>"

                class="btnvolver d-flex justify-content-end align-items-center"><img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/ico_anterior.png" style="max-width: inherit"

                  alt="" aria-hidden="true"><span class="sr-only"> Volver</span> </a></p>

          </div>

        </header>

        <!-- ---------------------------------------------- -->

          <?php if (have_posts()) :

            while (have_posts()) :

                the_post();

                the_content();

            endwhile;

          endif; ?>

        <!-- ---------------------------------------------- -->

      </div>

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

    <?php include(__DIR__."/koollective-nuevo/koollective.php"); ?>

  </style>

  <?php wp_footer(); ?>



</body>



</html>