<?php
// file: view/eventReservation/add.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$event = $view->getVariable("event");
$view->setVariable ( "title", "Add Event Reservation" );
$errors = $view->getVariable ( "errors" );
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=eventReservations&amp;action=show"><?= i18n("Event Reservations List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Add Event Reservation") ?></li>
</ol>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Add Event Reservation") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_event" class="card">
      <h4 id="card_body" class="card-header"><?= $event->getName() ?></h4>
      <ul id="background_table"  class="list-group list-group-flush">
        <li id="event_decription" class="list-group-item"><?= $event->getDescription() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Place") ?>:</strong> <?= $event->getName_space() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Date") ?>:</strong> <?= $event->getDate() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Start Time") ?>:</strong> <?= $event->getTime() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Capacity") ?>:</strong> <?= $event->getCapacity() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Price") ?>:</strong> <?= $event->getPrice() ?></li>
      </ul>
      <br/>
      <form action="index.php?controller=eventReservations&amp;action=add" method="POST">
        <input type="hidden" name="id_event" value="<?= $event->getId_event() ?>">
        <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Reserve")?></button>
      </form>
    </div>

  </div>
</div>
