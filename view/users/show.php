<?php
// file: view/users/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$users = $view->getVariable("users");
$view->setVariable ("title", "Show Users");
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
    <h4 id="view_title"><?= i18n("Users List") ?></h4><a href="index.php?controller=users&amp;action=add"> <span class="oi oi-plus"></a>
  </div>
  <div class="row justify-content-around">

    <div id="background_table" class="col-4">
      <h4 id="table_title" ><?= i18n("Administrators") ?></h4>
      <div class="table-responsive">
            <table id="table_color" class="table table-sm table-dark">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th><?=i18n("Surname")?></th>
                  <th><?=i18n("Name")?></th>
                  <th><?=i18n("Operaciones")?></th>
                </tr>
              </thead>
              <tbody>
                <?php $n=1; foreach ($users as $user): ?>
                  <?php if ($user->getIs_administrator() == 1): ?>

        						<tr>
                      <td><?= $n++ ?></td>
        							<td><?= $user->getSurname() ?></td>
        							<td><?= $user->getName() ?></td>
                      <td>
                        <a href="index.php?controller=users&amp;action=view&amp;id_user=<?= $user->getId_user() ?>"><span class="oi oi-magnifying-glass"></span></a>
                        <a href="index.php?controller=users&amp;action=update&amp;id_user=<?= $user->getId_user() ?>"><span class="oi oi-loop"></span></a>
                        <a href="index.php?controller=users&amp;action=delete&amp;id_user=<?= $user->getId_user() ?>"><span class="oi oi-trash"></span></a>
                      </td>
        						</tr>
                  <?php endif ?>
        				<?php endforeach; ?>

              </tbody>
            </table>
        </div>
    </div>



    <div id="background_table" class="col-4">
      <h4 id="table_title" ><?= i18n("Trainers") ?></h4>
      <div class="table-responsive">
      <table id="table_color" class="table table-sm table-dark">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th><?=i18n("Surname")?></th>
            <th><?=i18n("Name")?></th>
            <th><?=i18n("Operaciones")?></th>
          </tr>
        </thead>
        <tbody>
          <?php $n=1; foreach ($users as $user): ?>
            <?php if ($user->getIs_trainer() == 1): ?>

  						<tr>
                <td><?= $n++ ?></td>
  							<td><?= $user->getSurname() ?></td>
  							<td><?= $user->getName() ?></td>
                <td>
                  <a href="index.php?controller=users&amp;action=view&amp;id_user=<?= $user->getId_user() ?>"><span class="oi oi-magnifying-glass"></span></a>
                  <a href="index.php?controller=users&amp;action=update&amp;id_user=<?= $user->getId_user() ?>"><span class="oi oi-loop"></span></a>
                  <a href="index.php?controller=users&amp;action=delete&amp;id_user=<?= $user->getId_user() ?>"><span class="oi oi-trash"></span></a>
                </td>
  						</tr>
            <?php endif ?>
  				<?php endforeach; ?>

        </tbody>
      </table>
    </div>
    </div>





    <div id="background_table" class="col-4">
      <h4 id="table_title" ><?= i18n("Athletes") ?></h4>
      <div class="table-responsive">
      <table id="table_color" class="table table-sm table-dark">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th><?=i18n("Type")?></th>
            <th><?=i18n("Operations")?></th>
          </tr>
        </thead>
        <tbody>
  						<tr>
                <td>1</td>
  							<td><?=i18n("Pupils")?></td>
                <td><a href="index.php?controller=users&amp;action=showPupils"><span class="oi oi-magnifying-glass"></span></a></td>
  						</tr>
              <tr>
                <td>2</td>
  							<td><?=i18n("Competitors")?></td>
                <td><a href="index.php?controller=users&amp;action=showCompetitors"><span class="oi oi-magnifying-glass"></span></a></td>
  						</tr>
        </tbody>
      </table>
    </div>
  </div>
  </div>
</div>
