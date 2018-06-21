<?php
// file: view/draws/view.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance ();
$competitors = $view->getVariable("competitors");
$matches = $view->getVariable("matches");
$tournament = $view->getVariable("tournament");
$draw = $view->getVariable("draw");
$view->setVariable("title", i18n("Matches List"));
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=show"><?= i18n("Tournaments List") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=tournaments&amp;action=view&amp;id_tournament=<?= $tournament ?>"><?= i18n("Tournament Information") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=draws&amp;action=show&amp;id_tournament=<?= $tournament ?>"><?= i18n("Draws List") ?></a></li>
  <li class="breadcrumb-item"><a href="index.php?controller=draws&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>"><?= i18n("Draw Information") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Matches List") ?></li>
</ol>

<?php $alert = "" ?>
<?php if($alert =($view->popFlash())){ ?>
    <div class="alert alert-success" role="alert">
      <?= $alert ?>
    </div>
<?php } ?>

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
                  <td class="draw_td right">
                    <?php
                      $flag = false;
                      $id_match = NULL;
                      $name1a = NULL;
                      $surname1a = NULL;
                      $name1b = NULL;
                      $surname1b = NULL;
                      $name2a = NULL;
                      $surname2a = NULL;
                      $name2b = NULL;
                      $surname2b = NULL;
                      foreach ($matches as $match) {
                        if($match->getRound() == "roundof32" && $match->getCell() == "0,0" && $match->getId_draw() == $draw){
                          $id_match = $match->getId_match();
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name1a = $competitor->getName();
                              $surname1a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival1b()){
                              $name1b = $competitor->getName();
                              $surname1b = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2a = $competitor->getName();
                              $surname2a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2b()){
                              $name2b = $competitor->getName();
                              $surname2b = $competitor->getSurname();
                            }
                          }
                    ?>
                          <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                          <br/>
                          <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                          <br/>
                        <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,0&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                    <?php
                          $flag = true;
                        }
                      }
                      if($_SESSION["admin"]) {
                        if(!$flag){
                      ?>
                          <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,0&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                      <?php
                        }else{
                      ?>
                          <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,0&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                          <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                      <?php
                        }
                      }
                    ?>
                  </td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                </tr>

                <tr>
                  <td class="draw_td none"></td>
                  <td class="draw_td both_side">
                    <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                      foreach ($matches as $match) {
                        if($match->getRound() == "roundof16" && $match->getCell() == "1,1" && $match->getId_draw() == $draw){
                          $id_match = $match->getId_match();
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name1a = $competitor->getName();
                              $surname1a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival1b()){
                              $name1b = $competitor->getName();
                              $surname1b = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2a = $competitor->getName();
                              $surname2a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2b()){
                              $name2b = $competitor->getName();
                              $surname2b = $competitor->getSurname();
                            }
                          }
                          ?>
                                <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                                <br/>
                                <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                                <br/>
                              <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,1&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                          <?php
                                $flag = true;
                              }
                            }
                            if($_SESSION["admin"]) {
                              if(!$flag){
                            ?>
                                <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,1&amp;round=roundof16"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                            <?php
                              }else{
                            ?>
                                <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,1&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                                <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                            <?php
                              }
                            }
                          ?>
                        </td>
                  </td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                </tr>

                <tr>
                  <td class="draw_td right">
                    <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                      foreach ($matches as $match) {
                        if($match->getRound() == "roundof32" && $match->getCell() == "0,2" && $match->getId_draw() == $draw){
                          $id_match = $match->getId_match();
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name1a = $competitor->getName();
                              $surname1a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival1b()){
                              $name1b = $competitor->getName();
                              $surname1b = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2a = $competitor->getName();
                              $surname2a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2b()){
                              $name2b = $competitor->getName();
                              $surname2b = $competitor->getSurname();
                            }
                          }
                          ?>
                                <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                                <br/>
                                <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                                <br/>
                              <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,2&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                          <?php
                                $flag = true;
                              }
                            }
                            if($_SESSION["admin"]) {
                              if(!$flag){
                            ?>
                                <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,2&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                            <?php
                              }else{
                            ?>
                                <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,2&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                                <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                            <?php
                              }
                            }
                          ?>
                        </td>
                  </td>
                  <td class="draw_td right"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                </tr>

                <tr>
                  <td class="draw_td none"></td>
                  <td class="draw_td right"></td>
                  <td class="draw_td right">
                    <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                      foreach ($matches as $match) {
                        if($match->getRound() == "cuarterfinal" && $match->getCell() == "2,3" && $match->getId_draw() == $draw){
                          $id_match = $match->getId_match();
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name1a = $competitor->getName();
                              $surname1a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival1b()){
                              $name1b = $competitor->getName();
                              $surname1b = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2a = $competitor->getName();
                              $surname2a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2b()){
                              $name2b = $competitor->getName();
                              $surname2b = $competitor->getSurname();
                            }
                          }
                          ?>
                                <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                                <br/>
                                <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                                <br/>
                              <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=2,3&amp;round=cuarterfinal&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                          <?php
                                $flag = true;
                              }
                            }
                            if($_SESSION["admin"]) {
                              if(!$flag){
                            ?>
                                <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=2,3&amp;round=cuarterfinal"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                            <?php
                              }else{
                            ?>
                                <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=2,3&amp;round=cuarterfinal&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                                <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                            <?php
                              }
                            }
                          ?>
                        </td>
                  </td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                </tr>

                <tr>
                  <td class="draw_td right">
                    <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                      foreach ($matches as $match) {
                        if($match->getRound() == "roundof32" && $match->getCell() == "0,4" && $match->getId_draw() == $draw){
                          $id_match = $match->getId_match();
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name1a = $competitor->getName();
                              $surname1a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival1b()){
                              $name1b = $competitor->getName();
                              $surname1b = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2a = $competitor->getName();
                              $surname2a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2b()){
                              $name2b = $competitor->getName();
                              $surname2b = $competitor->getSurname();
                            }
                          }
                          ?>
                                <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                                <br/>
                                <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                                <br/>
                              <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,4&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                          <?php
                                $flag = true;
                              }
                            }
                            if($_SESSION["admin"]) {
                              if(!$flag){
                            ?>
                                <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,4&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                            <?php
                              }else{
                            ?>
                                <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,4&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                                <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                            <?php
                              }
                            }
                          ?>
                        </td>
                  </td>
                  <td class="draw_td right"></td>
                  <td class="draw_td right"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                </tr>

                <tr>
                  <td class="draw_td right"></td>
                  <td class="draw_td right">
                    <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                      foreach ($matches as $match) {
                        if($match->getRound() == "roundof16" && $match->getCell() == "1,5" && $match->getId_draw() == $draw){
                          $id_match = $match->getId_match();
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name1a = $competitor->getName();
                              $surname1a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival1b()){
                              $name1b = $competitor->getName();
                              $surname1b = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2a = $competitor->getName();
                              $surname2a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2b()){
                              $name2b = $competitor->getName();
                              $surname2b = $competitor->getSurname();
                            }
                          }
                          ?>
                                <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                                <br/>
                                <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                                <br/>
                              <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,5&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                          <?php
                                $flag = true;
                              }
                            }
                            if($_SESSION["admin"]) {
                              if(!$flag){
                            ?>
                                <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,5&amp;round=roundof16"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                            <?php
                              }else{
                            ?>
                                <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,5&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                                <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                            <?php
                              }
                            }
                          ?>
                        </td>
                  </td>
                  <td class="draw_td right"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                </tr>

                <tr>
                  <td class="draw_td right">
                    <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                      foreach ($matches as $match) {
                        if($match->getRound() == "roundof32" && $match->getCell() == "0,6" && $match->getId_draw() == $draw){
                          $id_match = $match->getId_match();
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name1a = $competitor->getName();
                              $surname1a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival1b()){
                              $name1b = $competitor->getName();
                              $surname1b = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2a = $competitor->getName();
                              $surname2a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2b()){
                              $name2b = $competitor->getName();
                              $surname2b = $competitor->getSurname();
                            }
                          }
                          ?>
                                <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                                <br/>
                                <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                                <br/>
                              <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,6&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                          <?php
                                $flag = true;
                              }
                            }
                            if($_SESSION["admin"]) {
                              if(!$flag){
                            ?>
                                <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,6&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                            <?php
                              }else{
                            ?>
                                <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,6&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                                <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                            <?php
                              }
                            }
                          ?>
                        </td>
                  </td>
                  <td class="draw_td none"></td>
                  <td class="draw_td right"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                </tr>

                <tr>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td right"></td>
                  <td class="draw_td right">
                    <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                      foreach ($matches as $match) {
                        if($match->getRound() == "semifinal" && $match->getCell() == "3,7" && $match->getId_draw() == $draw){
                          $id_match = $match->getId_match();
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name1a = $competitor->getName();
                              $surname1a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival1b()){
                              $name1b = $competitor->getName();
                              $surname1b = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2a = $competitor->getName();
                              $surname2a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2b()){
                              $name2b = $competitor->getName();
                              $surname2b = $competitor->getSurname();
                            }
                          }
                          ?>
                                <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                                <br/>
                                <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                                <br/>
                              <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=3,7&amp;round=semifinal&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                          <?php
                                $flag = true;
                              }
                            }
                            if($_SESSION["admin"]) {
                              if(!$flag){
                            ?>
                                <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=3,7&amp;round=semifinal"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                            <?php
                              }else{
                            ?>
                                <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=3,7&amp;round=semifinal&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                                <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                            <?php
                              }
                            }
                          ?>
                  </td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                </tr>

                <tr>
                  <td class="draw_td right">
                    <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                      foreach ($matches as $match) {
                        if($match->getRound() == "roundof32" && $match->getCell() == "0,8" && $match->getId_draw() == $draw){
                          $id_match = $match->getId_match();
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name1a = $competitor->getName();
                              $surname1a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival1b()){
                              $name1b = $competitor->getName();
                              $surname1b = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2a = $competitor->getName();
                              $surname2a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2b()){
                              $name2b = $competitor->getName();
                              $surname2b = $competitor->getSurname();
                            }
                          }
                    ?>
                          <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                          <br/>
                          <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                          <br/>
                        <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,8&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                    <?php
                          $flag = true;
                        }
                      }
                      if($_SESSION["admin"]) {
                        if(!$flag){
                      ?>
                          <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,8&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                      <?php
                        }else{
                      ?>
                          <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,8&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                          <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                      <?php
                        }
                      }
                    ?>
                  </td>
                  <td class="draw_td none"></td>
                  <td class="draw_td right"></td>
                  <td class="draw_td right"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                </tr>

                <tr>
                  <td class="draw_td right"></td>
                  <td class="draw_td right">
                    <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                      foreach ($matches as $match) {
                        if($match->getRound() == "roundof16" && $match->getCell() == "1,9" && $match->getId_draw() == $draw){
                          $id_match = $match->getId_match();
                          foreach ($competitors as $competitor) {
                            if($competitor->getId_user() == $match->getRival1a()){
                              $name1a = $competitor->getName();
                              $surname1a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival1b()){
                              $name1b = $competitor->getName();
                              $surname1b = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2a()){
                              $name2a = $competitor->getName();
                              $surname2a = $competitor->getSurname();
                            }
                            if($competitor->getId_user() == $match->getRival2b()){
                              $name2b = $competitor->getName();
                              $surname2b = $competitor->getSurname();
                            }
                          }
                          ?>
                                <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                                <br/>
                                <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                                <br/>
                              <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,9&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                          <?php
                                $flag = true;
                              }
                            }
                            if($_SESSION["admin"]) {
                              if(!$flag){
                            ?>
                                <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,9&amp;round=roundof16"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                            <?php
                              }else{
                            ?>
                                <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,9&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                                <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                            <?php
                              }
                            }
                          ?>
                  </td>
                  <td class="draw_td right"></td>
                  <td class="draw_td right"></td>
                  <td class="draw_td none"></td>
                  <td class="draw_td none"></td>
                </tr>

              <tr>
                <td class="draw_td right">
                  <?php
                  $flag = false;
                  $id_match = NULL;
                  $name1a = NULL;
                  $surname1a = NULL;
                  $name1b = NULL;
                  $surname1b = NULL;
                  $name2a = NULL;
                  $surname2a = NULL;
                  $name2b = NULL;
                  $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof32" && $match->getCell() == "0,10" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,10&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,10&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,10&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td right"></td>
                <td class="draw_td right"></td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td none"></td>
                <td class="draw_td right"></td>
                <td class="draw_td right">
                  <?php
                  $flag = false;
                  $id_match = NULL;
                  $name1a = NULL;
                  $surname1a = NULL;
                  $name1b = NULL;
                  $surname1b = NULL;
                  $name2a = NULL;
                  $surname2a = NULL;
                  $name2b = NULL;
                  $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "cuarterfinal" && $match->getCell() == "2,11" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=2,11&amp;round=cuarterfinal&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=2,11&amp;round=cuarterfinal"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=2,11&amp;round=cuarterfinal&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td right">
                  <?php
                  $flag = false;
                  $id_match = NULL;
                  $name1a = NULL;
                  $surname1a = NULL;
                  $name1b = NULL;
                  $surname1b = NULL;
                  $name2a = NULL;
                  $surname2a = NULL;
                  $name2b = NULL;
                  $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof32" && $match->getCell() == "0,12" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,12&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,12&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,12&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td right"></td>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof16" && $match->getCell() == "1,13" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,13&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,13&amp;round=roundof16"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,13&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td none"></td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof32" && $match->getCell() == "0,14" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,14&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,14&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,14&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td right"></td>
                <td class="draw_td none gold">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "final" && $match->getCell() == "4,15" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=4,15&amp;round=final&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=4,15&amp;round=final"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=4,15&amp;round=final&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td none champion">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "champion" && $match->getCell() == "5,15" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=5,15&amp;round=champion&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=5,15&amp;round=champion"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=5,15&amp;round=champion&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
              </tr>

              <tr>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof32" && $match->getCell() == "0,16" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,16&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,16&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,16&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td right"></td>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof16" && $match->getCell() == "1,17" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,17&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,17&amp;round=roundof16"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,17&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td none"></td>
                <td class="draw_td right"></td>
                <td class="draw_td none silver">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "consolation" && $match->getCell() == "4,17" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=4,17&amp;round=consolation&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=4,17&amp;round=consolation"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=4,17&amp;round=consolation&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td none third">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "thirdplace" && $match->getCell() == "5,17" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=5,17&amp;round=thirdplace&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=5,17&amp;round=thirdplace"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=5,17&amp;round=thirdplace&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
              </tr>

              <tr>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof32" && $match->getCell() == "0,18" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,18&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,18&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,18&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td none"></td>
                <td class="draw_td right"></td>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "cuarterfinal" && $match->getCell() == "2,19" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=2,19&amp;round=cuarterfinal&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=2,19&amp;round=cuarterfinal"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=2,19&amp;round=cuarterfinal&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof32" && $match->getCell() == "0,20" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,20&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,20&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,20&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td right"></td>
                <td class="draw_td right"></td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td right"></td>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof16" && $match->getCell() == "1,21" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,21&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,21&amp;round=roundof16"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,21&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td right"></td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof32" && $match->getCell() == "0,22" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,22&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,22&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,22&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td none"></td>
                <td class="draw_td right"></td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td right"></td>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "semifinal" && $match->getCell() == "3,23" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=3,23&amp;round=semifinal&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=3,23&amp;round=semifinal"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=3,23&amp;round=semifinal&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof32" && $match->getCell() == "0,24" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,24&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,24&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,24&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td none"></td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td right"></td>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof16" && $match->getCell() == "1,25" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,25&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,25&amp;round=roundof16"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,25&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof32" && $match->getCell() == "0,26" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,26&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,26&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,26&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td right"></td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td none"></td>
                <td class="draw_td right"></td>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "cuarterfinal" && $match->getCell() == "2,27" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=2,27&amp;round=cuarterfinal&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=2,27&amp;round=cuarterfinal"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=2,27&amp;round=cuarterfinal&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof32" && $match->getCell() == "0,28" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,28&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,28&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,28&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td right"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td right"></td>
                <td class="draw_td right">
                  <?php
                    $flag = false;
                    $id_match = NULL;
                    $name1a = NULL;
                    $surname1a = NULL;
                    $name1b = NULL;
                    $surname1b = NULL;
                    $name2a = NULL;
                    $surname2a = NULL;
                    $name2b = NULL;
                    $surname2b = NULL;
                    foreach ($matches as $match) {
                      if($match->getRound() == "roundof16" && $match->getCell() == "1,29" && $match->getId_draw() == $draw){
                        $id_match = $match->getId_match();
                        foreach ($competitors as $competitor) {
                          if($competitor->getId_user() == $match->getRival1a()){
                            $name1a = $competitor->getName();
                            $surname1a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival1b()){
                            $name1b = $competitor->getName();
                            $surname1b = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2a()){
                            $name2a = $competitor->getName();
                            $surname2a = $competitor->getSurname();
                          }
                          if($competitor->getId_user() == $match->getRival2b()){
                            $name2b = $competitor->getName();
                            $surname2b = $competitor->getSurname();
                          }
                        }
                        ?>
                              <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                              <br/>
                              <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                              <br/>
                            <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,29&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                        <?php
                              $flag = true;
                            }
                          }
                          if($_SESSION["admin"]) {
                            if(!$flag){
                          ?>
                              <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,29&amp;round=roundof16"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                          <?php
                            }else{
                          ?>
                              <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=1,29&amp;round=roundof16&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                              <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                          <?php
                            }
                          }
                        ?>
                </td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              <tr>
                <td class="draw_td right">
                  <?php
                  $flag = false;
                  $id_match = NULL;

                  foreach ($matches as $match) {
                    if($match->getRound() == "roundof32" && $match->getCell() == "0,30" && $match->getId_draw() == $draw){
                      $id_match = $match->getId_match();
                      foreach ($competitors as $competitor) {
                        if($competitor->getId_user() == $match->getRival1a()){
                          $name1a = $competitor->getName();
                          $surname1a = $competitor->getSurname();
                        }
                        if($competitor->getId_user() == $match->getRival1b()){
                          $name1b = $competitor->getName();
                          $surname1b = $competitor->getSurname();
                        }
                        if($competitor->getId_user() == $match->getRival2a()){
                          $name2a = $competitor->getName();
                          $surname2a = $competitor->getSurname();
                        }
                        if($competitor->getId_user() == $match->getRival2b()){
                          $name2b = $competitor->getName();
                          $surname2b = $competitor->getSurname();
                        }
                      }
                      ?>
                            <?= $name1a ?>  <?= $surname1a ?> <?php if($name1b != NULL){ ?> - <?= $name1b ?>  <?= $surname1b ?> <?php } ?>
                            <br/>
                            <?= $name2a ?> <?= $surname2a ?> <?php if($name2b != NULL){ ?> - <?= $name2b ?> <?= $surname2b ?> <?php } ?>
                            <br/>
                          <a href="index.php?controller=matches&amp;action=view&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,30&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-eye" title="<?=i18n("View")?>"></span></a>
                      <?php
                            $flag = true;
                          }
                        }
                        if($_SESSION["admin"]) {
                          if(!$flag){
                        ?>
                            <a href="index.php?controller=matches&amp;action=add&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,30&amp;round=roundof32"><span class="oi oi-plus match" title="<?=i18n("Add")?>"></span></a>
                        <?php
                          }else{
                        ?>
                            <a href="index.php?controller=matches&amp;action=update&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;cell=0,30&amp;round=roundof32&amp;id_match=<?= $id_match ?>"><span class="oi oi-pencil" title="<?=i18n("Modificar")?>"></span></a>
                            <a href="index.php?controller=matches&amp;action=delete&amp;id_tournament=<?= $tournament ?>&amp;id_draw=<?= $draw ?>&amp;id_match=<?= $id_match ?>"><span class="oi oi-trash" title="<?=i18n("Delete")?>"></span></a>
                        <?php
                          }
                        }
                      ?>
                </td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
                <td class="draw_td none"></td>
              </tr>

              </tbody>
            </table>
        </div>
    </div>
</div>
