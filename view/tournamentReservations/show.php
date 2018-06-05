<?php
// file: view/tournamentReservations/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$reservations = $view->getVariable("tournamentReservation");
$competitors = $view->getVariable("competitors");
$tournaments = $view->getVariable("tournaments");
$view->setVariable ("title", "Show Tournaments Reservations");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Tournaments Reservations List") ?></li>
</ol>

<?php $alert = "" ?>
<?php if($alert =($view->popFlash())){ ?>
    <div class="alert alert-success" role="alert">
      <?= $alert ?>
    </div>
<?php } ?>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Tournaments Reservations List") ?></h4><a href="index.php?controller=tournamentReservations&amp;action=search"> <span id="search_icon" class="oi oi-magnifying-glass"></a>
  </div>
  <div class="row justify-content-around">

    <div id="background_table" class="col-12">
      <div class="table-responsive">
        <br/>
            <table id="table_color" class="table table-sm table-dark">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th><?=i18n("Date")?></th>
                  <th><?=i18n("Time")?></th>
                  <th><?=i18n("State")?></th>
                  <th><?=i18n("Competitor")?></th>
                  <th><?=i18n("Tournament")?></th>
                  <th><?=i18n("Operations")?></th>
                </tr>
              </thead>
              <tbody>
                <?php $n=1; foreach ($reservations as $reservation): ?>
        						<tr>
                      <td><?= $n++ ?></td>
        							<td><?= $reservation->getDate() ?></td>
        							<td><?= $reservation->getTime() ?></td>
        							<td>
                        <?php
                          if($reservation->getIs_confirmed() == 1){
                            $toret = "Confirmed";
                          }else{
                            $toret = "Pendient";
                          }
                        ?>

                        <?= i18n($toret) ?></td>
        							<td>
                        <?php
                          foreach ($competitors as $competitor) {
                            if($competitor["id_user"] == $reservation->getId_competitor()){
                              $name = $competitor["name"];
                              $surname = $competitor["surname"];
                            }
                          }
                        ?>

                        <?= $name." ".$surname ?></td>
                      <td>
                        <?php
                          foreach ($tournaments as $tournament) {
                            if($tournament["id_tournament"] == $reservation->getId_tournament()){
                              $name = $tournament["name"];
                            }
                          }
                        ?>

                        <?= $name ?></td>
                        <td>
                          <a href="index.php?controller=tournamentReservations&amp;action=view&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-eye"></span></a>

                          <?php
                            if($reservation->getIs_confirmed() == 0){
                              if($_SESSION["admin"]){
                          ?>
                            <a href="index.php?controller=tournamentReservations&amp;action=delete&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-trash"></span></a>
                            <a href="index.php?controller=tournamentReservations&amp;action=confirm&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-circle-check"></span></a>
                          <?php
                              }else{
                          ?>
                                <a href="index.php?controller=tournamentReservations&amp;action=delete&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-trash"></span></a>
                          <?php
                              }
                            }else{
                              if($_SESSION["admin"]){
                          ?>
                            <a href="index.php?controller=tournamentReservations&amp;action=delete&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-trash"></span></a>
                            <a href="index.php?controller=tournamentReservations&amp;action=cancel&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-circle-x"></span></a>
                          <?php
                              }
                            }
                          ?>
                        </td>
          						</tr>
          				<?php endforeach; ?>

              </tbody>
            </table>
        </div>
    </div>

  </div>
</div>
