<?php
// file: view/spaces/add.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$user = $view->getVariable ( "user" );
$view->setVariable ( "title", "Add User" );
$errors = $view->getVariable ( "errors" );
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=users&amp;action=show"><?= i18n("Users List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Add Space") ?></li>
</ol>

<div class="container" id="container">

  <div id="background_title">

    <h4 id="view_title"><?= i18n("Add Space") ?></h4>
  </div>

  <form action="index.php?controller=spaces&amp;action=add" method="POST">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-6">
        <label for="name"><?=i18n("Name")?></label>
        <input type="text" class="form-control" id="name" name="name" placeholder="<?=i18n("Name")?>">
      </div>
      <div class="form-group col-md-2">
        <label for="capacity"><?=i18n("Capacity")?></label>
        <input class="form-control" type="number" value="10" id="capacity" name="capacity">
      </div>

      <div class="form-group col-md-2">
        <label for="inputZip">Foto</label>
        <input type="file" id="image" name="image">
      </div>
    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Add")?></button>
  </form>
</div>
