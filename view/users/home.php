<?php
// file: view/entry/home.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable ("title", "Home");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item active"><?= i18n("Home") ?></li>
</ol>

<div id="container" class="container">
  <div class="row justify-content-around">
    <div id="background_table" class="col-12">
      <div id="div_home">
      <h2>¿En qué consiste La Academia?</h2>
      <p class="p_home">La Academia, es una escuela de alto rendimiento de tenis, un centro de formación especializado donde un equipo de profesionales entrenan a jóvenes (y no tan jóvenes) tenistas que buscan un entrenamiento de alto rendimiento que les permita alcanzar su máximo potencial y disfrutar de este deporte.
ofrecemos programas de corta o larga duración durante todo el año y además del entrenamiento de tenis, disponemos de convenios de colaboración con varios centros médicos y educativos para que nuestros alumnos tengan la mejor experiencia posible.</p>

      <h2>¿Quiénes forman parte de nuestro equipo técnico?</h2>
      <p class="p_home">Contamos con excelentes profesionales, altamente cualificados y apasionados por el tenis, con ganas de conocerte y empezar a trabajar contigo, confía en nosotros, estás en buenas manos.</p>
      <div id="carouselExampleIndicators" class="carousel slide col-6" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="multimedia/images/users/francisco.jpg" alt="cafetería">
            <div class="carousel-caption d-none d-md-block">
              <h5>Francisco Expósito Martínez</h5>
              <p>Entrenador Nacional Nivel 2</p>
            </div>
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="multimedia/images/users/fatima.jpg" alt="oficina">
            <div class="carousel-caption d-none d-md-block">
              <h5>Fátima Rodríguez Souto</h5>
              <p>Profesora Nacional Nivel 3</p>
              <p>Exjugadora WTA</p>
            </div>
          </div>
          </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

          <h2>¿Quieres conocer nuestras instalaciones?</h2>
          <p class="p_home">Para conseguir llegar a tu mejor nivel, necesitas un entorno a la altura, en La Academia, contarás con todo tipo instalaciones de primer nivel para hacer qu te encuentres lo más cómodo posible con nosotros, esta será tu segunda casa.</p>
          <div id="carouselExampleIndicators" class="carousel slide col-6" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="7"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100" src="multimedia/images/cafeteria.jpg" alt="cafetería">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Cafetería</h5>
                </div>
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="multimedia/images/oficina.png" alt="oficina">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Sala de reuniones</h5>
                </div>
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="multimedia/images/pista1.jpg" alt="pista1">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Pista Central</h5>
                </div>
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="multimedia/images/pista2.jpg" alt="pista2">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Pista 2</h5>
                </div>
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="multimedia/images/salon.jpg" alt="salon">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Salón de Actos</h5>
                </div>
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="multimedia/images/vestuario.jpg" alt="vestuario1">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Vestuario A</h5>
                </div>
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="multimedia/images/vestuario.jpg" alt="vestuario2">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Vestuario B</h5>
                </div>
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

          <h2>¿Tienes alguna duda?</h2>
          <p class="p_home">Estamos aquí para ayudarte, si tienes cualquier pregunta o inquietud, no dudes en ponerte en contacto con nosotros, puedes hacerlo en nuestras oficinas de LA Academia, por teléfono o email, te responderemos lo más rápido posible.</p>
          <p>Dirección: Calle Carmelitas, 24, Ourense</p>
          <p>Teléfono: 988235211</p>
          <p>Email: info@laacademia.com</p>

          <div>


        </div>
      </div>




















</div>
