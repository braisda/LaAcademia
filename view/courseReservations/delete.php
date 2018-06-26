<?php
// file: view/courses_reservations/delete.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$reservation = $view->getVariable("courseReservation");
$pupils = $view->getVariable("pupils");
$courses = $view->getVariable("courses");
$view->setVariable ( "title", i18n("Delete Course Reservation"));
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=courseReservations&amp;action=show"><?= i18n("Courses Reservations List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Delete Course Reservation") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Delete Course Reservation") ?></h4>
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

          <?php
            foreach ($pupils as $pupil) {
              if($pupil["id_user"] == $reservation->getId_pupil()){
                $name = $pupil["name"];
                $surname = $pupil["surname"];
              }
            }
          ?>
        <li id="event_decription" class="list-group-item"><?= $name." ".$surname ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Date") ?>:</strong> <?= date("d-m-Y", strtotime($reservation->getdate())); ?></li>
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
        </li>
      </ul>

      <form action="index.php?controller=courseReservations&amp;action=delete" method="POST">
        <input type="hidden" name="id_reservation" value="<?= $reservation->getId_reservation() ?>">
        <br/>
        <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Delete")?></button>
      </form>
    </div>
  </div>
</div>
