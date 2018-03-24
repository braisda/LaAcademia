<?php
// file: view/events/view.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$event = $view->getVariable ( "event" );
$view->setVariable ( "title", "View Event" );
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=events&amp;action=show"><?= i18n("Events List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Event Information") ?></li>
</ol>

<div id="container" class="container">

  <div id="background_title">
    <h4 id="view_title"><?= i18n("Event Information") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_event" class="card">
      <h4 id="card_body" class="card-header"><?= $event->getName() ?></h4>
      <ul id="background_table"  class="list-group list-group-flush">
        <li id="event_decription" class="list-group-item"><?= $event->getDescription() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Place") ?>:</strong> <?= $event->getName_space() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Date") ?>:</strong> <?= $event->getDate() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Time") ?>:</strong> <?= $event->getTime() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Capacity") ?>:</strong> <?= $event->getCapacity() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Price") ?>:</strong> <?= $event->getPrice() ?> (€)</li>
        <li id="table_color" class="list-group-item">
          <a href="index.php?controller=spaces&amp;action=update&amp;id_event=<?= $event->getId_event() ?>" class="card-link"><?= i18n("Modify") ?></a>
          <a href="index.php?controller=spaces&amp;action=delete&amp;id_event=<?= $event->getId_event() ?>" class="card-link"><?= i18n("Delete") ?></a>
        </li>
      </ul>
    </div>

  </div>
</div>
