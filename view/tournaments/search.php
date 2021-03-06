<?php
// file: view/tournaments/add.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$tournament = $view->getVariable("tournament");
$view->setVariable("title", i18n("Search Tournament"));
$errors = $view->getVariable("errors");
?>

<script type="text/javascript" src="js/validations.js"></script>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=show"><?= i18n("Tournaments List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Search Tournament") ?></li>
</ol>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Search Tournament") ?></h4>
  </div>
  <form action="index.php?controller=tournaments&amp;action=search" method="POST">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-8">
        <label for="name"><?=i18n("Name")?></label>
        <input type="text" class="form-control" id="name" onblur="validateName()" name="name" placeholder="<?=i18n("Name")?>">
        <?php if(isset($errors["name"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["name"])?i18n($errors["name"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="date"><?=i18n("Start Date")?></label>
        <input class="form-control" type="date" id="date" name="start_date">
        <?php if(isset($errors["start_date"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["start_date"])?i18n($errors["start_date"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("End Date")?></label>
        <input class="form-control" type="date" id="date" name="end_date">
        <?php if(isset($errors["end_date"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["end_date"])?i18n($errors["end_date"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-10">
        <label for="description"><?=i18n("Description")?></label>
        <textarea class="form-control" id="description" onblur="validateDescription()" name="description" rows="8" placeholder="<?=i18n("Description")?>"></textarea>
        <?php if(isset($errors["description"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["description"])?i18n($errors["description"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("Price")?></label>
        <input class="form-control" type="number" id="price" name="price">
        <?php if(isset($errors["price"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["price"])?i18n($errors["price"]):"" ?>
            </div>
        <?php } ?>
      </div>

    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Search")?></button>
  </form>
</div>
