<?php
//file: view/entry/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setLayout("default");
$view->setVariable("title", "Login");
$errors = $view->getVariable("errors");
?>

<script type="text/javascript" src="js/validations.js"></script>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Log In") ?></h4>
  </div>
  <form action="index.php?controller=users&amp;action=login" method="POST">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-6">
        <label for="Username"><?=i18n("Username")?></label>
        <input type="text" class="form-control" id="username" onblur="validateUsername()" name="username" placeholder="<?= i18n("Username")?>" />
        <?php if(isset($errors["general"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["general"])?i18n($errors["general"]):"" ?>
            </div>
        <?php } ?>
      </div>
      <div class="form-group col-md-6">
        <label for="Password"><?=i18n("Password")?></label>
    		<input type="password" class="form-control" id="passwd" name="passwd" placeholder="<?= i18n("Password")?>" />
      </div>
    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Log In")?></button>
  </form>
</div>
