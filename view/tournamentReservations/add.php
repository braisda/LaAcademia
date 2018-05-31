<?php
// file: view/tournamentReservationss/add.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$tournament = $view->getVariable("tournament");
$view->setVariable("title", "Add Tournament Reservation");
$errors = $view->getVariable("errors");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournamentReservations&amp;action=show"><?= i18n("Tournament Reservations List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Add Tournament Reservation") ?></li>
</ol>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Add Tournament Reservation") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_event" class="card">
      <h4 id="card_body" class="card-header"><?= $tournament->getName() ?></h4>
      <ul id="background_table"  class="list-group list-group-flush">
        <li id="event_decription" class="list-group-item"><?= $tournament->getDescription() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Start Date") ?>:</strong> <?= $tournament->getStart_date() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("End Date") ?>:</strong> <?= $tournament->getEnd_date() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Price") ?>:</strong> <?= $tournament->getPrice() ?></li>

      </ul>
      <?php if(isset($errors["reservation"])){ ?>
          <div class="alert alert-danger" role="alert">
            <strong><?= i18n("Error!") ?></strong> <?= isset($errors["reservation"])?i18n($errors["reservation"]):"" ?>
          </div>
      <?php } ?>
      <br/>
      <form action="index.php?controller=tournamentReservations&amp;action=add" method="POST">
        <input type="hidden" name="id_tournament" value="<?= $tournament->getId_tournament() ?>">
        <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Reserve")?></button>
      </form>
    </div>

  </div>


</div>
