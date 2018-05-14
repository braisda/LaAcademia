<?php
// file: view/spaces/add.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$space = $view->getVariable("space");
$view->setVariable("title", "Add Space");
$errors = $view->getVariable("errors");
?>

<script>
function validateName(){
  var name = document.getElementById("name");
  var res = /^[A-Za-z0-9\sáéíóúÁÉÍÓÚ]+$/.test(name.value);

  if(!res){
      document.getElementById("name").style.borderColor = "red";
  }else{
    document.getElementById("name").style.borderColor = "#3c3a37";
  }
}
</script>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=spaces&amp;action=show"><?= i18n("Spaces List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Add Space") ?></li>
</ol>

<div class="container" id="container">

  <div id="background_title">

    <h4 id="view_title"><?= i18n("Add Space") ?></h4>
  </div>

  <form enctype="multipart/form-data" action="index.php?controller=spaces&amp;action=add" method="POST">
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
        <label for="capacity"><?=i18n("Capacity")?></label>
        <input class="form-control" type="number" value="10" id="capacity" name="capacity">
        <?php if(isset($errors["capacity"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["capacity"])?i18n($errors["capacity"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="inputZip"><?=i18n("Image")?></label>
        <input type="file" id="image" name="image">
        <?php if(isset($errors["imagetype"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?> </strong><?= isset($errors["imagetype"])?i18n($errors["imagetype"]):"" ?>
            </div>
        <?php } ?>
      </div>
    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Add")?></button>
  </form>
</div>
