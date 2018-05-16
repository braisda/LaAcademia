<?php
// file: view/draws/view.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$draw = $view->getVariable("draw");
$tournament = $view->getVariable("tournament");
$view->setVariable("title", "View Tournament");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=show"><?= i18n("Tournaments List") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=view&amp;id_tournament=<?= $tournament ?>"><?= i18n("Tournament Information") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=draws&amp;action=show&amp;id_tournament=<?= $tournament ?>"><?= i18n("Draws List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Draw Information") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Draw Information") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_event" class="card">
      <h4 id="card_body" class="card-header"><?= $draw->getModality() ?></h4>
      <ul id="background_table"  class="list-group list-group-flush">
        <li id="event_decription" class="list-group-item"><?= $draw->getGender() ?></li>
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
