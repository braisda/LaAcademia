<?php
// file: view/spaces/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$spaces = $view->getVariable("spaces");
$view->setVariable ("title", i18n("Spaces List"));
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Spaces List") ?></li>
</ol>

<?php $alert = "" ?>
<?php if($alert =($view->popFlash())){ ?>
    <div class="alert alert-success" role="alert">
      <?= $alert ?>
    </div>
<?php } ?>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Spaces List") ?></h4>
    <a href="index.php?controller=spaces&amp;action=search">
      <span id="search_icon" class="oi oi-magnifying-glass" title="<?= i18n("Search") ?>">
    </a>
    <?php
      if($_SESSION["admin"]){
    ?>
    <a href="index.php?controller=spaces&amp;action=add">
      <span class="oi oi-plus" title="<?= i18n("Add") ?>">
    </a>
    <?php
      }
    ?>

  </div>
  <div class="row justify-content-around">

    <div id="background_table" class="col-12">
      <div class="table-responsive">
        <br/>
            <table id="table_color" class="table table-sm table-dark">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th><?=i18n("Name")?></th>
                  <th><?=i18n("Capacity")?></th>
                  <th><?=i18n("Operations")?></th>
                </tr>
              </thead>
              <tbody>
                <?php $n=1; foreach ($spaces as $space): ?>
        						<tr>
                      <td><?= $n++ ?></td>
        							<td><?= $space->getName() ?></td>
        							<td><?= $space->getCapacity() ?></td>
                      <td>
                        <a href="index.php?controller=spaces&amp;action=view&amp;id_space=<?= $space->getId_space() ?>"><span class="oi oi-zoom-in" title="<?= i18n("View") ?>"></span></a>
                        <?php
                          if($_SESSION["admin"]){
                        ?>
                          <a href="index.php?controller=spaces&amp;action=update&amp;id_space=<?= $space->getId_space() ?>"><span class="oi oi-loop" title="<?= i18n("Update") ?>"></span></a>
                          <a href="index.php?controller=spaces&amp;action=delete&amp;id_space=<?= $space->getId_space() ?>"><span class="oi oi-trash" title="<?= i18n("Delete") ?>"></span></a>
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
