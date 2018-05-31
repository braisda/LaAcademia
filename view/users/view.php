<?php
// file: view/users/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
// $view->setLayout("welcome");
$user = $view->getVariable ( "user" );
$view->setVariable ( "title", "View User" );
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=users&amp;action=show"><?= i18n("Users List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("View User") ?></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("User Information") ?></h4>
  </div>
  <div class="row justify-content-center">
    <div id="card" class="card" style="width: 18rem;">
      <img class="card-img-top" src="<?= $user->getImage() ?>" alt="Profil image">
      <div id="card_body" class="card-body">
        <h5 class="card-title"><?= $user->getName() ?> <?= $user->getSurname() ?></h5>

        <p class="card-text"><?= i18n("User of type ") ?> <?= i18n($user->getType()) ?> </p>
      </div>
      <ul id="background_table2"  class="list-group list-group-flush">
        <li id="table_color" class="list-group-item"><?= i18n("Dni:") ?> <?= $user->getDni() ?></li>
        <li id="table_color" class="list-group-item"><?= i18n("Birthdate:") ?> <?= date("d-m-Y", strtotime($user->getBirthdate())); ?></li>
        <li id="table_color" class="list-group-item"><?= i18n("Email:") ?> <?= $user->getUsername() ?></li>
        <li id="table_color" class="list-group-item"><?= i18n("Telephone:") ?> <?= $user->getTelephone() ?></li>
        <li id="table_color" class="list-group-item">
          <a href="index.php?controller=users&amp;action=update&amp;id_user=<?= $user->getId_user() ?>" class="card-link"><span class="oi oi-loop"></span></a>
          <a href="index.php?controller=users&amp;action=delete&amp;id_user=<?= $user->getId_user() ?>" class="card-link"><span class="oi oi-trash"></a>
        </li>
      </ul>

    </div>
  </div>
</div>
