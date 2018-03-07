<?php
// file: view/courses/add.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$course = $view->getVariable ( "course" );
$view->setVariable ( "title", "Add Course" );
$errors = $view->getVariable ( "errors" );
?>

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
        <input type="text" class="form-control" id="name" name="name" placeholder="<?=i18n("Name")?>">
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("Type")?></label>
        <select name="type" class="form-control" id="select">
          <option value="children"><?=i18n("Children")?></option>
          <option value="adults"><?=i18n("Adults")?></option>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("Start Time")?></label>
        <input class="form-control" type="time" value="09:00:00" id="time" name="start_time">
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("End Time")?></label>
        <input class="form-control" type="time" value="11:00:00" id="time" name="end_time">
      </div>

      <div class="form-group col-md-8">
        <label for="description"><?=i18n("Description")?></label>
        <textarea class="form-control" id="description" name="description" rows="8" placeholder="<?=i18n("Description")?>"></textarea>
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
      </div>

      <div class="form-group col-md-2">
        <label for="capacity"><?=i18n("Capacity")?></label>
        <input class="form-control" type="number" value="10" id="capacity" name="capacity">
      </div>



      <!--   <div class="form-group col-md-2">
        <label for="inputZip">Foto</label>
        <input type="file" id="inputZip">
      </div>   -->
    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Add")?></button>
  </form>
</div>
