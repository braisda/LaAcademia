<?php
// file: view/courses/delete.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
// $view->setLayout("welcome");
$course = $view->getVariable ( "course" );
$view->setVariable ( "title", i18n("Delete Course"));
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=courses&amp;action=show"><?= i18n("Courses List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Delete Course") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Delete Course") ?></h4>
  </div>
  <div class="row justify-content-center">
    <div id="card_event" class="card">
      <h4 id="card_body" class="card-header"><?= $course->getName() ?></h4>
      <ul id="background_table2"  class="list-group list-group-flush">
        <li id="event_decription" class="list-group-item"><?= $course->getDescription() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Place") ?>:</strong> <?= $course->getName_space() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Teached by") ?>:</strong> <?= $course->getName_trainer() ?></li>

        <?php
          $arrayDays = explode(',' , $course->getDays());
          $stringDays="";
          for($i=0; $i<count($arrayDays); $i++){
            $stringDays = $stringDays.i18n($arrayDays[$i]).", ";
          }
          $size = strlen($stringDays);
          $stringDays = substr($stringDays, 0, $size-2);
         ?>

        <li id="table_color" class="list-group-item"><strong><?= i18n("Days") ?>:</strong> <?=$stringDays?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Start Time") ?>:</strong> <?= $course->getStart_time() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("End Time") ?>:</strong> <?= $course->getEnd_time() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Capacity") ?>:</strong> <?= $course->getCapacity() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Price") ?>:</strong> <?= $course->getPrice() ?> €</li>
      </ul>
      <br/>
      <form action="index.php?controller=courses&amp;action=delete" method="POST">
        <input type="hidden" name="id_course" value="<?= $course->getId_course() ?>">
        <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Delete")?></button>
      </form>
    </div>
  </div>
</div>
