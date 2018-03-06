<?php
// file: view/users/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
// $view->setLayout("welcome");
$course = $view->getVariable ( "course" );
$view->setVariable ( "title", "View Course" );
?>


<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Course Information") ?></h4>
  </div>
  <div class="row justify-content-center">
    <?= $course->getDescription() ?>
  </div>
</div>
