<?php
// file: view/draws/search.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$draw = $view->getVariable("draw");
$tournament = $view->getVariable("tournament");
$view->setVariable("title", "Search Draw");
$errors = $view->getVariable("errors");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=show"><?= i18n("Tournaments List") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=view&amp;id_tournament=<?= $tournament ?>"><?= i18n("Tournament Information") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=draws&amp;action=show&amp;id_tournament=<?= $tournament ?>"><?= i18n("Draws List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Search Draw") ?></li>
</ol>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Search Draw") ?></h4>
  </div>
  <form action="index.php?controller=draws&amp;action=search" method="POST">
    <input type="hidden" name="id_tournament" value="<?= $tournament ?>">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-6">
        <label for="modality"><?=i18n("Modality")?></label>
        <select name="modality" class="form-control" id="select" rows="8">
          <option selected></option>
          <option value="individual"><?=i18n("Individual")?></option>
          <option value="double"><?=i18n("Double")?></option>
        </select>
        <?php if(isset($errors["modality"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["modality"])?i18n($errors["modality"]):"" ?>
            </div>
        <?php } ?>
      </div>

        <div class="form-group col-md-6">
          <label for="gender"><?=i18n("Gender")?></label>
          <select name="gender" class="form-control" id="select" rows="8">
            <option selected></option>
            <option value="male"><?=i18n("Male")?></option>
            <option value="female"><?=i18n("Female")?></option>
          </select>
          <?php if(isset($errors["modality"])){ ?>
              <div class="alert alert-danger" role="alert">
                <strong><?= i18n("Error!") ?></strong> <?= isset($errors["modality"])?i18n($errors["modality"]):"" ?>
              </div>
          <?php } ?>
        </div>
    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Search")?></button>
  </form>
</div>
