<?php
// file: view/courses/add.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$course = $view->getVariable("course");
$spaces = $view->getVariable("spaces");
$trainers = $view->getVariable("trainers");
$view->setVariable("title", i18n("Add Course"));
$errors = $view->getVariable("errors");
?>

<script type="text/javascript" src="js/validations.js"></script>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=courses&amp;action=show"><?= i18n("Courses List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Add Course") ?></li>
</ol>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Add Course") ?></h4>
  </div>
  <form action="index.php?controller=courses&amp;action=add" method="POST">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-6">
        <label for="name"><?=i18n("Name")?></label>
        <input type="text" class="form-control" id="name" onblur="validateName()" name="name" placeholder="<?=i18n("Name")?>">
        <?php if(isset($errors["name"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["name"])?i18n($errors["name"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("Type")?></label>
        <select name="type" class="form-control" id="select">
          <option value="children"><?=i18n("Children")?></option>
          <option value="adults"><?=i18n("Adults")?></option>
        </select>
        <?php if(isset($errors["type"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["type"])?i18n($errors["type"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("Start Time")?></label>
        <input class="form-control" type="time" value="09:00:00" id="time" name="start_time">
        <?php if(isset($errors["start_time"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["start_time"])?i18n($errors["start_time"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("End Time")?></label>
        <input class="form-control" type="time" value="11:00:00" id="time" name="end_time">
        <?php if(isset($errors["end_time"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["end_time"])?i18n($errors["end_time"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-8">
        <label for="description"><?=i18n("Description")?></label>
        <textarea class="form-control" id="description" onblur="validateDescription()" name="description" rows="8" placeholder="<?=i18n("Description")?>"></textarea>
        <?php if(isset($errors["description"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["description"])?i18n($errors["description"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="days"><?=i18n("Days")?></label>
        <select name="days[]" class="form-control" id="select" multiple rows="8">
          <option value="Monday"><?=i18n("Monday")?></option>
          <option value="Tuesday"><?=i18n("Tuesday")?></option>
          <option value="Wednesday"><?=i18n("Wednesday")?></option>
          <option value="Thursday"><?=i18n("Thursday")?></option>
          <option value="Friday"><?=i18n("Friday")?></option>
          <option value="Saturday"><?=i18n("Saturday")?></option>
          <option value="Sunday"><?=i18n("Sunday")?></option>
        </select>
        <?php if(isset($errors["days"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["days"])?i18n($errors["days"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="capacity"><?=i18n("Capacity")?></label>
        <input class="form-control" type="number" value="10" id="capacity" name="capacity">
        <?php if(isset($errors["capacity"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["capacity"])?i18n($errors["capacity"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="space"><?=i18n("Spaces")?></label>
        <select name="space" class="form-control" id="select" rows="8">
          <?php
          foreach ($spaces as $space) { ?>
            <option value="<?=$space["id_space"]?>"><?=$space["name"]?></option>
          <?php } ?>
        </select>
        <?php if(isset($errors["space"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["space"])?i18n($errors["space"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="trainer"><?=i18n("Trainers")?></label>
        <select name="trainer" class="form-control" id="select" rows="8">
          <?php
          foreach ($trainers as $trainer) { ?>
            <option value="<?=$trainer["id_user"]?>"><?=$trainer["name"]?></option>
          <?php } ?>
        </select>
        <?php if(isset($errors["trainer"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["trainer"])?i18n($errors["trainer"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("Price")?></label>
        <input class="form-control" type="number" value="30" id="price" name="price">
        <?php if(isset($errors["price"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["price"])?i18n($errors["price"]):"" ?>
            </div>
        <?php } ?>
      </div>
      
      <div class="form-group col-md-2">
        <label for="type"><?=i18n("Start Date")?></label>
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

    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Add")?></button>
  </form>
</div>
