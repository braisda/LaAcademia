<?php
// file: view/matchs/view.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$tournament = $view->getVariable("tournament");
$draw = $view->getVariable("draw");
$match = $view->getVariable("match");
$view->setVariable("title", "View Tournament");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=show"><?= i18n("Tournaments List") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=view&amp;id_tournament=<?= $tournament ?>"><?= i18n("Tournament Information") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=draws&amp;action=show&amp;id_tournament=<?= $tournament ?>"><?= i18n("Draws List") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=draws&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>"><?= i18n("Draw Information") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=matches&amp;action=show&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>"><?= i18n("Matches List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Course Information") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Match Information") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_event2" class="card">
      <h4 id="card_body" class="card-header"><?= ucfirst(i18n($match->getRound())) ?>: <?= date("d-m-Y", strtotime($match->getdate())); ?></h4>

      <ul id="background_table2"  class="list-group list-group-flush">
        <table id="table_color" class="table table-sm table-dark">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th><?=i18n("Player 1")?></th>
              <th><?=i18n("Player 2")?></th>
              <th><?=i18n("Set 1")?></th>
              <th><?=i18n("Set 2")?></th>
              <th><?=i18n("Set 3")?></th>
              <th><?=i18n("Set 4")?></th>
              <th><?=i18n("Set 5")?></th>
            </tr>
          </thead>
          <tbody>
                <tr>
                  <td>1</td>
                  <td><?= $match->getName_rival1a()?></td>
                  <td><?= $match->getName_rival1b()?></td>
                  <td><?= $match->getSet1a()?></td>
                  <td><?= $match->getSet2a()?></td>
                  <td><?= $match->getSet3a()?></td>
                  <td><?= $match->getSet4a()?></td>
                  <td><?= $match->getSet5a()?></td>
                </tr>

                <tr>
                  <td>2</td>
                  <td><?= $match->getName_rival2a()?></td>
                  <td><?= $match->getName_rival2b()?></td>
                  <td><?= $match->getSet1b()?></td>
                  <td><?= $match->getSet2b()?></td>
                  <td><?= $match->getSet3b()?></td>
                  <td><?= $match->getSet4b()?></td>
                  <td><?= $match->getSet5b()?></td>
                </tr>
                <tr>
                  <td><?php
                    if($_SESSION["admin"]){
                  ?>
                    <a href="index.php?controller=matches&amp;action=update" class="card-link"><span class="oi oi-loop"></span></a>
                    <a href="index.php?controller=matches&amp;action=delete" class="card-link"><span class="oi oi-trash"></a>
                  <?php
                }
                  ?>
                </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
          </tbody>
        </table>
      </ul>
    </div>
  </div>
</div>
