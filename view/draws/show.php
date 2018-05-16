<?php
// file: view/draws/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$draws = $view->getVariable("draws");
$tournament = $view->getVariable("tournament");
$view->setVariable ("title", "Show Draws");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=show"><?= i18n("Tournaments List") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=view&amp;id_tournament=<?= $tournament ?>"><?= i18n("Tournament Information") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Draws List") ?></li>
</ol>

<?php $alert = "" ?>
<?php if($alert =($view->popFlash())){ ?>
    <div class="alert alert-success" role="alert">
      <?= $alert ?>
    </div>
<?php } ?>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Draws List") ?></h4>
    <a href="index.php?controller=draws&amp;action=search">
      <span id="search_icon" class="oi oi-magnifying-glass">
    </a>
    <?php
      if($_SESSION["admin"]){
    ?>
    <a href="index.php?controller=draws&amp;action=add&amp;id_tournament=<?= $tournament ?>">
      <span class="oi oi-plus">
    </a>
    <?php
      }
    ?>

  </div>
  <div class="row justify-content-around">

    <div id="background_table" class="col-9">
      <div class="table-responsive">
        <br/>
            <table id="table_color" class="table table-sm table-dark">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th><?=i18n("Modality")?></th>
                  <th><?=i18n("Gender")?></th>
                  <th><?=i18n("Operations")?></th>
                </tr>
              </thead>
              <tbody>
                <?php $n=1; foreach ($draws as $draw): ?>
        						<tr>
                      <td><?= $n++ ?></td>
        							<td><?= i18n(ucfirst($draw->getModality())) ?></td>
                      <td><?= i18n(ucfirst($draw->getGender())) ?></td>
                      <td>
                        <a href="index.php?controller=draws&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw->getId_draw() ?>"><span class="oi oi-zoom-in"></span></a>
                        <?php
                          if($_SESSION["admin"]){
                        ?>
                          <a href="index.php?controller=draws&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw->getId_draw() ?>"><span class="oi oi-loop"></span></a>
                          <a href="index.php?controller=draws&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw->getId_draw() ?>"><span class="oi oi-trash"></span></a>
                        <?php
                          }
                        ?>
                      </td>
        						</tr>
        				<?php endforeach; ?>
              </tbody>
            </table>
        </div>
    </div>

  </div>
</div>
