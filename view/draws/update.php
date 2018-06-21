<?php
// file: view/draws/update.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$draw = $view->getVariable("draw");
$tournament = $view->getVariable("tournament");
$view->setVariable("title", i18n("Update Draw"));
$errors = $view->getVariable("errors");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=show"><?= i18n("Tournaments List") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=view&amp;id_tournament=<?= $tournament ?>"><?= i18n("Tournament Information") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=draws&amp;action=show&amp;id_tournament=<?= $tournament ?>"><?= i18n("Draws List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Update Draw") ?></li>
</ol>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Update Draw") ?></h4>
  </div>
  <form action="index.php?controller=draws&amp;action=update" method="POST">
    <input type="hidden" name="id_tournament" value="<?= $tournament ?>">
    <input type="hidden" name="id_draw" value="<?= $draw->getId_draw() ?>">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-3">
        <label for="modality"><?=i18n("Modality")?></label>
        <select name="modality" class="form-control" id="select" rows="8">
          <?php
            if($draw->getModality() == "individual"){
          ?>
              <option value="individual" selected><?=i18n("Individual")?></option>
          <?php
            }else{
          ?>
              <option value="individual"><?=i18n("Individual")?></option>
          <?php
            }
          ?>
          <?php
            if($draw->getModality() == "double"){
          ?>
              <option value="double" selected><?=i18n("Double")?></option>
          <?php
            }else{
          ?>
              <option value="double"><?=i18n("Double")?></option>
          <?php
            }
          ?>
        </select>
        <?php if(isset($errors["modality"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["modality"])?i18n($errors["modality"]):"" ?>
            </div>
        <?php } ?>
      </div>

        <div class="form-group col-md-3">
          <label for="gender"><?=i18n("Gender")?></label>
          <select name="gender" class="form-control" id="select" rows="8">
            <?php
              if($draw->getGender() == "male"){
            ?>
                <option value="male" selected><?=i18n("Male")?></option>
            <?php
              }else{
            ?>
                <option value="male"><?=i18n("Male")?></option>
            <?php
              }
            ?>
            <?php
              if($draw->getGender() == "female"){
            ?>
                <option value="female" selected><?=i18n("Female")?></option>
            <?php
              }else{
            ?>
                <option value="female"><?=i18n("Female")?></option>
            <?php
              }
            ?>
          </select>
          <?php if(isset($errors["gender"])){ ?>
              <div class="alert alert-danger" role="alert">
                <strong><?= i18n("Error!") ?></strong> <?= isset($errors["gender"])?i18n($errors["gender"]):"" ?>
              </div>
          <?php } ?>
        </div>

        <div class="form-group col-md-3">
          <label for="category"><?=i18n("Category")?></label>
          <select name="category" class="form-control" id="select" rows="8">
            <?php
              if($draw->getCategory() == "children"){
            ?>
                <option value="children" selected><?=i18n("Children")?></option>
            <?php
              }else{
            ?>
                <option value="children"><?=i18n("Children")?></option>
            <?php
              }
            ?>
            <?php
              if($draw->getCategory() == "adult"){
            ?>
                <option value="adult" selected><?=i18n("Adult")?></option>
            <?php
              }else{
            ?>
                <option value="adult"><?=i18n("Adult")?></option>
            <?php
              }
            ?>
            <?php
              if($draw->getCategory() == "veteran"){
            ?>
                <option value="veteran" selected><?=i18n("Veteran")?></option>
            <?php
              }else{
            ?>
                <option value="veteran"><?=i18n("Veteran")?></option>
            <?php
              }
            ?>
          </select>
          <?php if(isset($errors["category"])){ ?>
              <div class="alert alert-danger" role="alert">
                <strong><?= i18n("Error!") ?></strong> <?= isset($errors["category"])?i18n($errors["category"]):"" ?>
              </div>
          <?php } ?>
        </div>

        <div class="form-group col-md-3">
          <label for="type"><?=i18n("Type")?></label>
          <select name="type" class="form-control" id="select" rows="8">
            <?php
              if($draw->getType() == "regular"){
            ?>
                <option value="regular" selected><?=i18n("Regular")?></option>
            <?php
              }else{
            ?>
                <option value="regular"><?=i18n("Regular")?></option>
            <?php
              }
            ?>
            <?php
              if($draw->getType() == "consolation"){
            ?>
                <option value="consolation" selected><?=i18n("Consolation")?></option>
            <?php
              }else{
            ?>
                <option value="consolation"><?=i18n("Consolation")?></option>
            <?php
              }
            ?>
          </select>
          <?php if(isset($errors["type"])){ ?>
              <div class="alert alert-danger" role="alert">
                <strong><?= i18n("Error!") ?></strong> <?= isset($errors["type"])?i18n($errors["type"]):"" ?>
              </div>
          <?php } ?>
        </div>



















    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Update")?></button>
  </form>
</div>
