<?php
//file: view/entry/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setLayout("default");
$view->setVariable("title", "Login");
$errors = $view->getVariable("errors");
?>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Log In") ?></h4>
  </div>
  <form action="index.php?controller=users&amp;action=login" method="POST">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-6">
        <label for="Username"><?=i18n("Username")?></label>
        <input type="text" class="form-control" id="username" name="username" placeholder="<?= i18n("Username")?>" />
      </div>
      <div class="form-group col-md-6">
        <label for="Password"><?=i18n("Password")?></label>
    		<input type="password" class="form-control" id="passwd" name="passwd" placeholder="<?= i18n("Password")?>" />
      </div>
    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Logg In")?></button>
  </form>
</div>
