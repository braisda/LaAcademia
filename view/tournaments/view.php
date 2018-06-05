<?php
// file: view/tournaments/view.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$tournament = $view->getVariable("tournament");
$view->setVariable("title", "View Tournament");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=show"><?= i18n("Tournaments List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Tournament Information") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Tournament Information") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_event" class="card">
      <h4 id="card_body" class="card-header"><?= $tournament->getName() ?> <a href="index.php?controller=draws&amp;action=show&amp;id_tournament=<?= $tournament->getId_tournament() ?>" class="card-link"><span class="oi oi-zoom-in"></span></a></h4>
      <ul id="background_table2"  class="list-group list-group-flush">
        <li id="event_decription" class="list-group-item"><?= $tournament->getDescription() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Start Time") ?>:</strong> <?= $tournament->getStart_date() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("End Time") ?>:</strong> <?= $tournament->getEnd_date() ?></li>
        <li id="table_color" class="list-group-item"><strong><?= i18n("Price") ?>:</strong> <?= $tournament->getPrice() ?> €</li>
        <?php
          if($_SESSION["admin"]){
        ?>
        <li id="table_color" class="list-group-item">
          <a href="index.php?controller=tournaments&amp;action=update&amp;id_tournament=<?= $tournament->getId_tournament() ?>" class="card-link"><span class="oi oi-pencil"></span></a>
          <a href="index.php?controller=tournaments&amp;action=delete&amp;id_tournament=<?= $tournament->getId_tournament() ?>" class="card-link"><span class="oi oi-trash"></a>
        </li>
        <?php
      }
        ?>
      </ul>
    </div>
  </div>
</div>
