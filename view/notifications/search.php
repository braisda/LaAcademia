<?php
// file: view/notifications/add.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$notification = $view->getVariable("notification");
$view->setVariable("title", i18n("Search Notification"));
$errors = $view->getVariable("errors");
?>

<script type="text/javascript" src="js/validations.js"></script>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=notifications&amp;action=show"><?= i18n("Notifications List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Search Notification") ?></li>
</ol>

<div class="container" id="container">

  <div id="background_title">

    <h4 id="view_title"><?= i18n("Search Notification") ?></h4>
  </div>

  <form enctype="multipart/form-data" action="index.php?controller=notifications&amp;action=search" method="POST">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-6">
        <label for="title"><?=i18n("Title")?></label>
        <input type="text" class="form-control" id="title" onblur="validateName()" name="title" placeholder="<?=i18n("Title")?>">
        <?php if(isset($errors["title"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["title"])?i18n($errors["title"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-6">
        <label for="sender"><?=i18n("Username")?></label>
        <input type="email" class="form-control" id="username" onblur="validateUsername()" name="sender" placeholder="<?=i18n("Username")?>">
        <?php if(isset($errors["email"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["email"])?i18n($errors["email"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-12">
        <label for="body"><?=i18n("Message")?></label>
        <textarea class="form-control" id="message" onblur="validateDescription()" name="body" rows="8" placeholder="<?=i18n("Message")?>"></textarea>
        <?php if(isset($errors["message"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["message"])?i18n($errors["message"]):"" ?>
            </div>
        <?php } ?>
      </div>

    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Search")?></button>
  </form>
</div>
