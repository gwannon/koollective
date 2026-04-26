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
  <!--<link rel="stylesheet" href="style.css">-->
  <link rel="stylesheet" href="kollecitve.css">
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
            <p class="flex-grow-1  flex-shrink-1  mt-3  "><a href="index.html"
                class="btnvolver d-flex justify-content-end align-items-center"><img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/ico_anterior.png"
                  alt="" aria-hidden="true"><span> Volver</span> </a></p>
          </div>
        </header>


                <section>
          <div class="container mt-5">

          </div>
          <div class="container experiencias">

            <div class="row">
              <span id="info" class="ancla_fixed"></span>

              <div
                class="col-12  col-md-2  d-flex align-items-center flex-column justify-content-center pt-5 pt-md-0 fechadata mb-5">
                <span class="text-size50">27</span> <span class="text-size20 d-block mt-3">FEBR</span>
                <p class="mt-5 white text-center">ENCUENTROS KOOLLECTIVE</p>
              </div>
              <div class="col-12 col-md-6 pl-4">
                <h1 class="fonttitulo">KOOLLECTIVE: <span class="d-block">Círculos que incluyen  </span> </h3>
                  <ul class="fechahora mb-4">
                    <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/hora.svg" class="white" alt="">11.30h </li>
                    <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/localition.svg" alt="" class="white">BILBAO KOOLLECTIVE </li>
                  </ul>
                  <p>La jornada es un espacio de encuentro y diálogo que combina mesas de trabajo con distintos
                    enfoques.
                    Una de las mesas se centra en las iniciativas institucionales relacionadas con la innovación en
                    economía circular, mientras que otra reúne a marcas y empresas para compartir su visión sobre el
                    consumo responsable y las estrategias que están implementando en esa dirección. Este espacio permite
                    analizar cómo las políticas públicas y las iniciativas empresariales pueden complementarse para
                    impulsar un modelo de consumo más sostenible.</p>







                  <h4>Mesa institucional / Participantes:</h4>
                  <ul>
                    <li><strong>Eurodiputada</strong> Idoia Mendia</li>
                    <li><strong>Secretaria de Estado de Inclusión</strong> Rosa Martinez</li>
                    <li><strong>Directora de Comercio del Gobierno Vasco</strong> Izaskun Gómez-Cermeño</li>
                    <li><strong>Coordinadora genera le Koopera</strong> Mari Luz Ferro </li>
                  </ul>
              </div>
              <div class="col-12  col-md-4"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images//Property 1=Variant2.jpg" class="rounded d-block w-100 "
                  alt="...">
              </div>


            </div>

          </div>
        </section>
        <div class="container mt-5">



          <div class="row">



            <div class="col-12  col-md-2  ">



            </div>
            <div class="col-12  col-md-10 pl-4">










              <form id="forminscripcion" method="post">
                <input type="hidden" name="actividad" value="47">
                <div class="row">
                  <div class="col-12">
                    <span id="formulario" class="py-2 ancla_fixed"></span>
                    <H2>Formulario de inscripción</H2>



                    <div class="alert alert-danger">
                      <div class="alert-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                          viewBox="0 0 24 24">
                          <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                          </path>
                        </svg>
                      </div>
                      <div class="alert-content">
                        <p class="alert-title">El numero de asistentes está completo</p>
                        <p class="alert-description"> *Si te inscribes en esta actividad, entrarás en la lista de
                          espera. Tan pronto se libere espacio,
                          nos pondremos en contacto contigo para avisarte.</p>
                      </div>
                      <span class="closeButton" onclick="this.parentElement.style.display='none';">×</span>
                    </div>

                  </div>
                  <div class="col-12 col-md-4">

                    <label>
                      Nombre *
                      <input type="text" name="nombre" value="" placeholder="Introduce tu nombre" required="">
                    </label>
                  </div>
                  <div class="col-12 col-md-4">
                    <label>
                      Apellidos *
                      <input type="text" name="apellidos" value="" placeholder="Introduce tus apellidos" required="">
                    </label>
                  </div>
                  <div class="col-12 col-md-4">
                    <label>
                      DNI/NIE *
                      <input type="text" name="dni" value="" placeholder="DNI/NIE con letras mayúsculas" maxlength="9"
                        required="">
                    </label>
                  </div>

                  <div class="col-12 col-md-4">
                    <label>
                      Email *
                      <input type="email" name="email" value="" placeholder="Introduce tu email" required="">
                    </label>
                  </div>
                  <div class="col-12 col-md-4">
                    <label>
                      Teléfono *
                      <input type="text" name="telefono" value="" placeholder="Introduce tu telefono" maxlength="9"
                        required="">
                    </label>
                  </div>
                  <div class="col-12 col-md-4">
                    <label>
                      Fecha de nacimiento <input type="date" name="fechanacimiento" value="">
                    </label>
                  </div>
                  <div class="col-12 col-md-12">
                    <label>
                      Dirección <input type="text" name="direccion" value="" placeholder="Introduce tu dirección">
                    </label>
                  </div>
                  <div class="col-12 col-md-4">
                    <label>
                      Código postal *
                      <input type="text" name="codigopostal" value="" placeholder="Introduce tu código postal"
                        maxlength="5" required="">
                    </label>
                  </div>
                  <div class="col-12 col-md-8">
                    <label>
                      Poblacion *
                      <input type="text" name="ciudad" value="" placeholder="Introduce tu ciudad" required="">
                    </label>
                  </div>
                  <hr>
                  <div class="col-12 col-md-6">
                    <label>
                      ¿En qué tienda Koopera compras habitualmente? *
                      <input type="text" name="tiendacompras" value="" placeholder="Introduce el nombre de la tienda"
                        required="">
                    </label>

                  </div>
                  <div class="col-12 col-md-6">
                    <label>
                      ¿Ha participado en otros eventos?
                      <div class="py">
                        <label class="m-0"><input type="radio" name="hasparticipadootroevento" value="Sí"
                            checked="checked" class="option-input "> Sí</label>
                        <label class="m-0"><input type="radio" name="hasparticipadootroevento" value="No"
                            class="option-input">
                          No</label>
                      </div>
                    </label>
                  </div>
                  <div class="col-12 col-md-6">

                    <label>
                      ¿Cómo conoció el evento? *
                      <textarea name="comoconocioevento" placeholder="Máximo 120 caracteres." maxlength="120"
                        class="h-100" required=""></textarea>
                    </label>
                  </div>
                  <div class="col-12 col-md-6">
                    <label>
                      ¿Qué te interesa más de nuestras actividades?
                      <div class="py flex-column"> <label class="m-0"><input type="checkbox" name="interes[]"
                            value="Moda sostenible" class="option-input" checked="checked"> Moda sostenible
                        </label>
                        <label class="m-0"><input type="checkbox" name="interes[]" value="Economía circular"
                            class="option-input">
                          Economía circular</label>
                        <label class="m-0"><input type="checkbox" name="interes[]" value="Eventos / encuentros"
                            class="option-input">
                          Eventos / encuentros</label>
                        <label class="m-0"><input type="checkbox" name="interes[]" value="Talleres / formación"
                            class="option-input">
                          Talleres / formación</label>
                        <label class="m-0"><input type="checkbox" name="interes[]" value="Segunda mano / vintage"
                            class="option-input">
                          Segunda mano / vintage</label>
                      </div>
                    </label>
                  </div>
                  <div class="col-12">
                    <label>
                      <input type="checkbox" name="aceptorecibirinformacion" value="Acepto recibir información"
                        class="option-input">
                      Acepto recibir información sobre actividades, eventos y novedades de Koopera. </label>
                    <label id="metodorecibirinformacion" class="pl-2 ml-4" style="display:none">
                      ¿Cómo prefieres recibir información?
                      <div class="py pl-2 ml-4">
                        <label class="m-0"><input type="checkbox" name="metodorecibirinformacion[]" value="Email"
                            class="option-input">
                          Email</label>
                        <label class="m-0"><input type="checkbox" name="metodorecibirinformacion[]" value="WhatsApp"
                            class="option-input"> WhatsApp</label>
                        <label class="m-0"><input type="checkbox" name="metodorecibirinformacion[]" value="SMS"
                            class="option-input">
                          SMS</label>
                    </label>
                  </div>
                </div>
                <div class="col-12">

                  <label><input type="checkbox" name="aceptopoliticaprivacidad"
                      value="Acepto la política de privacidad." required="" class="option-input">
                    Acepto la política de privacidad.</label>

                </div>
                <div class="col-12 pt-5 text-center">
                  <button type="submit" name="inscripcion">Inscribirse</button>


                  <div class="alert alert-danger">
                    <div class="alert-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                          d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                        </path>
                      </svg>
                    </div>
                    <div class="alert-content">
                      <p class="alert-title">Error</p>
                      <p class="alert-description">Se ha producido un error al procesar el formulario</p>
                    </div>
                    <span class="closeButton" onclick="this.parentElement.style.display='none';">×</span>
                  </div>

                  <div class="alert alert-success">
                    <div class="alert-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                          d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z">
                        </path>
                      </svg>
                    </div>
                    <div class="alert-content">
                      <p class="alert-title">Envio correo</p>
                      <p class="alert-description">Su inscripción se ha proceso correctamente</p>
                    </div>
                    <span class="closeButton" onclick="this.parentElement.style.display='none';">×</span>
                  </div>




              </form>
            </div>
          </div>
        </div>









<?php if (have_posts()) :
   while (have_posts()) :
      the_post();
      the_content();
   endwhile;
endif; ?>













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
    <?php include(__DIR__."/koollective-nuevo/style.php"); ?>
  </style>
  <?php wp_footer(); ?>

</body>

</html>