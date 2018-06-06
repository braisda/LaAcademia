<?php
// file: view/notifications/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$notifications = $view->getVariable("notifications");
$users = $view->getVariable("users");
$view->setVariable ("title", "Show Notifications");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Notifications List") ?></li>
</ol>

<?php $alert = "" ?>
<?php if($alert =($view->popFlash())){ ?>
    <div class="alert alert-success" role="alert">
      <?= $alert ?>
    </div>
<?php } ?>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Notifications List") ?></h4>
    <a href="index.php?controller=notifications&amp;action=search">
      <span id="search_icon" class="oi oi-magnifying-glass">
    </a>
    <a href="index.php?controller=notifications&amp;action=add">
      <span class="oi oi-plus">
    </a>

  </div>
  <div class="row justify-content-around">

    <div id="background_table" class="col-9">
      <div class="table-responsive">
        <br/>
            <table id="table_color" class="table table-sm table-dark">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th><?=i18n("Sender")?></th>
                  <th><?=i18n("Issue")?></th>
                  <th><?=i18n("Operations")?></th>
                </tr>
              </thead>
              <tbody>
                <?php $n=1; foreach ($notifications as $notification): ?>
                  <?php

                    foreach ($users as $user) {
                      if($user->getId_user() == $notification->getSender()){
                        $name = $user->getName();
                        $surname = $user->getSurname();
                      }
                    }
                  ?>
        						<tr>
                      <td><?= $n++ ?></td>
                      <?php
                        if($notification->getIs_read() == 0){
                      ?>
                          <td class="notRead"><?= $name ?> <?= $surname ?></td>
            							<td class="notRead"><?= $notification->getTitle() ?></td>
                      <?php
                        }else {
                      ?>
                          <td><?= $name ?> <?= $surname ?></td>
                          <td><?= $notification->getTitle() ?></td>
                      <?php
                        }
                      ?>
                      <td>
                        <a href="index.php?controller=notifications&amp;action=view&amp;id_notification=<?= $notification->getId_notification() ?>"><span class="oi oi-eye"></span></a>
                        <a href="index.php?controller=notifications&amp;action=delete&amp;id_notification=<?= $notification->getId_notification() ?>"><span class="oi oi-trash"></span></a>
                      </td>
        						</tr>
        				<?php endforeach; ?>
              </tbody>
            </table>
        </div>
    </div>

  </div>
</div>
