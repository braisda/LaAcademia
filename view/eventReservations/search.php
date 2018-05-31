<?php
// file: view/eventReservation/add.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$reservations = $view->getVariable("reservations");
$assistants = $view->getVariable("assistants");
$events = $view->getVariable("events");
$view->setVariable ( "title", "Search Event Reservation" );
$errors = $view->getVariable ( "errors" );
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=eventReservations&amp;action=show"><?= i18n("Event Reservations List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Search Event Reservation") ?></li>
</ol>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Search Event Reservation") ?></h4>
  </div>

  <form enctype="multipart/form-data" action="index.php?controller=eventReservations&amp;action=search" method="POST">
    <div id="background_table" class="form-row">
 <?php if ($_SESSION["admin"]){ ?>
      <div class="form-group col-md-3">
        <label for="pupil"><?=i18n("Pupil")?></label>
        <select name="pupil" class="form-control" id="select" rows="8">
          <option value=""></option>
          <?php
          foreach ($assistants as $assistant) { ?>
            <option value="<?=$assistant["id_user"]?>"><?=$assistant["name"]?> <?=$assistant["surname"]?></option>
          <?php } ?>
        </select>
        <?php if(isset($errors["pupil"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["pupil"])?i18n($errors["pupil"]):"" ?>
            </div>
        <?php } ?>
      </div>
<?php } ?>
      <div class="form-group col-md-3">
        <label for="event"><?=i18n("Event")?></label>
        <select name="event" class="form-control" id="select" rows="8">
          <option value=""></option>
          <?php
          foreach ($events as $event) { ?>
            <option value="<?=$event["id_event"]?>"><?=$event["name"]?></option>
          <?php } ?>
        </select>
        <?php if(isset($errors["event"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["event"])?i18n($errors["event"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="date"><?=i18n("Date")?></label>
        <input class="form-control" type="date" id="date" name="date">
        <?php if(isset($errors["date"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["date"])?i18n($errors["date"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("Start Time")?></label>
        <input class="form-control" type="time" id="time" name="time">
        <?php if(isset($errors["start_time"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["start_time"])?i18n($errors["start_time"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="confirmed"><?=i18n("Confirmed")?></label>
        <select name="confirmed" class="form-control" id="select">
          <option value="2"></option>
          <option value="1"> <?=i18n("Yes")?> </option>
          <option value="0"> <?=i18n("No")?> </option>
        </select>
        <?php if(isset($errors["confirmed"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["confirmed"])?i18n($errors["confirmed"]):"" ?>
            </div>
        <?php } ?>
      </div>

    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Search")?></button>
  </form>
</div>
