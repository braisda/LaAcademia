<?php
// file: view/tournaments_reservations/delete.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$reservation = $view->getVariable("tournamentReservation");
$competitors = $view->getVariable("competitors");
$tournaments = $view->getVariable("tournaments");
$view->setVariable ( "title", "Delete Tournament Reservation" );
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournamentReservations&amp;action=show"><?= i18n("Tournaments Reservations List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Delete Tournament Reservation") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Delete Tournament Reservation") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_event" class="card">
      <h4 id="card_body" class="card-header">
        <?php
          foreach ($tournaments as $tournament) {
            if($tournament["id_tournament"] == $reservation->getId_tournament()){
              $name = $tournament["name"];
            }
          }
        ?>

        <?= $name ?></td>
      </h4>
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
        </li>
      </ul>
      <br/>
      <form action="index.php?controller=tournamentReservations&amp;action=delete" method="POST">
        <input type="hidden" name="id_reservation" value="<?= $reservation->getId_reservation() ?>">
        <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Delete")?></button>
      </form>
    </div>
  </div>
</div>
