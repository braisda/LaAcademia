<?php
// file: view/draws/view.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$draw = $view->getVariable("draw");
$tournament = $view->getVariable("tournament");
$view->setVariable("title", i18n("Delete Draw"));
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=show"><?= i18n("Tournaments List") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=view&amp;id_tournament=<?= $tournament ?>"><?= i18n("Tournament Information") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=draws&amp;action=show&amp;id_tournament=<?= $tournament ?>"><?= i18n("Draws List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Delete Draw") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Delete Draw") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_event" class="card">
      <h4 id="card_body" class="card-header"><?= i18n(ucfirst($draw->getModality())) ?> <?= i18n($draw->getGender())?></h4>
      <ul id="background_table2"  class="list-group list-group-flush">
        <li id="event_decription" class="list-group-item"><?= i18n("Category") ?>: <?= i18n(ucfirst($draw->getCategory())) ?></li>
        <li id="event_decription" class="list-group-item"><?= i18n("Type") ?>: <?= i18n(ucfirst($draw->getType())) ?></li>
      </ul>
      <br/>

      <form action="index.php?controller=draws&amp;action=delete" method="POST">
        <input type="hidden" name="id_tournament" value="<?= $tournament ?>">
        <input type="hidden" name="id_draw" value="<?= $draw->getId_draw() ?>">
        <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Delete")?></button>
      </form>

    </div>
  </div>
</div>
