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
      <h4 id="card_body" class="card-header">
        <?= i18n(ucfirst($draw->getModality())) ?>
        <?= i18n($draw->getGender())?>
        <a href="index.php?controller=matches&amp;action=show&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw->getId_draw() ?>" class="card-link">
          <span class="oi oi-zoom-in"></span>
        </a>
      </h4>
      <ul id="background_table2"  class="list-group list-group-flush">
        <li id="event_decription" class="list-group-item"><?= i18n("Category") ?>: <?= i18n(ucfirst($draw->getCategory())) ?></li>
        <li id="event_decription" class="list-group-item"><?= i18n("Type") ?>: <?= i18n(ucfirst($draw->getType())) ?></li>
        <?php
          if($_SESSION["admin"]){
        ?>
        <li id="table_color" class="list-group-item">
          <a href="index.php?controller=draws&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw->getId_draw() ?>" class="card-link"><span class="oi oi-loop"></span></a>
          <a href="index.php?controller=draws&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw->getId_draw() ?>" class="card-link"><span class="oi oi-trash"></a>
        </li>
        <?php
      }
        ?>
      </ul>
    </div>
  </div>
</div>
