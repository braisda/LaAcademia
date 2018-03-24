<?php
// file: view/spaces/view.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$space = $view->getVariable ( "space" );
$view->setVariable ( "title", "View Space" );
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=spaces&amp;action=show"><?= i18n("Spaces List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Space Information") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Space Information") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_spaces" class="card mb-3">
      <img class="card-img-top" src="<?= $space->getImage() ?>" alt="Card image cap">
      <div id="card_body_spaces" class="card-body">
        <h5 class="card-title"><?= $space->getName() ?></h5>
      </div>
      <ul id="background_table"  class="list-group list-group-flush">
        <li id="table_color" class="list-group-item"><?= i18n("Capacidad:") ?> <?= $space->getCapacity() ?></li>
        <li id="table_color" class="list-group-item">
          <a href="index.php?controller=spaces&amp;action=update&amp;id_space=<?= $space->getId_space() ?>" class="card-link"><span class="oi oi-loop"></span></a>
          <a href="index.php?controller=spaces&amp;action=delete&amp;id_space=<?= $space->getId_space() ?>" class="card-link"><span class="oi oi-trash"></a>
        </li>
      </ul>
    </div>
  </div>
</div>
