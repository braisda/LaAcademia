<?php
// file: view/events/update.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$event = $view->getVariable("event");
$spaces = $view->getVariable("spaces");

$view->setVariable("title", "Update Event");
$errors = $view->getVariable("errors");
?>

<script>
function validateName(){
  var name = document.getElementById("name");
  var res = /^[A-Za-z0-9\sáéíóúÁÉÍÓÚñÑ]+$/.test(name.value);

  if(!res){
    document.getElementById("name").style.borderColor = "red";
  }else{
    document.getElementById("name").style.borderColor = "#3c3a37";
  }
}

function validateDescription(){
  var description = document.getElementById("description");
  var res = /^[A-Za-z0-9\sáéíóúÁÉÍÓÚñÑ().,"'¡!]+$/.test(description.value);

  if(!res){
    document.getElementById("description").style.borderColor = "red";
  }else{
    document.getElementById("description").style.borderColor = "#3c3a37";
  }
}
</script>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=events&amp;action=show"><?= i18n("Events List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Update Event") ?></li>
</ol>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Update Event") ?></h4>
  </div>
  <form action="index.php?controller=events&amp;action=update" method="POST">
    <input type="hidden" name="id_event" value="<?= $event->getId_event() ?>">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-6">
        <label for="name"><?=i18n("Name")?></label>
        <input type="text" class="form-control" id="name" onblur="validateName()" name="name" value="<?= $event->getName() ?>" placeholder="<?= $event->getName() ?>">
        <?php if(isset($errors["name"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["name"])?i18n($errors["name"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="capacity"><?=i18n("Capacity")?></label>
        <input class="form-control" type="number" value="<?= $event->getCapacity() ?>" id="capacity" name="capacity">
        <?php if(isset($errors["capacity"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["capacity"])?i18n($errors["capacity"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="date"><?=i18n("Date")?></label>
        <input id="date" type="date" name="date" class="form-control" value="<?= $event->getDate() ?>">
        <?php if(isset($errors["date"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["date"])?i18n($errors["date"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("Time")?></label>
        <input class="form-control" type="time" value="<?= $event->getTime() ?>" id="time" name="time">
        <?php if(isset($errors["time"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["time"])?i18n($errors["time"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-8">
        <label for="description"><?=i18n("Description")?></label>
        <textarea class="form-control" id="description" onblur="validateDescription()" name="description" rows="8" placeholder="<?= $event->getDescription() ?>"><?= $event->getDescription() ?></textarea>
        <?php if(isset($errors["description"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["description"])?i18n($errors["description"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="space"><?=i18n("Spaces")?></label>
        <select name="space" class="form-control" id="select" rows="8">
          <?php
          foreach ($spaces as $space) { ?>
            <?php if($event->getId_space() == $space["id_space"]){ ?>
              <option selected value="<?=$space["id_space"]?>"> <?=$space["name"]?></option>
            <?php }else{ ?>
              <option value="<?=$space["id_space"]?>"><?=$space["name"]?></option>
            <?php }?>
          <?php } ?>
        </select>
        <?php if(isset($errors["space"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["space"])?i18n($errors["space"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("Price")?></label>
        <input class="form-control" type="number" value="<?= $event->getPrice() ?>" id="price" name="price">
        <?php if(isset($errors["price"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["price"])?i18n($errors["price"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <!--   <div class="form-group col-md-2">
        <label for="inputZip">Foto</label>
        <input type="file" id="inputZip">
      </div>   -->
    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Update")?></button>
  </form>
</div>
