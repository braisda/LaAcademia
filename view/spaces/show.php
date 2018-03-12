<?php
// file: view/spaces/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$spaces = $view->getVariable("spaces");
$view->setVariable ("title", "Show Spaces");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Spaces List") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Spaces List") ?><a href="index.php?controller=spaces&amp;action=add"> Añadir</img></a></h4>
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
                        <a href="index.php?controller=spaces&amp;action=view&amp;id_space=<?= $space->getId_space() ?>">V</img></a>
                        <a href="index.php?controller=spaces&amp;action=update&amp;id_space=<?= $space->getId_space() ?>">M</img></a>
                        <a href="index.php?controller=spaces&amp;action=delete&amp;id_space=<?= $space->getId_space() ?>">E</img></a>
                      </td>
        						</tr>
        				<?php endforeach; ?>
              </tbody>
            </table>
        </div>
    </div>

  </div>
</div>
