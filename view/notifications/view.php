<?php
// file: view/notifications/view.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$notification = $view->getVariable("notification");
$senderName = $view->getVariable("senderName");
$view->setVariable("title", i18n("Notification Information"));
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=notifications&amp;action=show"><?= i18n("Notifications List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Notification Information") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Notification Information") ?></h4>
  </div>

  <div class="row justify-content-center">
    <div id="card_spaces" class="card mb-3">
      <div id="card_body_spaces" class="card-body">
        <h5 class="card-title"><?= $notification->getTitle() ?>, <?= i18n("From:") ?> <?= $senderName->getName() ?> <?= $senderName->getSurname() ?></h5>
      </div>
      <ul id="background_table2"  class="list-group list-group-flush">
        <li id="table_color" class="list-group-item"><?= $notification->getBody() ?></li>
        <li id="table_color" class="list-group-item"><?= $notification->getDate() ?> <?= i18n("at") ?> <?= $notification->getTime() ?></li>
        <li id="table_color" class="list-group-item">
            <a href="index.php?controller=notifications&amp;action=delete&amp;id_notification=<?= $notification->getId_notification() ?>"><span class="oi oi-trash"></span></a>
        </li>
      </ul>
    </div>
  </div>
</div>
