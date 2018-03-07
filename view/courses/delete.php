<?php
// file: view/courses/delete.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
// $view->setLayout("welcome");
$course = $view->getVariable ( "course" );
$view->setVariable ( "title", "Delete Course" );
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=courses&amp;action=show"><?= i18n("Courses List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Delete Course") ?></li>
</ol>



  <div id="container" class="container">
    <div id="background_title">
      <h4 id="view_title"><?= i18n("Course Information") ?></h4>
    </div>
    <div class="row justify-content-center">
      <?= $course->getDescription() ?>
    </div>
    <form action="index.php?controller=courses&amp;action=delete" method="POST">
      <input type="hidden" name="id_course" value="<?= $course->getId_course() ?>">
      <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Delete")?></button>
    </form>
  </div>
