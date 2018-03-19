<?php
// file: view/spaces/update.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$space = $view->getVariable("space");
$view->setVariable("title", "Update Space");
$errors = $view->getVariable("errors");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=spaces&amp;action=show"><?= i18n("Spaces List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Update Space") ?></li>
</ol>

<div class="container" id="container">

  <div id="background_title">

    <h4 id="view_title"><?= i18n("Update Space") ?></h4>
  </div>

  <form enctype="multipart/form-data" action="index.php?controller=spaces&amp;action=update" method="POST">
    <input type="hidden" name="id_space" value="<?= $space->getId_space() ?>">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-6">
        <label for="name"><?=i18n("Name")?></label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $space->getName() ?>" placeholder="<?= $space->getName() ?>">
      </div>
      <div class="form-group col-md-2">
        <label for="capacity"><?=i18n("Capacity")?></label>
        <input class="form-control" type="number" value="<?= $space->getCapacity() ?>" id="capacity" name="capacity">
      </div>

      <div class="form-group col-md-2">
        <label for="inputZip"><?=i18n("Image")?></label>
        <input type="file" id="image" name="image" value="<?= $space->getImage() ?>">
      </div>
    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Modify")?></button>
  </form>
</div>
