 html {
   scroll-behavior: smooth;
 }

 body,
 html {
   height: 100%;
 }
  a.btnvolver {
     color: #fff;
   }

   a.btnvolver img {
     width: 30px;
     height: 30px;
     background-color: #fff;
     border-radius: 50%;
     border: 2px solid #fff;
     margin-right: 10px!important;
   }


 body {
   position: relative;
 }

 @font-face {
   font-family: 'Ace-Regular';
   font-style: normal;
   font-weight: 300;
   src: url("<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/fonts/Ace-Regular.otf") format("opentype"), url("<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/fonts/Ace-Regular.eot") format("embedded-opentype");
 }

 @font-face {
   font-family: 'Ace-Bold';
   font-style: normal;
   font-weight: 700;
   src: url("<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/fonts/Ace-Bold.woff2") format("woff2"), url("<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/fonts/Ace-Bold.woff") format("woff"), url("<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/fonts/Ace-Bold.otf") format("opentype"), url("<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/fonts/Ace-Bold.eot") format("embedded-opentype");
 }

 @font-face {
   font-family: 'Ace-Medium';
   font-style: normal;
   font-weight: 500;
   src: url("<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/fonts/Ace-Medium.woff2") format("woff2"), url("<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/fonts/Ace-Medium.woff") format("woff"), url("<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/fonts/Ace-Medium.otf") format("opentype"), url("<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/fonts/Ace-Medium.eot") format("embedded-opentype");
 }

 .landing .container {
   overflow: hidden;
   max-width: 1600px !important;
   color: #fff;
   width: 100% !important;
 }

 @media (max-width: 992px) {

   .container-fluid,
   .landing .container {
     padding-left: 5px !important;
     padding-right: 5px !important;
   }
 }

 .landing {
   font-family: Montserrat;
   font-family: 15px;
   background-color: #000;
 }

 .landing .container_form {
   border-radius: 36px;
   padding: 26px 25px;
 }

 .landing header#header {
   background-color: #000;
   z-index: 99999;
   display: flex;
   flex-direction: column;
   align-items: center;
 }

 @media (min-width: 992px) {
   .landing .sticky {
     position: fixed;
     top: 0;
     max-width: 1600px;
     transition: all 1s ease;
     width: 100%;
   }

   /* 
   .landing header#header.sticky:before {
     border: 3px solid #fff;
     content: "";
     width: calc(100% + 50px);
     left: -28px;
     top: 4px;
     position: absolute;
     border-radius: 51px 49px 0 0;
     background-color: #000;
     height: 35px;
     z-index: 7;
     border-bottom: none;
   }*/
   .landing header#header.sticky:after {
     content: "";
     z-index: 1;
     background-color: #000;
     width: 200%;
     position: absolute;
     top: 0;
     left: -50%;
     height: 35px;
   }

   .landing header#header img {
     max-width: 100%;
     transition: all 1s ease;
     margin: 0 auto;
   }

   .landing header#header.sticky img {
     max-width: 35%;
     z-index: 999;
     position: relative;
     top: 20px;
     margin: 0 auto 22px;
     height: auto;
     display: block;
   }

   /*
   .landing header#header.sticky {
     border-bottom: 3px solid #999;
   }*/
 }

 /*----nav---*/
 .landing .nav-list {
   justify-content: center;
   gap: 16px;
   padding: 18px 5px 20px;
 }

 .landing .nav-list li a {
   font-size: 18px;
   color: #fff;
   padding: 3px 20px;
   border: 2px solid #fff;
   text-decoration: none;
   border-radius: 33px;
   text-align: center;
 }

 .landing .nav-list li a:hover {
   color: #000;
   background-color: #fff;
   text-decoration: none;
 }

 .landing .nav-list li a.active {
   background-color: #fff;
   border-radius: 13px;
   color: #000;
   border: 1px solid #fff;
 }

 .landing .nav-list li a.active:hover {
   background-color: #000;
   color: #fff;
   border: 1px solid #fff;
   text-decoration: none;
 }

 @media (max-width: 768px) {
   .landing .nav-list {
     gap: 10px;
   }

   .landing .nav-list li a {
     font-size: 13px;
   }
 }

 /**botones**/
 .landing .btn {
   text-transform: uppercase;
 }

 .landing .btn_primary {
   background-color: #F40081;
   color: #000;
   border-radius: 30px;
   padding: 13px 20px;
   font-size: 18px;
   font-weight: 600;
   border: 1px solid #000;
 }

 .landing .btn_primary:hover,
 .landing .btn_primary:focus {
   border: 1px solid #F40081;
   color: #F40081;
   background-color: #000;
 }

 .landing .btn_secondary {
   background-color: #000;
   color: #fff;
   border-radius: 50px;
   padding: 13px 20px;
   font-size: 18px;
   font-style: 600;
   border: 1px solid #fff
 }

 .landing .btn_secondary:hover {
   border: 1px solid #000;
   color: #000;
   background-color: transparent;
 }

 .landing .btn_secondary:focus {
   border: 1px solid #fff;
   color: #fff;
   background-color: transparent;
 }

 .landing .btn_terciary {
   background-color: #75F984;
   color: #220AAC;
   border-radius: 30px;
   padding: 13px 20px;
   font-size: 18px;
   font-style: 600;
   border: 1px solid #75F984;
 }

 .landing .btn_terciary:hover,
 .landing .btn_terciary:focus {
   border: 1px solid #75F984;
   color: #75F984;
   background-color: transparent;
 }

 .landing .btn_fourty {
   background-color: #000;
   color: #F40081;
   border-radius: 30px;
   padding: 13px 20px;
   font-size: 18px;
   font-weight: 600;
   border: 1px solid #F40081;
 }

 .landing .btn_fourty:hover,
 .landing .btn_fourty:focus {
   border: 1px solid #F40081;
   color: #000;
   background-color: #F40081;
 }

 .landing .btn.btn-sm {
   padding: 6px 14px;
   font-size: 13px;
 }

 /*---headers----*/
 .landing h1 {
   font-style: normal;
   font-size: 35px;
   display: inline-block;
   color: #fff;
   line-height: 46px;
   margin-bottom: 23px;
   font-family: 'Ace-Regular';
 }

 @media (max-width: 768px) {
   .landing h1 {
     font-size: 23px;
     line-height: 27px;
   }
 }

 .landing .sectionverde {
   text-transform: uppercase;
   margin-bottom: 10px;
   background-color: #75F984;
   padding: 30px 10px;

 }

 .landing .sectionverde h2 {
   font-family: 'Ace-Regular';
   font-style: normal;
   font-size: 27px;
   color: #000;
   text-transform: uppercase;

 }

 .landing .sectionverde a {
   color: #000;
   font-family: 'Ace-Regular';
   font-style: normal;
   font-size: 11px;

 }

 .landing .sectionverde a img {
   width: 30px;
   height: auto;
   margin-right: 20px;

 }

 @media (min-width: 992px) {}

 .landing h2.verde {
   font-family: 'Ace-Regular';
   font-style: normal;
   font-size: 27px;
   color: #000;
   text-transform: uppercase;
   margin-bottom: 10px;
   background-color: #75F984;
   padding: 30px 10px;
   display: block;
   text-align: center;
   margin: 0;
 }

 .landing h2 {
   font-family: 'Ace-Regular';
   font-style: normal;
   font-size: 27px;
   color: #fff;
   margin-bottom: 10px;
   display: block;
 }

 @media (min-width: 481px) {

   .landing h2,
   .landing h2.verde {
     font-family: 'Ace-Regular';
     font-style: normal;
     font-size: 20px;
   }

   .landing .fonttitulo {
     font-size: 21px;
     font-family: 'Ace-Regular';
     margin-bottom: 13px;
   }

   .landing .fonttitulo span {
     margin-top: 10px;
     font-size: 17px;
     line-height: 25px;
   }
 }

 @media (max-width: 480px) {
   .landing .fonttitulo {
     font-size: 16px;
   }

   .landing .fonttitulo span {
     margin-top: 10px;
     font-size: 14px;
     line-height: 18px;
   }
 }

 /*---card boton--*/
 .landing .cardboton {
   display: flex;
   flex-direction: column;
   justify-content: center;
   border: 1px solid #F40081;
   padding: 20px;
   color: #F40081;
   height: 100%;
   border-radius: 25px;
   position: relative;
 }

 .landing .cardboton.invert {
   border: 1px solid #F40081;
   color: #000;
   background-color: #F40081;
 }

 .landing .cardboton .fechahora {
   display: flex;
   flex-wrap: wrap;
   justify-content: center;
 }

 .landing .cardboton.fullhover:hover {
   -webkit-transition: all 0.3s ease;
   -o-transition: all 0.3s;
   -moz-transition: all 0.3s ease;
   transition: all 0.3s ease;
   background-color: #F40081;
 }

 .landing .cardboton.fullhover:hover p {
   color: #000;
 }

 .landing .cardboton.fullhover:hover li {
   color: #000;
 }

 .landing .cardboton.fullhover:hover .fechahora img {
   filter: brightness(0) saturate(100%) invert(0%) sepia(21%) saturate(3935%) hue-rotate(111deg) brightness(88%) contrast(106%);
 }

 .landing .cardboton.invert.fullhover:hover {
   background-color: #000;
 }

 .landing .cardboton.invert.fullhover:hover p {
   color: #F40081;
 }

 .cardboton.invert.fullhover:hover li {
   color: #F40081;
 }

 .cardboton.invert.fullhover:hover .fechahora img {
   filter: none;
 }

 .landing .text-size20 {
   font-size: 17px;
   line-height: 22px;
   font-family: 'Ace-Regular';
 }

 .landing .text-size50 {
   font-size: 50px;
   line-height: 54px;
   font-family: 'Ace-Regular';
 }

 .landing .fechahora {
   display: flex;
   list-style: none;
   gap: 20px;
   padding: 0;
 }

 @media (max-width: 768px) {
   .landing .fechahora {
     flex-direction: column
   }
 }

 .landing .fechahora img {
   width: 20px !important;
   margin-right: 6px;
   margin-top: -7px;
 }

 .landing .fechahora img.white {
   filter: brightness(0) saturate(100%) invert(89%) sepia(97%) saturate(14%) hue-rotate(198deg) brightness(113%) contrast(86%);
 }

 .landing .fechahora img.black {
   filter: brightness(0) saturate(100%) invert(0%) sepia(21%) saturate(3935%) hue-rotate(111deg) brightness(88%) contrast(106%);
 }

 .landing .invert .fechahora img {
   color: #000
 }

 .landing .bg_blue {
   background-color: #220AAC;
 }

 /*---experiencias---*/
 .landing ul.container.experiencias {
   margin: 0;
   display: flex;
   flex-direction: column-reverse;
 }

 .landing ul.experiencias>li {
   border-bottom: 1px solid #fff;
   position: relative;
 }


 .landing ul.experiencias>li div:first-child:before {
   border-right: 1px solid;
   content: "";
   right: 0;
   height: calc(100% + 40px);
   position: absolute;
 }

 .landing ul.experiencias>li.fullhover:hover {
   -webkit-transition: all 0.3s ease;
   -o-transition: all 0.3s;
   -moz-transition: all 0.3s ease;
   transition: all 0.3s ease;
   background-color: #e4b400;
 }

 .landing ul.experiencias>li>[class^="col-12"] {
   /*position: initial;*/
 }

 ul.experiencias>li.fullhover:hover span,
 ul.experiencias>li.fullhover:hover p,
 ul.experiencias>li.fullhover:hover h2,
 ul.experiencias>li.fullhover:hover h3,
 ul.experiencias>li.fullhover:hover h4,
 ul.experiencias>li.fullhover:hover li {
   color: #000;
 }

 .landing ul.experiencias>li.fullhover:hover li img {
   filter: brightness(0) saturate(100%) invert(0%) sepia(21%) saturate(3935%) hue-rotate(111deg) brightness(88%) contrast(106%);
 }

 /*---carrusel---*/
 .landing .slidecarrusel {
   position: relative;
 }

 .landing .slidecarrusel .decoimage {
   position: absolute;
   top: 35px;
   left: 65px;
   z-index: 9;
 }

 .landing .spotspace {
   margin-top: 20px;
   max-width: 300px;
 }

 .landing .cardfooter {
   border-radius: 10px;
   font-size: 19px;
   font-weight: 500;
   height: 100%;
   padding: 20px;
   margin-top: 20px;
   line-height: 20px;
   text-transform: uppercase;
 }

 .landing .cardfooter p {
   margin-bottom: 0;
 }

 .landing .cardfooter img,
 .cardfooter svg {
   margin-bottom: 20px;
   max-width: 75px;
   height: auto;
 }

 @media (min-width: 768px) {
   .landing .ancla_fixed {
     scroll-margin-top: 500px;



   }

 }

 .landing #btnSubir {
   position: fixed;
   z-index: 9999;
   bottom: 45px;
   right: 11px;
   display: none;
   background-color: #fff;
   color: 000;
   border: none;
   border-radius: 50px;
   cursor: pointer;
   box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
   transition: opacity 0.3s ease;
   font-size: 29px;
   padding: 0 !important;
   line-height: 38px;
   height: 40px;
   width: 40px;
 }

 .landing #btnSubir:hover {
   background-color: #0056b3;
 }

 .landing .fullhover a::before {
   content: "";
   position: absolute;
   width: 100%;
   height: 100%;
   top: 0;
   left: 0;
 }

 .landing .mailto a {
   color: #FFF;
 }

 .landing .mailto a:hover,
 .landing .mailto a:focus {
   color: #fff;
   text-decoration: underline;
 }

 #forminscripcion {}

 #forminscripcion .form-heading {
   text-align: center;
   margin: 2em;
   color: #64ffda;
   font-size: 1.2em;
   background-color: transparent;
   align-self: center;
 }


 #forminscripcion label {
   color: #E4B400;
   font-weight: bold;
   font-size: 14px;
   margin-bottom: 5px;
   width: 100%;
   margin-top: 15px;
 }

 #forminscripcion input,
 #forminscripcion textarea {
   color: #fff;
   padding: 0.7em 0.5em;
   font-size: 16px;
   box-sizing: border-box;
   width: 100%;
   background: #666;
   border: none;
   border-radius: 12px;
   margin-top: 6px;
 }


 #forminscripcion input::placeholder,
 #forminscripcion textarea::placeholder {
   color: #fff;
 }

 #forminscripcion button {
   cursor: pointer;
   margin-bottom: 3em;
   padding: 1em;
   border-radius: 10px;
   border: none;
   outline: none;
   background-color: transparent;
   color: #000;
   font-weight: bold;
   outline: 2px solid #75F984;
   transition: all ease-in-out 0.3s;
   font-size: 18px;
   background: #75F984;
 }

 #forminscripcion button:hover {
   background-color: #000;
   outline: 2px solid #75F984;

   color: #75F984;
 }

 .form-card1 {
   background-image: linear-gradient(163deg, #64ffda 0%, #64ffda 100%);
   border-radius: 22px;
   transition: all 0.3s;
   max-width: 500px;
   margin: 0 auto;
 }

 .form-card1:hover {
   box-shadow: 0px 0px 30px 1px rgba(100, 255, 218, 0.3);
 }

 .form-card2 {
   border-radius: 0;
   transition: all 0.2s;
 }

 .form-card2:hover {
   transform: scale(0.98);
   border-radius: 20px;
 }

 .fechadata {
   background: #F40081;
   border-radius: 23px;

 }

 .avisos {
   background: #E4B400;
   border-radius: 16px;
   padding: 20px;
   position: relative;
   margin-bottom: 34px;


 }

 .avisos h2 {

   color: #000;
 }

 .avisos p {
   font-size: 14px;
   margin: 0;
   color: #000;

 }



 #forminscripcion {
   display: flex;
   gap: 20px;
   flex-wrap: wrap;


   #forminscripcion>label,
   #forminscripcion>div {
     display: block;
     width: calc(50% - 10px);
   }

   #forminscripcion>label.doble,
   #forminscripcion>div.doble {
     width: 100%;
   }

   #forminscripcion>label>*:is(input[type=text], input[type=date], input[type=email], textarea) {
     width: 100%;
   }

   #forminscripcion>button {
     width: 100%;
   }

  
   .py {
     display: flex;
   }

   .py label {
     margin-right: 13px;
     color: #ddd;
   }

   .option-input {
     -webkit-appearance: none;
     -moz-appearance: none;
     -ms-appearance: none;
     -o-appearance: none;
     appearance: none;
     position: relative;
     top: 8px;
     right: 0;
     bottom: 0;
     left: 0;
     height: 20px;
     width: 26px;
     transition: all 0.15s ease-out 0s;
     background: #000;
     border: none;
     cursor: pointer;
     display: inline-block;
     margin-right: 0.5rem;
     outline: none;
     position: relative;
     z-index: 1000;
     border-radius: 50%;
     border: 2px solid #E4B400;
   }

   .option-input:hover {
     background: #E4B400;
   }

   .option-input:checked {
     background: #E4B400;
   }

   .option-input:checked::before {
     width: 14px;
     height: 14px;
     display: flex;
     content: '';
     font-size: 25px;
     font-weight: bold;
     position: absolute;
     align-items: center;
     justify-content: center;
     border-radius: 50%;
     background-color: #000;
     top: 4px;
     left: 4px;

   }

   .option-input:checked::after {
     -webkit-animation: click-wave 0.65s;
     -moz-animation: click-wave 0.65s;
     animation: click-wave 0.65s;
     background: #E4B400;
     content: '';
     display: block;
     position: relative;
     z-index: 100;
   }

   .option-input.radio {
     border-radius: 50%;
   }

   .option-input.radio::after {
     border-radius: 50%;
   }

   @keyframes click-wave {
     0% {
       height: 40px;
       width: 40px;
       opacity: 0.35;
       position: relative;
     }

     100% {
       height: 200px;
       width: 200px;
       margin-left: -80px;
       margin-top: -80px;
       opacity: 0;
     }
   }

   .alert {
     display: flex;
     align-items: flex-start;
     padding: 16px;
     margin-bottom: 16px;
     border-radius: 4px;
     position: relative;
     border: none;
   }

   .alert-icon {
     flex-shrink: 0;
     margin-right: 16px;
     float: left;
   }

   .alert-content {
     flex: 1;
     color: #000;
   }


   .alert-title {
     font-weight: bold;
     margin: 0 0 4px 0;
   }

   .alert-description {
     margin: 0;
   }

   .alert .closeButton {
     position: absolute;
     top: 10px;
     right: 10px;
     color: inherit;
     font-weight: bold;
     font-size: 20px;
     cursor: pointer;
     transition: color 0.3s ease;
   }

   .alert .closeButton:hover {
     color: #000;
   }

   .alert-danger {
     background-color: #f44336;
     color: white;
   }

   .alert-success {
     background-color: #75F984;
     color: white;
   }


   .alert-warning {
     background-color: #ff9800;
     color: white;
   }

   .alert-danger .alert-content,
   .alert-danger .alert-description,
   .alert-danger .alert-title {
     color: #fff !important;
   }