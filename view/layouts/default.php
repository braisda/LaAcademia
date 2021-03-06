<?php
//file: view/layouts/default.php

$view = ViewManager::getInstance();
$currentuser = $view->getVariable("currentusername");

?>
<!DOCTYPE html>
<html>
<head>


	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link href="css/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
	<title><?= $view->getVariable("title", "La Academia") ?></title>
	<meta charset="utf-8">

	<!-- enable ji18n() javascript function to translate inside your scripts -->
	<script src="index.php?controller=language&amp;action=i18njs">
	</script>
	<?= $view->getFragment("css") ?>
	<?= $view->getFragment("javascript") ?>
</head>
<body>
	<!-- header -->
	<header>
		<div id="presentation">
			<a href="index.php">
				<img id="logo_icon" src="multimedia/images/logo.jpg">
			</a>
			<h3 id="page_title"></h3>
			<div id="right_elements">
			<?php if (isset($currentuser)): ?>
				<div id="welcome">
					<p><?= i18n("Welcome "), $currentuser ?> <a href="index.php?controller=users&amp;action=logout"> <span class="oi oi-account-logout "></span></a></p>
				</div>

			<?php endif ?>
			<?php
				include(__DIR__."/language_select_element.php");
			?>
			</div>
		 </div>
		 <nav id="menu" class="navbar navbar-expand-lg navbar-light bg-light">
			 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			   <span class="navbar-toggler-icon"></span>
			 </button>

			 <div class="collapse navbar-collapse" id="navbarSupportedContent">
				 <?php if (isset($_SESSION["currentuser"])): ?>
			   <ul class="navbar-nav ml-auto">

					 <li class="nav-item">
 						<a id="texto_menu" class="nav-link" href="index.php"><?= i18n("Academy") ?></a>
 					</li>

					<?php if ($_SESSION["admin"] || $_SESSION["trainer"]){ ?>
						<li class="nav-item dropdown">
			        <a id="texto_menu" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<?= i18n("Users") ?>
			        </a>
			        <div id="submenu" class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a id="texto_menu" class="dropdown-item" href="index.php?controller=users&amp;action=viewProfile"><?= i18n("My Profile") ?></a>
			          <a id="texto_menu" class="dropdown-item" href="index.php?controller=users&amp;action=show"><?= i18n("Users") ?></a>
			        </div>
			      </li>
					<?php }else{ ?>
						<li class="nav-item">
			        <a id="texto_menu" class="nav-link" href="index.php?controller=users&amp;action=viewProfile"><?= i18n("My Profile") ?></a>
			      </li>
					<?php } ?>

					<?php if ($_SESSION["admin"] || $_SESSION["trainer"]){ ?>
					<li class="nav-item">
		        <a id="texto_menu" class="nav-link" href="index.php?controller=spaces&amp;action=show"><?= i18n("Spaces") ?></a>
		      </li>
					<?php } ?>

					<?php if (!$_SESSION["competitor"]){ ?>
						<?php if ($_SESSION["admin"] || $_SESSION["pupil"]){ ?>
							<li class="nav-item dropdown">
				        <a id="texto_menu" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				          <?= i18n("Courses") ?>
				        </a>
				        <div id="submenu" class="dropdown-menu" aria-labelledby="navbarDropdown">
				          <a id="texto_menu" class="dropdown-item" href="index.php?controller=courses&amp;action=show"><?= i18n("Courses") ?></a>
									<a id="texto_menu" class="dropdown-item" href="index.php?controller=courseReservations&amp;action=show"><?= i18n("Reservations") ?></a>
				        </div>
				      </li>
						<?php }else{ ?>
							<li class="nav-item">
								<a id="texto_menu" class="nav-link" href="index.php?controller=courses&amp;action=show"><?= i18n("Courses") ?></a>
							</li>
							<?php } ?>
					<?php } ?>

					<?php if (!$_SESSION["trainer"]){ ?>
						<li class="nav-item dropdown">
			        <a id="texto_menu" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			          <?= i18n("Events") ?>
			        </a>
			        <div id="submenu" class="dropdown-menu" aria-labelledby="navbarDropdown">
			          <a id="texto_menu" class="nav-link" href="index.php?controller=events&amp;action=show"><?= i18n("Events") ?></a>
								<a id="texto_menu" class="dropdown-item" href="index.php?controller=eventReservations&amp;action=show"><?= i18n("Reservations") ?></a>
			        </div>
			      </li>
					<?php }else{ ?>
						<li class="nav-item">
							<a id="texto_menu" class="nav-link" href="index.php?controller=events&amp;action=show"><?= i18n("Events") ?></a>
						</li>
					<?php } ?>

					<?php if (!$_SESSION["pupil"]){ ?>
						<?php if ($_SESSION["admin"] || $_SESSION["competitor"]){ ?>
							<li class="nav-item dropdown">
				        <a id="texto_menu" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				          <?= i18n("Tournaments") ?>
				        </a>
				        <div id="submenu" class="dropdown-menu" aria-labelledby="navbarDropdown">
				          <a id="texto_menu" class="dropdown-item" href="index.php?controller=tournaments&amp;action=show"><?= i18n("Tournaments") ?></a>
									<a id="texto_menu" class="dropdown-item" href="index.php?controller=tournamentReservations&amp;action=show"><?= i18n("Reservations") ?></a>
				        </div>
				      </li>
						<?php }else{ ?>
							<li class="nav-item">
								<a id="texto_menu" class="nav-link" href="index.php?controller=tournaments&amp;action=show"><?= i18n("Tournaments") ?></a>
							</li>
							<?php } ?>
					<?php } ?>

						<li class="nav-item">
			        <a id="texto_menu" class="nav-link" href="index.php?controller=notifications&amp;action=show"><?= i18n("Notifications") ?></a>
			      </li>

		    </ul>
				<?php endif ?>
		  </div>
		</nav>
	</header>

	<main id = "main">
		<?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
	</main>

	<footer id="footer">
		<div id="sponsors">
			<h4><?= i18n("Sponsors") ?></h4>
			<ul class="footer_list" >
				<li><a href="https://www.head.com/en-IC/home/" target="_blank"><img class="footer_icons" src="multimedia/images/sponsors/head_logo.png"></a></li>
				<li><a href="http://domiweb.esy.es/" target="_blank"><img class="footer_icons" src="multimedia/images/sponsors/domiweb_logo.png"></a></li>
				<li><a href="https://www.mapfre.es/seguros/particulares/" target="_blank"><img class="footer_icons4" src="multimedia/images/sponsors/mapfre_logo.jpg"></a></li>
			</ul>
		</div>

		<div id="providers">
			<h4><?= i18n("Providers") ?></h4>
			<ul class="footer_list">
				<li><a href="https://www.joma-sport.com/" target="_blank"><img class="footer_icons2" src="multimedia/images/providers/joma_logo.png"></a></li>
				<li><a href="https://www.cocacola.es/powerade/es/home/" target="_blank"><img class="footer_icons5" src="multimedia/images/providers/powerade_logo.png"></a></li>
				<li><a href="https://www.wilson.com/es-es" target="_blank"><img class="footer_icons2" src="multimedia/images/providers/wilson_logo.png"></a></li>
			</ul>
		</div>

		<div id="social_networks">
			<h4><?= i18n("Social Networks") ?></h4>
			<ul class="footer_list">
				<li><a href="https://www.facebook.com/" target="_blank"><img class="footer_icons3" src="multimedia/images/socialNetworks/facebook_icon.png"></a></li>
				<li><a href="https://www.instagram.com/" target="_blank"><img class="footer_icons3" src="multimedia/images/socialNetworks/instagram_icon.png"></a></li>
				<li><a href="https://twitter.com/" target="_blank"><img class="footer_icons3" src="multimedia/images/socialNetworks/twitter_icon.png"></a></li>
			</ul>
	</footer>
</body>

</html>
