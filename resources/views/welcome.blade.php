<!-- <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ReporteGEI</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    </head>
    <body>
       <div id='App'>
       </div>
      <script src="{{ asset('js/app.js') }}" type="text/javascript"></script> 
    </body>
</html>
 -->

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AtacamaScope</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700Light" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

<!-- font-family: 'Nixie One', sans-serif !important;
 -->

        <!-- Styles -->
        <style>
            html, body {
                background-color: #0e1820;
                color: white;

                /*background-color: #fff;*/
                /*color: #636b6f;*/
                font-family: 'Roboto', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            /*@import url('https://fonts.googleapis.com/css?family=Arvo:400,700');*/

            /* TEXTOS */

            h1{
                color: aliceblue;
                font-family: 'Roboto', serif;
                text-align: center;

            }
            h2{
                padding-top: 5%;
                color: aliceblue;
                font-family: 'Roboto', serif;
                text-align: center;

              }

            h3{
                color: aliceblue;
                font-family: 'Roboto', serif;
                text-align: center;

              }
            h5{
                padding-top: 10%; 
                color: aliceblue;
                font-family: 'Roboto', serif;
                text-align: center;
              }
            h4{
                padding-top: 2%; 
                color: aliceblue;
                font-family: 'Roboto', serif;
                text-align: center;
              }
            p{
                padding-top: 5%; 
                color: aliceblue;
                font-family: 'Roboto', serif;
                text-align: center;
              }

            /* SECCIONES */


            .navbar{ /*para poner transparente*/
                background-color: transparent;   
            }

            .vialactea{
                background-image:url( {{ url('images/vialactea1.jpg') }} );
                 /* Set a specific height */
                min-height: 620px; 
              
                 /* Create the parallax scrolling effect */
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;

            }

            .pasos{
                /*background-color: rgb(14, 14, 49);*/
                background-color: #0e1820;
                color: white;
            }
            .why{
                background-image: url( {{ url('images/sanpeter2.jpg') }} );
                 /* Set a specific height */
                min-height: 535px; 
              
                 /* Create the parallax scrolling effect */
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;

            }
            .gallery{
                background-color: #0e1820;
                color: white;

                /*background-color: rgb(14, 14, 49);*/

            }

            /*BOTONES*/

            .comenzar{
                color: aliceblue;
                border: 2px solid aliceblue;
                border-radius: 100px;
                background-color: rgb(187, 148, 22);
                border-color: aliceblue;
                font-family: 'Roboto', serif;
                font-size: 24px;
                display: block;
                margin-left: auto;
                margin-right: auto;
                margin-top: 10%;
            }
            .buttonInitial{
              padding-bottom:20%;
            }

            /*IMAGENES*/
            .foto{
                display: block;
                margin-left: auto;
                margin-right: auto;
            }

            .englishPhpotos{
                margin-right: 10px;
                
            }
            .spanishPhoto{
                margin-right: 10px;
                margin-top: 2px;
            }



        </style>
    </head>
    <body>
<!--         <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div> -->
        
<div class="vialactea">
    <div class="container-fluid">
        <header>

                <!--NAVBAR-->

               

                <nav class="navbar navbar-expand-lg navbar-light ">
                    <div class="img1 col-md-5">                      
                    </div>  
                    <div class="englishPhpotos">
                        <a href="/en">
                            <img src= "http://54.70.235.195/images/english.png" class="english ">
                        </a>    
                    </div>
                    <div class="spanishPhoto">
                        <a href="/es">
                            <img src="http://54.70.235.195/images/spanish.png" class="spanish ">
                        </a>    
                    </div>  
                          <div class="collapse navbar-collapse" id="navbarNav">
                          <ul class="navbar-nav">
                            
                            <li class="nav-item">
                              <a class="nav-link" style="color:white" href="#">{{ __('landing.equipment') }}</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" style="color:white" href="#">Eventos astronomicos</a>
                              <li class="nav-item">
                               <a class="nav-link"style="color:white" href="#">Contacto</a>
                            </li>

                            @if (Route::has('login'))
                                <div class="top-right links">
                                    @auth
                                        <a href="{{ url('/home') }}">Home</a>
                                    @else
                                        <a href="{{ route('login') }}">Login</a>

                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}">Register</a>
                                        @endif
                                    @endauth
                                </div>
                            @endif

                            
                           
                          </ul>
                        </div>
                </nav>
        </header>

        <!--ATACAMASCOPE-->

        <div class="atacamascope container">
            <br>
            <br>
            <img src="http://localhost:8000/public/image/white_full.png" class="foto">
            
            <!-- <h1>AtacamaScope</h1> -->
         
                 <h2 class="text-left">{{ __('landing.title') }}</h2>
                  <h3 class="text-left">Unos cuantos clicks y ya estarás observando el universo de san pedro de atacama</h3>
                    
                  <div class="buttonInitial">
                  <button type="button" class="comenzar btn-lg align-center">Comienza ahora</button>
                </div>
                  
        </div>
          
   
    </div>
</div>

<!--UNOS SIMPLES PASOS-->
<div class="pasos">
<div class="container">
    <h2> UNOS SIMPLES PASOS</h2>
    <hr>
  
    <div class="row">
        <div class="telescope col-md">
            <img src="http://54.70.235.195/images/telescope48.png" class="foto">
            <h5>ELIGE Y RESERVA TU TELESCOPIO: Podrás elegir tu telescopio y luego reservar el tiempo y fecha que tendrás el equipo a tu disposición.</h5>
        </div>
        <div class="lupa col-md">
           <img src="http://54.70.235.195/images/search48.png" class="foto">
           <h5>ELIJE UN OBJETO DEL UNIVERSO: Podrás elegir de nuestra base de datos galaxias, cúmulos, estrellas, entre otros objetos.  
                Si deseas buscar objetos por tu cuenta también podrás hacerlo!
            </h5>
        </div>
        <div class="camera col-md">
           <img src="http://54.70.235.195/images/camera48.png" class="foto">
           <h5>ELIJE LOS PARAMETROS DE TU IMAGEN: Podrás elegir los parámetros de tu foto , operar la sensibilidad de la cámara, tiempo de exposición y tamaño de tu foto.
                Si no sabes de estos parámetros, no te preocupes, nosotros automáticamente te los proporcionamos.
              </h5>
        </div>
        <div class="cloud col-md">
            <img src="http://54.70.235.195/images/cloud48.png" class="foto">
            <h5>DISPARA Y DISFRUTA TU PROPIA FOTO DEL UNIVERO.  Una vez que hayas configurado tus parámetros y estés Ok.  Haz un click, dispara, y disfruta tu bella foto del universo. </h5>
        </div>
    
    
    </div>
</div>
</div>

<!--¿POR QUE USAR ATACAMA SCOPE?-->

<div class="why">
<div class="container">
    <h2>¿POR QUE USAR ATACAMA SCOPE?</h2>
    <div class="row">
            <div class="telescope col-md">
                <img src="http://54.70.235.195/images/clouds48.png" class="foto">
                <h4>Estamos en los cielos del desierto de atacama, uno de los mas limpios del planeta.</h4>
            </div>
            <div class="lupa col-md">
               
               <img src="http://54.70.235.195/images/globe48.png" class="foto">
               <h4>Puedes operarlo via internet desde cualquier parte del planeta.</h4>
            </div>
    </div>
    <div class="row">
            <div class="telescope col-md">
                <img src="http://54.70.235.195/images/telescope48.png" class="foto" >
                <h4>Sin comprar equipos de alto costo</h4>
            </div>
            <div class="lupa col-md">
               <img src="http://54.70.235.195/images/emoticon48.png" class="foto">
               <h4>Usa nuestros equipos de forma simple. Busca tus objetos en el universo, dispara, y descarga tu foto.</h4>
            </div>
    </div>
    <div class="row">
            <div class="telescope col-md">
                <img src="http://54.70.235.195/images/money48.png" class="foto">
                <h4>Desde tu escritorio, podrás disfrutar los cielos del desierto de atacama, sin gastos extras en viajes, estadía, etc.</h4>
            </div>
            <div class="lupa col-md">
               <img src="http://54.70.235.195/images/moon48.png" class="foto">
               <h4>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium obcaecati .</h4>
            </div>
    </div>
</div>
</div>

<!--GALERIA DE FOTOS-->
<div class="gallery">
<div class="container">
        <h2>GALERÍA DE FOTOS</h2>
            <div class="h-divider">
            </div>
        
    <div class="row">
        <div class="image1 col-md-4">
            <img src="http://54.70.235.195/foto1.png" class="photo-gallery" >
            <p> Telescopio 300mm f/4.5 <br/> 5 min exp. iso:3500</p>
        </div>
        <div class="image2 col-md-4">
            <img src="http://54.70.235.195/foto2.png" class="photo-gallery" >
            <p> Telescopio 300mm f/4.5 <br/> 5 min exp. iso:3500</p>
        </div>
        <div class="img3 col-md-4">
            <img src="http://54.70.235.195/foto3.png" class="photo-gallery" >
            <p> Telescopio 300mm f/4.5 <br/> 5 min exp. iso:3500</p>
        </div>

<!--DATOS DE CONTACTO-->

        <div class="container">
        <p>AtacamaScope, dirección San Pedro de Atacama Chile<br/>
        emailcontacto@atacamascope.com<br/>
        fono:+569997667238<br/>
        osvaldo.mirando@atacamascope.com<br/><br/>    
        copyright &copy; Incluye todas las fotos: atacamascope.com 2018 </p>
        </div>
    </div>
</div>    
</div>
    <script src="js/jquery.js"></script>
    <script src ="js/bootstrap.min.js"></script>
            
              
    </body>
</html>