<?php
// file: view/courses/update.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$course = $view->getVariable ( "course" );
$view->setVariable ( "title", "Update Course" );
$errors = $view->getVariable ( "errors" );
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=courses&amp;action=show"><?= i18n("Courses List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Update Course") ?></li>
</ol>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Update Course") ?></h4>
  </div>
  <form action="index.php?controller=courses&amp;action=update" method="POST">
    <input type="hidden" name="id_course" value="<?= $course->getId_course() ?>">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-6">
        <label for="name"><?=i18n("Name")?></label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $course->getName() ?>" placeholder="<?= $course->getName() ?>">
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("Type")?></label>
        <select name="type" class="form-control" id="select">

          <?php if(strpos($course->getType(), 'Children') !== false){ ?>
            <option value="children" selected><?=i18n("Children")?></option>
          <?php }else{ ?>
            <option value="children"><?=i18n("Children")?></option>
          <?php }?>

          <?php if(strpos($course->getType(), 'Adults') !== false){ ?>
            <option value="adults" selected><?=i18n("Adults")?></option>
          <?php }else{ ?>
            <option value="adults"><?=i18n("Adults")?></option>
          <?php }?>

        </select>
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("Start Time")?></label>
        <input class="form-control" type="time" value="<?= $course->getStart_time() ?>" id="time" name="start_time">
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("End Time")?></label>
        <input class="form-control" type="time" value="<?= $course->getEnd_time() ?>" id="time" name="end_time">
      </div>

      <div class="form-group col-md-8">
        <label for="description"><?=i18n("Description")?></label>
        <textarea class="form-control" id="description" name="description" rows="8" placeholder="<?= $course->getDescription() ?>"><?= $course->getDescription() ?></textarea>
      </div>

      <div class="form-group col-md-2">
        <label for="days"><?=i18n("Days")?></label>
        <select name="days[]" class="form-control" id="select" multiple rows="8">

          <?php if(strpos($course->getDays(), 'Monday') !== false){ ?>
            <option value="Monday" selected><?=i18n("Monday")?></option>
          <?php }else{ ?>
            <option value="Monday"><?=i18n("Monday")?></option>
          <?php }?>

          <?php if(strpos($course->getDays(), 'Tuesday') !== false){ ?>
            <option value="Tuesday" selected><?=i18n("Tuesday")?></option>
          <?php }else{ ?>
            <option value="Tuesday"><?=i18n("Tuesday")?></option>
          <?php }?>

          <?php if(strpos($course->getDays(), 'Wednesday') !== false){ ?>
            <option value="Wednesday" selected><?=i18n("Wednesday")?></option>
          <?php }else{ ?>
            <option value="Wednesday"><?=i18n("Wednesday")?></option>
          <?php }?>

          <?php if(strpos($course->getDays(), 'Thursday') !== false){ ?>
            <option value="Thursday" selected><?=i18n("Thursday")?></option>
          <?php }else{ ?>
            <option value="Thursday"><?=i18n("Thursday")?></option>
          <?php }?>

          <?php if(strpos($course->getDays(), 'Friday') !== false){ ?>
            <option value="Friday" selected><?=i18n("Friday")?></option>
          <?php }else{ ?>
            <option value="Friday"><?=i18n("Friday")?></option>
          <?php }?>

          <?php if(strpos($course->getDays(), 'Saturday') !== false){ ?>
            <option value="Saturday" selected><?=i18n("Saturday")?></option>
          <?php }else{ ?>
            <option value="Saturday"><?=i18n("Saturday")?></option>
          <?php }?>

          <?php if(strpos($course->getDays(), 'Sunday') !== false){ ?>
            <option value="Sunday" selected><?=i18n("Sunday")?></option>
          <?php }else{ ?>
            <option value="Sunday"><?=i18n("Sunday")?></option>
          <?php }?>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label for="capacity"><?=i18n("Capacity")?></label>
        <input class="form-control" type="number" value="<?= $course->getCapacity() ?>" id="capacity" name="capacity">
      </div>

    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Modify")?></button>
  </form>
</div>
