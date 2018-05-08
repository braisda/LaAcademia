<?php
// file: view/courses_reservations/delete.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$reservation = $view->getVariable("eventReservation");
$assistants = $view->getVariable("assistants");
$events = $view->getVariable("events");
$view->setVariable ( "title", "Delete Event Reservation" );
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=eventReservations&amp;action=show"><?= i18n("Events Reservations List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Delete Event Reservation") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Delete Event Reservation") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_event" class="card">
      <h4 id="card_body" class="card-header">
        <?php
          foreach ($events as $event) {
            if($event["id_event"] == $reservation->getId_event()){
              $name = $event["name"];
            }
          }
        ?>

        <?= $name ?></td>
      </h4>
      <ul id="background_table" class="list-group list-group-flush">
        <li id="event_decription" class="list-group-item">
          <?php
            foreach ($assistants as $assistant) {
              if($assistant["id_user"] == $reservation->getId_assistant()){
                $name = $assistant["name"];
                $surname = $assistant["surname"];
              }
            }
          ?>

          <?= $name." ".$surname ?></td>
        </li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Date") ?>:</strong> <?= $reservation->getDateReservation() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Time") ?>:</strong> <?= $reservation->getTimeReservation() ?></li>
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
      <br/>
      <form action="index.php?controller=eventReservations&amp;action=delete" method="POST">
        <input type="hidden" name="id_reservation" value="<?= $reservation->getId_reservation() ?>">
        <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Delete")?></button>
      </form>
    </div>
  </div>
</div>
