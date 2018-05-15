<?php
// file: view/users/add.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$user = $view->getVariable ( "user" );
$view->setVariable ( "title", "Search User" );
$errors = $view->getVariable ( "errors" );
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
</script>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=spaces&amp;action=show"><?= i18n("Spaces List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Search Space") ?></li>
</ol>

<div class="container" id="container">
  <div id="background_title">

    <h4 id="view_title"><?= i18n("Search Space") ?></h4>
  </div>

  <form enctype="multipart/form-data" action="index.php?controller=spaces&amp;action=search" method="POST">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-12">
        <label for="name"><?=i18n("Name")?></label>
        <input type="text" class="form-control" id="name" onblur="validateName()" name="name" placeholder="<?=i18n("Name")?>">
        <?php if(isset($errors["name"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["name"])?i18n($errors["name"]):"" ?>
            </div>
        <?php } ?>
      </div>
    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Search")?></button>
  </form>
</div>
