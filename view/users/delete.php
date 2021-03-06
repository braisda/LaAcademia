<?php
// file: view/users/delete.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$user = $view->getVariable("user");
$view->setVariable("title", i18n("Delete User"));
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=users&amp;action=show"><?= i18n("Users List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Delete User") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Delete User") ?></h4>
  </div>
  <div class="row justify-content-center">
    <div id="card" class="card" style="width: 18rem;">
      <img class="card-img-top" src="<?= $user->getImage() ?>" alt="Card image cap">
      <div id="card_body" class="card-body">
        <h5 class="card-title"><?= $user->getName() ?> <?= $user->getSurname() ?></h5>
        <p class="card-text"><?= i18n("User of type admin") ?></p>
      </div>
      <ul id="background_table2"  class="list-group list-group-flush">
        <li id="table_color" class="list-group-item"><?= i18n("Dni:") ?> <?= $user->getDni() ?></li>
        <li id="table_color" class="list-group-item"><?= i18n("Birthdate:") ?> <?= date("d-m-Y", strtotime($user->getBirthdate())); ?></li>
        <li id="table_color" class="list-group-item"><?= i18n("Email:") ?> <?= $user->getUsername() ?></li>
        <li id="table_color" class="list-group-item"><?= i18n("Telephone:") ?> <?= $user->getTelephone() ?></li>
      </ul>
    </br>

    <form action="index.php?controller=users&amp;action=delete" method="POST">
      <input type="hidden" name="id_user" value="<?= $user->getId_user() ?>">
      <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Delete")?></button>
    </form>

    </div>
  </div>
</div>
