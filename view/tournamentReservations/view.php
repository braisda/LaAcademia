<?php
// file: view/tournamentReservations/view.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$reservation = $view->getVariable("tournamentReservation");
$competitors = $view->getVariable("competitors");
$tournaments = $view->getVariable("tournaments");
$view->setVariable ( "title", "View Reservation" );
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournamentReservations&amp;action=show"><?= i18n("Tournaments Reservations List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Tournament Reservation Information") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Tournament Reservation Information") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_event" class="card">
      <?php
        foreach ($tournaments as $tournament) {
          if($tournament["id_tournament"] == $reservation->getId_tournament()){
            $name = $tournament["name"];
          }
        }
      ?>
      <h4 id="card_body" class="card-header"><?= $name ?></td></h4>
      <ul id="background_table2" class="list-group list-group-flush">

          <?php
            foreach ($competitors as $competitor) {
              if($competitor["id_user"] == $reservation->getId_competitor()){
                $name = $competitor["name"];
                $surname = $competitor["surname"];
              }
            }
          ?>

          <li id="event_decription" class="list-group-item"><?= $name." ".$surname ?></td></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Date") ?>:</strong> <?= date("d-m-Y", strtotime($reservation->getDate())) ?></li>
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
                <a href="index.php?controller=tournamentReservations&amp;action=cancel&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-circle-x"></span></a>
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
