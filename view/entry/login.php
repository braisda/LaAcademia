<?php
//file: view/entry/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setLayout("default");
$view->setVariable("title", "Login");
$errors = $view->getVariable("errors");
?>

<div id="login_form" >
  <form action="index.php?controller=users&amp;action=login" method="post">
			<input type="text" name="username" placeholder="<?= i18n("Username")?>" />

			<input type="password" name="passwd" placeholder="<?= i18n("Password")?>" />

			<button type="submit">Logg In</button>
		<a class="forgot" href="index.php?controller=users&amp;action=recover"><?= i18n("Forgot your password?")?></a>
	</form>

</div>







<?php $view->moveToFragment("css");?>
<link rel="stylesheet" type="text/css" src="css/style.css">
<?php $view->moveToDefaultFragment(); ?>
