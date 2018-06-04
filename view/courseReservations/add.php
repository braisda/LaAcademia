<?php
// file: view/courseReservationss/add.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$course = $view->getVariable("course");
$view->setVariable("title", i18n("Add Course Reservation"));
$errors = $view->getVariable("errors");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=courseReservations&amp;action=show"><?= i18n("Course Reservations List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Add Course Reservation") ?></li>
</ol>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Add Course Reservation") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_event" class="card">
      <h4 id="card_body" class="card-header"><?= $course->getName() ?></h4>
      <ul id="background_table2"  class="list-group list-group-flush">
        <li id="event_decription" class="list-group-item"><?= $course->getDescription() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Place") ?>:</strong> <?= $course->getName_space() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Teached by") ?>:</strong> <?= $course->getName_trainer() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Date") ?>:</strong> <?= $course->getDays() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Start Time") ?>:</strong> <?= $course->getStart_time() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("End Time") ?>:</strong> <?= $course->getEnd_time() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Capacity") ?>:</strong> <?= $course->getCapacity() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Price") ?>:</strong> <?= $course->getPrice() ?></li>

      </ul>
      <?php if(isset($errors["reservation"])){ ?>
          <div class="alert alert-danger" role="alert">
            <strong><?= i18n("Error!") ?></strong> <?= isset($errors["reservation"])?i18n($errors["reservation"]):"" ?>
          </div>
      <?php } ?>

      <form action="index.php?controller=courseReservations&amp;action=add" method="POST">
        <input type="hidden" name="id_course" value="<?= $course->getId_course() ?>">
        <br/>
        <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Reserve")?></button>
      </form>
    </div>

  </div>


</div>
