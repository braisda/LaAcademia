<?php
// file: view/tournaments/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$tournaments = $view->getVariable("tournaments");
$view->setVariable ("title", "Show Tournaments");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Tournaments List") ?></li>
</ol>

<?php $alert = "" ?>
<?php if($alert =($view->popFlash())){ ?>
    <div class="alert alert-success" role="alert">
      <?= $alert ?>
    </div>
<?php } ?>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Tournaments List") ?></h4>
    <a href="index.php?controller=tournaments&amp;action=search">
      <span id="search_icon" class="oi oi-magnifying-glass">
    </a>
    <?php
      if($_SESSION["admin"]){
    ?>
    <a href="index.php?controller=tournaments&amp;action=add">
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
                  <th><?=i18n("Name")?></th>
                  <th><?=i18n("Start Date")?></th>
                  <th><?=i18n("End Date")?></th>
                  <th><?=i18n("Operations")?></th>
                </tr>
              </thead>
              <tbody>
                <?php $n=1; foreach ($tournaments as $tournament): ?>
        						<tr>
                      <td><?= $n++ ?></td>
        							<td><?= $tournament->getName() ?></td>
                      <td><?= date("d-m-Y", strtotime($tournament->getStart_date())); ?></td>
                      <td><?= date("d-m-Y", strtotime($tournament->getStart_date())); ?></td>
                      <td>
                        <a href="index.php?controller=tournaments&amp;action=view&amp;id_tournament=<?= $tournament->getId_tournament() ?>"><span class="oi oi-eye"></span></a>
                        <?php
                          if($_SESSION["admin"]){
                        ?>
                          <a href="index.php?controller=tournaments&amp;action=update&amp;id_tournament=<?= $tournament->getId_tournament() ?>"><span class="oi oi-pencil"></span></a>
                          <a href="index.php?controller=tournaments&amp;action=delete&amp;id_tournament=<?= $tournament->getId_tournament() ?>"><span class="oi oi-trash"></span></a>
                        <?php
                      }
                      if($_SESSION["competitor"]){
                    ?>
                      <a href="index.php?controller=tournamentReservations&amp;action=add&amp;id_tournament=<?= $tournament->getId_tournament() ?>"><span class="oi oi-task"></span></span></a>
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
