<?php
// file: view/notifications/view.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$notification = $view->getVariable("notification");
$senderName = $view->getVariable("senderName");
$view->setVariable("title", i18n("Delete Notification"));
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=notifications&amp;action=show"><?= i18n("Notifications List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Delete Notification") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Delete Notification") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_spaces" class="card mb-3">
      <div id="card_body_spaces" class="card-body">
        <h5 class="card-title"><?= $notification->getTitle() ?>, <?= i18n("From:") ?> <?= $senderName->getName() ?> <?= $senderName->getSurname() ?></h5>
      </div>
      <ul id="background_table2"  class="list-group list-group-flush">
        <li id="table_color" class="list-group-item"><?= $notification->getBody() ?></li>
        <li id="table_color" class="list-group-item"><?= $notification->getDate() ?> <?= i18n("at") ?> <?= $notification->getTime() ?></li>
      </ul>
      <br/>
      <form action="index.php?controller=notifications&amp;action=delete" method="POST">
        <input type="hidden" name="id_notification" value="<?= $notification->getId_notification() ?>">
        <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Delete")?></button>
      </form>
    </div>
  </div>
</div>
