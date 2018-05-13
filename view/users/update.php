<?php
// file: view/users/add.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$user = $view->getVariable ( "user" );
$view->setVariable ( "title", "Edit User" );
$errors = $view->getVariable ( "errors" );
?>

<script>
function validateName(){
  var name = document.getElementById("name");
  var res = /^[A-Za-zñÑáéíóúÁÉÍÓÚ]+$/.test(name.value);

  if(!res){
      document.getElementById("name").style.borderColor = "red";
  }else{
    document.getElementById("name").style.borderColor = "#3c3a37";
  }
}

function validateSurname(){
  var surname = document.getElementById("surname");
  var res = /^[A-Za-zñÑáéíóúÁÉÍÓÚ]+ [A-Za-zñÑáéíóúÁÉÍÓÚ]+$/.test(surname.value);

  if(!res){
      document.getElementById("surname").style.borderColor = "red";
  }else{
    document.getElementById("surname").style.borderColor = "#3c3a37";
  }
}

function validateDni() {
  var number, let, letter;

  var dni = document.getElementById("dni").value;

  dni = dni.toUpperCase();


    if(/^[XYZ]?\d{5,8}[A-Z]$/.test(dni) === true){
        number = dni.substr(0,dni.length-1);
        number = number.replace('X', 0);
        number = number.replace('Y', 1);
        number = number.replace('Z', 2);
        let = dni.substr(dni.length-1, 1);
        number = number % 23;
        letter = 'TRWAGMYFPDXBNJZSQVHLCKET';
        letter = letter.substring(number, number+1);
        if (letter != let) {
          document.getElementById("dni").style.borderColor = "red";

        }else{
          document.getElementById("dni").style.borderColor = "#3c3a37";

        }
    }else{
      document.getElementById("dni").style.borderColor = "red";

    }
}

function validateTelephone(){
  var telephone = document.getElementById("telephone");
  var res = /^[9|6|7][0-9]{8}$/.test(telephone.value);

  if(!res){
      document.getElementById("telephone").style.borderColor = "red";
  }else{
    document.getElementById("telephone").style.borderColor = "#3c3a37";
  }
}


function validateUsername(){
  var username = document.getElementById("username");
  var res = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(username.value);

  if(!res){
      document.getElementById("username").style.borderColor = "red";
  }else{
    document.getElementById("username").style.borderColor = "#3c3a37";
  }
}

function validatePassword(){
  var password = document.getElementById("password");
  var res = /^[A-Za-zñÑáéíóúÁÉÍÓÚ0-9\.]{5,20}$/.test(password.value);

  if(!res){
    document.getElementById("password").style.borderColor = "red";
  }else{
    document.getElementById("password").style.borderColor = "#3c3a37";
  }
}

function validateRepeatPassword(){
  var repeatPassword = document.getElementById("repeatpassword");
  var res = /^[A-Za-zñÑáéíóúÁÉÍÓÚ0-9\.]{5,20}$/.test(repeatPassword.value);

  if(!res){
    document.getElementById("repeatpassword").style.borderColor = "red";
  }else{
    document.getElementById("repeatpassword").style.borderColor = "#3c3a37";
  }
}

</script>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=users&amp;action=show"><?= i18n("Users List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Modify User") ?></li>
</ol>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Modify User") ?></h4>
  </div>
  <form enctype="multipart/form-data" action="index.php?controller=users&amp;action=update" method="POST">
    <input type="hidden" name="id_user" value="<?= $user->getId_user() ?>">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-6">
        <label for="name"><?=i18n("Name")?></label>
        <input type="text" class="form-control" id="name" onblur="validateName()" name="name" value="<?= $user->getName() ?>" placeholder="<?= $user->getName() ?>">
        <?php if(isset($errors["name"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["name"])?i18n($errors["name"]):"" ?>
            </div>
        <?php } ?>
      </div>
      <div class="form-group col-md-6">
        <label for="surname"><?=i18n("Surname")?></label>
        <input type="text" class="form-control" id="surname" onblur="validateSurname()" name="surname" value="<?= $user->getSurname() ?>" placeholder="<?= $user->getSurname() ?>">
        <?php if(isset($errors["surname"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["surname"])?i18n($errors["surname"]):"" ?>
            </div>
        <?php } ?>
      </div>
      <div class="form-group col-md-4">
        <label for="dni"><?=i18n("DNI")?></label>
        <input type="text" class="form-control" id="dni" name="dni" onblur="validateDni()" value="<?= $user->getDni() ?>" placeholder="<?= $user->getDni() ?>">
        <?php if(isset($errors["dni"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["dni"])?i18n($errors["dni"]):"" ?>
            </div>
        <?php } ?>
      </div>
      <div class="form-group col-md-4">
        <label for="birthdate"><?=i18n("Birthdate")?></label>
        <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?=$user->getBirthdate()?>">
        <?php if(isset($errors["birthdate"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["birthdate"])?i18n($errors["birthdate"]):"" ?>
            </div>
        <?php } ?>
      </div>
      <div class="form-group col-md-4">
        <label for="telephone"><?=i18n("Telephone")?></label>
        <input type="tel" class="form-control" id="telephone" onblur="validateTelephone()" name="telephone" value="<?= $user->getTelephone() ?>" placeholder="<?= $user->getTelephone() ?>">
        <?php if(isset($errors["telephone"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["telephone"])?i18n($errors["telephone"]):"" ?>
            </div>
        <?php } ?>
      </div>
      <div class="form-group col-md-4">
        <label for="username"><?=i18n("Email")?></label>
        <input type="email" class="form-control" id="username" onblur="validateUsername()" name="username" value="<?= $user->getUsername() ?>" placeholder="<?= $user->getUsername() ?>">
        <?php if(isset($errors["email"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["email"])?i18n($errors["email"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-4">
        <label for="password"><?=i18n("Password")?></label>
        <input type="password" class="form-control" id="password" onblur="validatePassword()" name="password" placeholder="<?=i18n("Password")?>">
        <?php if(isset($errors["password"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["password"])?i18n($errors["password"]):"" ?>
            </div>
        <?php } ?>
      </div>
      <div class="form-group col-md-4">
        <label for="repeatpassword"><?=i18n("Repeat Password")?></label>
        <input type="password" class="form-control" id="repeatpassword" onblur="validateRepeatPassword()" name="repeatpassword" placeholder="<?=i18n("Repeat Password")?>">
      </div>
      <div id="a" class="form-group col-md-2">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="isAdministrator" name="isAdministrator" value="1" <?php if($user->getIs_administrator() == 1){ ?>checked="checked" <?php } ?>/>
            <label class="custom-control-label" for="isAdministrator"><?=i18n("Administrator")?></label>
        </div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="isTrainer" name="isTrainer" value="1" <?php if($user->getIs_trainer() == 1){ ?>checked="checked" <?php } ?>/>
            <label class="custom-control-label" for="isTrainer"><?=i18n("Trainer")?></label>
        </div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="isPupil" name="isPupil" value="1" <?php if($user->getIs_pupil() == 1){ ?>checked="checked" <?php } ?>/>
            <label class="custom-control-label" for="isPupil"><?=i18n("Pupil")?></label>
        </div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="isCompetitor" name="isCompetitor" value="1" <?php if($user->getIs_competitor() == 1){ ?>checked="checked" <?php } ?>/>
            <label class="custom-control-label" for="isCompetitor"><?=i18n("Competitor")?></label>
        </div>
        <?php if(isset($errors["type"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["type"])?i18n($errors["type"]):"" ?>
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

    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Update")?></button>
  </form>
</div>
