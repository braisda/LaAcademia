<?php
// file: view/users/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
// $view->setLayout("welcome");
$users = $view->getVariable ( "users" );
$view->setVariable ( "title", "Show Users" );
?>


<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Competitors List") ?><a href="index.php?controller=users&amp;action=add">A</img></a></h4>
  </div>
  <div class="row justify-content-around">

    <div id="background_table" class="col-6">
      <h4 id="table_title" ><?= i18n("Competitors") ?></h4>
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
            <?php if ($user->getIs_competitor() == 1): ?>

  						<tr>
                <td><?= $n++ ?></td>
  							<td><?= $user->getSurname() ?></td>
  							<td><?= $user->getName() ?></td>
                <td>
                  <a href="index.php?controller=users&amp;action=view&amp;id_user=<?= $user->getId_user() ?>">V</img></a>
                  <a href="index.php?controller=users&amp;action=update&amp;id_user=<?= $user->getId_user() ?>">M</img></a>
                  <a href="index.php?controller=users&amp;action=delete&amp;id_user=<?= $user->getId_user() ?>">E</img></a>
                </td>
  						</tr>
            <?php endif ?>
  				<?php endforeach; ?>

        </tbody>
      </table>
    </div>
    </div>

  </div>
</div>
