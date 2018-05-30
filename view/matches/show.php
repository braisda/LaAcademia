<?php
// file: view/draws/view.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$competitors = $view->getVariable("competitors");
$matches = $view->getVariable("matches");
$tournament = $view->getVariable("tournament");
$draw = $view->getVariable("draw");
$view->setVariable("title", "Matches List");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=show"><?= i18n("Tournaments List") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=view&amp;id_tournament=<?= $tournament ?>"><?= i18n("Tournament Information") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=draws&amp;action=show&amp;id_tournament=<?= $tournament ?>"><?= i18n("Draws List") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=draws&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>"><?= i18n("Draw Information") ?></a></li>
  <li class="breadcrumb-item active"><a href="index.php?controller=tournaments&amp;action=show"><?= i18n("Matches List") ?></a></li>
</ol>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Matches List") ?></h4>
  </div>

  <div class="row justify-content-around">

    <div id="background_table" class="col-12">
      <div class="table-responsive">
        <br/>
            <table id="table_color" class="table table-sm table-dark">
              <thead class="thead-dark">
                <tr>
                  <th><?=i18n("Round of 32")?></th>
                  <th><?=i18n("Round of 16")?></th>
                  <th><?=i18n("Quarter Final")?></th>
                  <th><?=i18n("Semi Final")?></th>
                  <th><?=i18n("Final")?></th>
                  <th><?=i18n("Winner")?></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <?php
                    $name = "";
                      $flag = false;
                      foreach ($matches as $match) {
                        if($match->getRound() == "round of 32" && $match->getCell() == "0,0" && $match->getId_draw() == $draw){
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name = $competitor->getName();
                              $surname = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2 = $competitor->getName();
                              $surname2 = $competitor->getSurname();
                            }
                          }
                    ?>
                          <?= $name ?>  <?= $surname ?>
                          <br/>
                          <?= $name2 ?> <?= $surname2 ?>
                          <br/>
                    <?php
                          $flag = true;
                        }
                      }
                      if(!$flag){
                    ?>
                        <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                    <?php
                      }else{
                    ?>
                        <a href="index.php">M</a>
                    <?php
                      }
                    ?>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td></td>
                  <td>
                    <?php
                      $flag = false;
                      foreach ($matches as $match) {
                        if($match->getRound() == "round of 16" && $match->getCell() == "1,1" && $match->getId_draw() == $draw){
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name = $competitor->getName();
                              $surname = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2 = $competitor->getName();
                              $surname2 = $competitor->getSurname();
                            }
                          }
                    ?>
                          <?= $name ?>  <?= $surname ?>
                          <br/>
                          <?= $name2 ?> <?= $surname2 ?>
                          <br/>
                    <?php
                          $flag = true;
                        }
                      }
                      if(!$flag){
                    ?>
                        <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                    <?php
                      }else{
                    ?>
                        <a href="index.php">M</a>
                    <?php
                      }
                    ?>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td>
                    <?php
                      $flag = false;
                      foreach ($matches as $match) {
                        if($match->getRound() == "round of 32" && $match->getCell() == "0,2" && $match->getId_draw() == $draw){
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name = $competitor->getName();
                              $surname = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2 = $competitor->getName();
                              $surname2 = $competitor->getSurname();
                            }
                          }
                    ?>
                          <?= $name ?>  <?= $surname ?>
                          <br/>
                          <?= $name2 ?> <?= $surname2 ?>
                          <br/>
                    <?php
                          $flag = true;
                        }
                      }
                      if(!$flag){
                    ?>
                        <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                    <?php
                      }else{
                    ?>
                        <a href="index.php">M</a>
                    <?php
                      }
                    ?>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td></td>
                  <td></td>
                  <td>
                    <?php
                      $flag = false;
                      foreach ($matches as $match) {
                        if($match->getRound() == "cuarterfinal" && $match->getCell() == "2,3" && $match->getId_draw() == $draw){
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name = $competitor->getName();
                              $surname = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2 = $competitor->getName();
                              $surname2 = $competitor->getSurname();
                            }
                          }
                    ?>
                          <?= $name ?>  <?= $surname ?>
                          <br/>
                          <?= $name2 ?> <?= $surname2 ?>
                          <br/>
                    <?php
                          $flag = true;
                        }
                      }
                      if(!$flag){
                    ?>
                        <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                    <?php
                      }else{
                    ?>
                        <a href="index.php">M</a>
                    <?php
                      }
                    ?>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td>
                    <?php
                      $flag = false;
                      foreach ($matches as $match) {
                        if($match->getRound() == "round of 32" && $match->getCell() == "0,4" && $match->getId_draw() == $draw){
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name = $competitor->getName();
                              $surname = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2 = $competitor->getName();
                              $surname2 = $competitor->getSurname();
                            }
                          }
                    ?>
                          <?= $name ?>  <?= $surname ?>
                          <br/>
                          <?= $name2 ?> <?= $surname2 ?>
                          <br/>
                    <?php
                          $flag = true;
                        }
                      }
                      if(!$flag){
                    ?>
                        <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                    <?php
                      }else{
                    ?>
                        <a href="index.php">M</a>
                    <?php
                      }
                    ?>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td></td>
                  <td>
                    <?php
                      $flag = false;
                      foreach ($matches as $match) {
                        if($match->getRound() == "round of 16" && $match->getCell() == "1,5" && $match->getId_draw() == $draw){
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name = $competitor->getName();
                              $surname = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2 = $competitor->getName();
                              $surname2 = $competitor->getSurname();
                            }
                          }
                    ?>
                          <?= $name ?>  <?= $surname ?>
                          <br/>
                          <?= $name2 ?> <?= $surname2 ?>
                          <br/>
                    <?php
                          $flag = true;
                        }
                      }
                      if(!$flag){
                    ?>
                        <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                    <?php
                      }else{
                    ?>
                        <a href="index.php">M</a>
                    <?php
                      }
                    ?>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td>
                    <?php
                      $flag = false;
                      foreach ($matches as $match) {
                        if($match->getRound() == "round of 32" && $match->getCell() == "0,6" && $match->getId_draw() == $draw){
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name = $competitor->getName();
                              $surname = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2 = $competitor->getName();
                              $surname2 = $competitor->getSurname();
                            }
                          }
                    ?>
                          <?= $name ?>  <?= $surname ?>
                          <br/>
                          <?= $name2 ?> <?= $surname2 ?>
                          <br/>
                    <?php
                          $flag = true;
                        }
                      }
                      if(!$flag){
                    ?>
                        <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                    <?php
                      }else{
                    ?>
                        <a href="index.php">M</a>
                    <?php
                      }
                    ?>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <?php
                      $flag = false;
                      foreach ($matches as $match) {
                        if($match->getRound() == "semifinal" && $match->getCell() == "3,7" && $match->getId_draw() == $draw){
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name = $competitor->getName();
                              $surname = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2 = $competitor->getName();
                              $surname2 = $competitor->getSurname();
                            }
                          }
                    ?>
                          <?= $name ?>  <?= $surname ?>
                          <br/>
                          <?= $name2 ?> <?= $surname2 ?>
                          <br/>
                    <?php
                          $flag = true;
                        }
                      }
                      if(!$flag){
                    ?>
                        <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                    <?php
                      }else{
                    ?>
                        <a href="index.php">M</a>
                    <?php
                      }
                    ?>
                  </td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td>
                    <?php
                      $flag = false;
                      foreach ($matches as $match) {
                        if($match->getRound() == "round of 32" && $match->getCell() == "0,8" && $match->getId_draw() == $draw){
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name = $competitor->getName();
                              $surname = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2 = $competitor->getName();
                              $surname2 = $competitor->getSurname();
                            }
                          }
                    ?>
                          <?= $name ?>  <?= $surname ?>
                          <br/>
                          <?= $name2 ?> <?= $surname2 ?>
                          <br/>
                    <?php
                          $flag = true;
                        }
                      }
                      if(!$flag){
                    ?>
                        <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                    <?php
                      }else{
                    ?>
                        <a href="index.php">M</a>
                    <?php
                      }
                    ?>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td></td>
                  <td>
                    <?php
                      $flag = false;
                      foreach ($matches as $match) {
                        if($match->getRound() == "round of 16" && $match->getCell() == "1,9" && $match->getId_draw() == $draw){
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name = $competitor->getName();
                              $surname = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2 = $competitor->getName();
                              $surname2 = $competitor->getSurname();
                            }
                          }
                    ?>
                          <?= $name ?>  <?= $surname ?>
                          <br/>
                          <?= $name2 ?> <?= $surname2 ?>
                          <br/>
                    <?php
                          $flag = true;
                        }
                      }
                      if(!$flag){
                    ?>
                        <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                    <?php
                      }else{
                    ?>
                        <a href="index.php">M</a>
                    <?php
                      }
                    ?>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>

              <tr>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 32" && $match->getCell() == "0,10" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td></td>
                <td></td>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "cuarterfinal" && $match->getCell() == "2,11" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 32" && $match->getCell() == "0,12" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 16" && $match->getCell() == "1,13" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 32" && $match->getCell() == "0,14" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "final" && $match->getCell() == "4,15" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "champion" && $match->getCell() == "5,15" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
              </tr>

              <tr>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 32" && $match->getCell() == "0,16" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 16" && $match->getCell() == "1,17" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "consolation" && $match->getCell() == "4,17" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "third place" && $match->getCell() == "5,17" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
              </tr>

              <tr>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 32" && $match->getCell() == "0,18" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td></td>
                <td></td>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "cuarterfinal" && $match->getCell() == "2,19" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 32" && $match->getCell() == "0,20" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 16" && $match->getCell() == "1,21" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 32" && $match->getCell() == "0,22" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "semifinal" && $match->getCell() == "3,23" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 32" && $match->getCell() == "0,24" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 16" && $match->getCell() == "1,25" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 32" && $match->getCell() == "0,26" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td></td>
                <td></td>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "cuarterfinal" && $match->getCell() == "2,27" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 32" && $match->getCell() == "0,28" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 16" && $match->getCell() == "1,29" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td>
                  <?php
                    $flag = false;
                    foreach ($matches as $match) {
                      if($match->getRound() == "round of 32" && $match->getCell() == "0,30" && $match->getId_draw() == $draw){
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name = $competitor->getName();
                            $surname = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2 = $competitor->getName();
                            $surname2 = $competitor->getSurname();
                          }
                        }
                  ?>
                        <?= $name ?>  <?= $surname ?>
                        <br/>
                        <?= $name2 ?> <?= $surname2 ?>
                        <br/>
                  <?php
                        $flag = true;
                      }
                    }
                    if(!$flag){
                  ?>
                      <a href="index.php?controller=matches&amp;action=add"><span class="oi oi-plus"></a>
                  <?php
                    }else{
                  ?>
                      <a href="index.php">M</a>
                  <?php
                    }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              </tbody>
            </table>
        </div>
    </div>
</div>