<?php
// file: view/spaces/delete.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$space = $view->getVariable ( "space" );
$view->setVariable ( "title", i18n("Delete Space"));
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=spaces&amp;action=show"><?= i18n("Spaces List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Delete Space") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Delete Space") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_spaces" class="card mb-3">
      <img class="card-img-top" src="<?= $space->getImage() ?>" alt="Card image cap">
      <div id="card_body_spaces" class="card-body">
        <h5 class="card-title"><?= $space->getName() ?></h5>
      </div>
      <ul id="background_table2"  class="list-group list-group-flush">
        <li id="table_color" class="list-group-item"><?= i18n("Capacidad:") ?> <?= $space->getCapacity() ?></li>
      </ul>
      <br/>

      <form action="index.php?controller=spaces&amp;action=delete" method="POST">
        <input type="hidden" name="id_space" value="<?= $space->getId_space() ?>">
        <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Delete")?></button>
      </form>
    </div>
  </div>
</div>
