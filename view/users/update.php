<?php
// file: view/users/add.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$user = $view->getVariable ( "user" );
$view->setVariable ( "title", "Edit User" );
$errors = $view->getVariable ( "errors" );
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=users&amp;action=show"><?= i18n("Users List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Modify User") ?></li>
</ol>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Modify User") ?></h4>
  </div>
  <form enctype="multipart/form-data" action="index.php?controller=users&amp;action=update" method="POST">
    <input type="hidden" name="id_user" value="<?= $user->getId_user() ?>">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-6">
        <label for="name"><?=i18n("Name")?></label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $user->getName() ?>" placeholder="<?= $user->getName() ?>">
      </div>
      <div class="form-group col-md-6">
        <label for="surname"><?=i18n("Surname")?></label>
        <input type="text" class="form-control" id="surname" name="surname" value="<?= $user->getSurname() ?>" placeholder="<?= $user->getSurname() ?>">
      </div>
      <div class="form-group col-md-4">
        <label for="dni"><?=i18n("DNI")?></label>
        <input type="text" class="form-control" id="dni" name="dni" value="<?= $user->getDni() ?>" placeholder="<?= $user->getDni() ?>">
      </div>
      <div class="form-group col-md-4">
        <label for="birthdate"><?=i18n("Birthdate")?></label>
        <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?=$user->getBirthdate()?>">
      </div>
      <div class="form-group col-md-4">
        <label for="telephone"><?=i18n("Telephone")?></label>
        <input type="tel" class="form-control" id="telephone" name="telephone" value="<?= $user->getTelephone() ?>" placeholder="<?= $user->getTelephone() ?>">
      </div>
      <div class="form-group col-md-4">
        <label for="username"><?=i18n("Email")?></label>
        <input type="email" class="form-control" id="username" name="username" value="<?= $user->getUsername() ?>" placeholder="<?= $user->getUsername() ?>">
      </div>

      <div class="form-group col-md-4">
        <label for="password"><?=i18n("Password")?></label>
        <input type="password" class="form-control" id="password" name="password" placeholder="<?=i18n("Password")?>">
      </div>
      <div class="form-group col-md-4">
        <label for="repeatpassword"><?=i18n("Repeat Password")?></label>
        <input type="password" class="form-control" id="repeatpassword" name="repeatpassword" placeholder="<?=i18n("Repeat Password")?>">
      </div>
      <div id="a" class="form-group col-md-2">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="isAdministrator" name="isAdministrator" value="1" <?php if($user->getIs_administrator() == 1){ ?>checked="checked" <?php } ?>/>
            <label class="custom-control-label" for="isAdministrator"><?=i18n("Administrator")?></label>
        </div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="isTrainer" name="isTrainer" value="1" <?php if($user->getIs_trainer() == 1){ ?>checked="checked" <?php } ?>/>
            <label class="custom-control-label" for="isTrainer"><?=i18n("Trainer")?></label>
        </div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="isPupil" name="isPupil" value="1" <?php if($user->getIs_pupil() == 1){ ?>checked="checked" <?php } ?>/>
            <label class="custom-control-label" for="isPupil"><?=i18n("Pupil")?></label>
        </div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="isCompetitor" name="isCompetitor" value="1" <?php if($user->getIs_competitor() == 1){ ?>checked="checked" <?php } ?>/>
            <label class="custom-control-label" for="isCompetitor"><?=i18n("Competitor")?></label>
        </div>
      </div>
      <div class="form-group col-md-2">
        <label for="inputZip"><?=i18n("Image")?></label>
        <input type="file" id="image" name="image">
      </div>
    </div>
    <br/>

    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Update")?></button>
  </form>
</div>
