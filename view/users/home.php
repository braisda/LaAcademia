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

  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
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





















  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
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

</div>
