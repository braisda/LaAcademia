<?php
// file: view/spaces/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$users = $view->getVariable("users");
$view->setVariable ("title", i18n("Users List"));
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Users List") ?></li>
</ol>

<?php $alert = "" ?>
<?php if($alert =($view->popFlash())){ ?>
    <div class="alert alert-success" role="alert">
      <?= $alert ?>
    </div>
<?php } ?>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Users List") ?></h4>
    <a href="index.php?controller=users&amp;action=search">
      <span id="search_icon" class="oi oi-magnifying-glass" title="<?= i18n("Search") ?>">
    </a>
    <?php
      if($_SESSION["admin"]){
    ?>
    <a href="index.php?controller=users&amp;action=add">
      <span class="oi oi-plus" title="<?= i18n("Add") ?>">
    </a>
    <?php
      }
    ?>

  </div>
  <div class="row justify-content-around">

    <div id="background_table" class="col-9">
      <br/>
      <div class="table-responsive">
            <table id="table_color" class="table table-sm table-dark">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th><?=i18n("Dni")?></th>
                  <th><?=i18n("Surname")?></th>
                  <th><?=i18n("Name")?></th>
                  <th><?=i18n("Type")?></th>
                  <th><?=i18n("Operaciones")?></th>
                </tr>
              </thead>
              <tbody>
                <?php $n=1; foreach ($users as $user): ?>

        						<tr>
                      <td><?= $n++ ?></td>
                      <td><?= $user->getDni() ?></td>
        							<td><?= $user->getSurname() ?></td>
        							<td><?= $user->getName() ?></td>
                      <?php
                        $exp = "[\s]";
                        $roles = preg_split($exp, $user->getType());
                      ?>
                      <td>

                        <?php

                          foreach ($roles as $rol): ?>
                            <?= i18n(ucwords($rol)) ?>
                          <?php endforeach; ?>

                      </td>
                      <td>
                        <a href="index.php?controller=users&amp;action=view&amp;id_user=<?= $user->getId_user() ?>"><span class="oi oi-zoom-in" title="<?= i18n("View") ?>"></span></a>
                        <?php
                          if($_SESSION["admin"]){
                        ?>
                          <a href="index.php?controller=users&amp;action=update&amp;id_user=<?= $user->getId_user() ?>"><span class="oi oi-loop" title="<?= i18n("Modify") ?>"></span></a>
                          <a href="index.php?controller=users&amp;action=delete&amp;id_user=<?= $user->getId_user() ?>"><span class="oi oi-trash" title="<?= i18n("Delete") ?>"></span></a>
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
