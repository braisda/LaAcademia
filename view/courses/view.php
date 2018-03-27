<?php
// file: view/courses/view.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$course = $view->getVariable ( "course" );
$view->setVariable ( "title", "View Course" );
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=courses&amp;action=show"><?= i18n("Courses List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Course Information") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Course Information") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_event" class="card">
      <h4 id="card_body" class="card-header"><?= $course->getName() ?></h4>
      <ul id="background_table"  class="list-group list-group-flush">
        <li id="event_decription" class="list-group-item"><?= $course->getDescription() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Place") ?>:</strong> <?= $course->getName_space() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Teached by") ?>:</strong> <?= $course->getName_trainer() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Date") ?>:</strong> <?= $course->getDays() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Start Time") ?>:</strong> <?= $course->getStart_time() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("End Time") ?>:</strong> <?= $course->getEnd_time() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Capacity") ?>:</strong> <?= $course->getCapacity() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Price") ?>:</strong> <?= $course->getPrice() ?> €</li>
        <li id="table_color" class="list-group-item">
          <a href="index.php?controller=courses&amp;action=update&amp;id_course=<?= $course->getId_course() ?>" class="card-link"><span class="oi oi-loop"></span></a>
          <a href="index.php?controller=courses&amp;action=delete&amp;id_course=<?= $course->getId_course() ?>" class="card-link"><span class="oi oi-trash"></a>
        </li>
      </ul>
    </div>
  </div>
</div>
