<?php
// file: view/matchs/add.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$tournament = $view->getVariable("tournament");
$draw = $view->getVariable("draw");
$draw = $view->getVariable("draw");
$competitors = $view->getVariable("competitors");
$spaces = $view->getVariable("spaces");
$cell = $view->getVariable("cell");
$round = $view->getVariable("round");
$match = $view->getVariable("match");
$view->setVariable("title", i18n("Update Match"));
$errors = $view->getVariable("errors"); 
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=show"><?= i18n("Tournaments List") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=view&amp;id_tournament=<?= $tournament ?>"><?= i18n("Tournament Information") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=draws&amp;action=show&amp;id_tournament=<?= $tournament ?>"><?= i18n("Draws List") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=draws&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>"><?= i18n("Draw Information") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=matches&amp;action=show&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>"><?= i18n("Matches List") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Update Match") ?></li>
</ol>

<div class="container" id="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Add Match") ?></h4>
  </div>
  <form action="index.php?controller=matches&amp;action=update" method="POST">
    <input type="hidden" name="id_tournament" value="<?= $tournament ?>">
    <input type="hidden" name="id_draw" value="<?= $draw ?>">
    <input type="hidden" name="cell" value="<?= $cell ?>">
    <input type="hidden" name="round" value="<?= $round ?>">
    <input type="hidden" name="id_match" value="<?= $match->getId_match() ?>">
    <div id="background_table" class="form-row">
      <div class="form-group col-md-3">
        <label for="rival1a"><?=i18n("Riva 1A")?></label>
        <select name="rival1a" class="form-control" id="select" rows="8">
          <option></option>
          <?php
            foreach ($competitors as $competitor) {
              ?>
              <?php if($match->getRival1a() == $competitor->getId_user()){ ?>
                <option selected value="<?= $competitor->getId_user() ?>"> <?= $competitor->getName()," ", $competitor->getSurname() ?></option>
              <?php }else{ ?>
                <option value="<?= $competitor->getId_user() ?>"><?= $competitor->getName()," ", $competitor->getSurname() ?></option>
              <?php }?>
            <?php
            }
          ?>
        </select>
        <?php if(isset($errors["rival1a"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["rival1a"])?i18n($errors["rival1a"]):"" ?>
            </div>
        <?php } ?>
        <!-- this is repeatd because of duplicated error match -->
        <?php if(isset($errors["rival"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["rival"])?i18n($errors["rival"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-3">
        <label for="rival1b"><?=i18n("Riva 1B")?></label>
        <select name="rival1b" class="form-control" id="select" rows="8">
          <option></option>
          <?php
            foreach ($competitors as $competitor) {
              ?>
              <?php if($match->getRival1b() == $competitor->getId_user()){ ?>
                <option selected value="<?= $competitor->getId_user() ?>"> <?= $competitor->getName()," ", $competitor->getSurname() ?></option>
              <?php }else{ ?>
                <option value="<?= $competitor->getId_user() ?>"><?= $competitor->getName()," ", $competitor->getSurname() ?></option>
              <?php }?>
              <?php
            }
          ?>
        </select>
        <?php if(isset($errors["rival1b"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["rival1b"])?i18n($errors["rival1b"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-1">
        <label for="set1a"><?=i18n("Set1")?></label>
        <input class="form-control" type="number" value="<?= $match->getSet1a() ?>" id="set" name="set1a">
        <?php if(isset($errors["set"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["set"])?i18n($errors["set"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-1">
        <label for="set2a"><?=i18n("Set2")?></label>
        <input class="form-control" type="number" value="<?= $match->getSet2a() ?>" id="set" name="set2a">
        <?php if(isset($errors["set"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["set"])?i18n($errors["set"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-1">
        <label for="set3a"><?=i18n("Set3")?></label>
        <input class="form-control" type="number" value="<?= $match->getSet3a() ?>" id="set" name="set3a">
        <?php if(isset($errors["set"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["set"])?i18n($errors["set"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-1">
        <label for="set4a"><?=i18n("Set4")?></label>
        <input class="form-control" type="number" value="<?= $match->getSet4a() ?>" id="set" name="set4a">
        <?php if(isset($errors["set"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["set"])?i18n($errors["set"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-1">
        <label for="set5a"><?=i18n("Set5")?></label>
        <input class="form-control" type="number" value="<?= $match->getSet5a() ?>" id="set" name="set5a">
        <?php if(isset($errors["set"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["set"])?i18n($errors["set"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-3">
        <label for="rival2a"><?=i18n("Riva 2A")?></label>
        <select name="rival2a" class="form-control" id="select" rows="8">
          <option></option>
          <?php
            foreach ($competitors as $competitor) {
              ?>
              <?php if($match->getRival2a() == $competitor->getId_user()){ ?>
                <option selected value="<?= $competitor->getId_user() ?>"> <?= $competitor->getName()," ", $competitor->getSurname() ?></option>
              <?php }else{ ?>
                <option value="<?= $competitor->getId_user() ?>"><?= $competitor->getName()," ", $competitor->getSurname() ?></option>
              <?php }?>
              <?php
            }
          ?>
        </select>
        <?php if(isset($errors["rival2a"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["rival2a"])?i18n($errors["rival2a"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-3">
        <label for="rival2b"><?=i18n("Riva 2B")?></label>
        <select name="rival2b" class="form-control" id="select" rows="8">
          <option></option>
          <?php
            foreach ($competitors as $competitor) {
              ?>
              <?php if($match->getRival2b() == $competitor->getId_user()){ ?>
                <option selected value="<?= $competitor->getId_user() ?>"> <?= $competitor->getName()," ", $competitor->getSurname() ?></option>
              <?php }else{ ?>
                <option value="<?= $competitor->getId_user() ?>"><?= $competitor->getName()," ", $competitor->getSurname() ?></option>
              <?php }?>
              <?php
            }
          ?>
        </select>
        <?php if(isset($errors["rival2b"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["rival2b"])?i18n($errors["rival2b"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-1">
        <label for="set1b"><?=i18n("Set1")?></label>
        <input class="form-control" type="number" value="<?= $match->getSet1b() ?>" id="set" name="set1b">
        <?php if(isset($errors["set"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["set"])?i18n($errors["set"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-1">
        <label for="set2b"><?=i18n("Set2")?></label>
        <input class="form-control" type="number" value="<?= $match->getSet2b() ?>" id="set" name="set2b">
        <?php if(isset($errors["set"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["set"])?i18n($errors["set"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-1">
        <label for="set3b"><?=i18n("Set3")?></label>
        <input class="form-control" type="number" value="<?= $match->getSet3b() ?>" id="set" name="set3b">
        <?php if(isset($errors["set"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["set"])?i18n($errors["set"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-1">
        <label for="set4b"><?=i18n("Set4")?></label>
        <input class="form-control" type="number" value="<?= $match->getSet4b() ?>" id="set" name="set4b">
        <?php if(isset($errors["set"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["set"])?i18n($errors["set"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-1">
        <label for="set5b"><?=i18n("Set5")?></label>
        <input class="form-control" type="number" value="<?= $match->getSet5b() ?>" id="set" name="set5b">
        <?php if(isset($errors["set"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["set"])?i18n($errors["set"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="date"><?=i18n("Date")?></label>
        <input id="date" type="date" name="date" value="<?= $match->getDate() ?>" class="form-control">
        <?php if(isset($errors["date"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["date"])?i18n($errors["date"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="type"><?=i18n("Time")?></label>
        <input class="form-control" type="time" value="<?= $match->getTime() ?>" id="time" name="time">
        <?php if(isset($errors["time"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["time"])?i18n($errors["time"]):"" ?>
            </div>
        <?php } ?>
      </div>

      <div class="form-group col-md-2">
        <label for="space"><?=i18n("Spaces")?></label>
        <select name="space" class="form-control" id="select" rows="8">
          <option></option>
          <?php
          foreach ($spaces as $space) { ?>
            <?php if($match->getId_space() == $space["id_space"]){ ?>

              <option selected value="<?= $space["id_space"] ?>"> <?= $space["name"] ?></option>
            <?php }else{ ?>
              <option value="<?= $space["id_space"] ?>"> <?= $space["name"] ?></option>
            <?php }?>


          <?php } ?>
        </select>
        <?php if(isset($errors["space"])){ ?>
            <div class="alert alert-danger" role="alert">
              <strong><?= i18n("Error!") ?></strong> <?= isset($errors["space"])?i18n($errors["space"]):"" ?>
            </div>
        <?php } ?>
      </div>

    </div>
    <br/>
    <button type="submit" name="submit" class="btn btn-primary"><?=i18n("Update")?></button>
  </form>
</div>
