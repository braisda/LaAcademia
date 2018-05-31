<?php
// file: view/tournamentReservations/search.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$reservations = $view->getVariable("reservations");
$competitors = $view->getVariable("competitors");
$tournaments = $view->getVariable("tournaments");
$view->setVariable("title", "Delete Tournament Reservation");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournamentReservations&amp;action=show"><?= i18n("Tournaments Reservations List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Search Tournament Reservation") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Search Tournament Reservation") ?></h4>
  </div>

  <form enctype="multipart/form-data" action="index.php?controller=tournamentReservations&amp;action=search" method="POST">
    <div id="background_table" class="form-row">
 <?php if ($_SESSION["admin"]){ ?>
      <div class="form-group col-md-3">
        <label for="competitor"><?=i18n("Pupil")?></label>
        <select name="competitor" class="form-control" id="select" rows="8">
          <option value=""></option>
          <?php
          foreach ($competitors as $competitor) { ?>
            <option value="<?=$competitor["id_user"]?>"><?=$competitor["name"]?> <?=$competitor["surname"]?></option>
          <?php } ?>
        </select>
        <?php if(isset($errors["competitor"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["competitor"])?i18n($errors["competitor"]):"" ?>
            </div>
        <?php } ?>
      </div>
<?php } ?>
      <div class="form-group col-md-3">
        <label for="tournament"><?=i18n("Tournament")?></label>
        <select name="tournament" class="form-control" id="select" rows="8">
          <option value=""></option>
          <?php
          foreach ($tournaments as $tournament) { ?>
            <option value="<?=$tournament["id_tournament"]?>"><?=$tournament["name"]?> <?=i18n($tournament["type"])?></option>
          <?php } ?>
        </select>
        <?php if(isset($errors["tournament"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["tournament"])?i18n($errors["tournament"]):"" ?>
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
