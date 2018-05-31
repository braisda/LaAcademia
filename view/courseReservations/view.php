<?php
// file: view/courseReservations/view.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$reservation = $view->getVariable("courseReservation");
$pupils = $view->getVariable("pupils");
$courses = $view->getVariable("courses");
$view->setVariable ( "title", "View Reservation" );
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=courseReservations&amp;action=show"><?= i18n("Courses Reservations List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Course Reservation Information") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Course Reservation Information") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_event" class="card">
      <h4 id="card_body" class="card-header">
        <?php
          foreach ($courses as $course) {
            if($course["id_course"] == $reservation->getId_course()){
              $name = $course["name"];
              $type = $course["type"];
            }
          }
        ?>

        <?= $name." ".i18n($type) ?></td>
      </h4>
      <ul id="background_table2" class="list-group list-group-flush">
        <li id="event_decription" class="list-group-item">
          <?php
            foreach ($pupils as $pupil) {
              if($pupil["id_user"] == $reservation->getId_pupil()){
                $name = $pupil["name"];
                $surname = $pupil["surname"];
              }
            }
          ?>

          <?= $name." ".$surname ?></td>
        </li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Date") ?>:</strong> <?= $reservation->getDate() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Time") ?>:</strong> <?= $reservation->getTime() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("State") ?>:</strong>
          <?php
            if($reservation->getIs_confirmed() == 1){
              $toret = "Confirmed";
            }else{
              $toret = "Pendient";
            }
          ?>

          <?= i18n($toret) ?></td>
          <?php
            if($_SESSION["admin"]){
          ?>
            <li id="table_color" class="list-group-item">
          <?php
              if($reservation->getIs_confirmed() == 0){
          ?>
                <a href="index.php?controller=eventReservations&amp;action=confirm&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-circle-check"></span></a>
          <?php
              }else{
          ?>
                <a href="index.php?controller=courseReservations&amp;action=cancel&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-circle-x"></span></a>
          <?php
              }
          ?>
              <a href="index.php?controller=eventReservations&amp;action=delete&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-trash"></span></a>
              </li>
          <?php
            }else{
              if($reservation->getIs_confirmed() == 0){
          ?>
              <li id="table_color" class="list-group-item">
                <a href="index.php?controller=eventReservations&amp;action=delete&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-trash"></span></a>
              </li>
          <?php
              }
            }
          ?>
      </ul>
    </div>
  </div>
</div>
