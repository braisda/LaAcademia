<?php
// file: view/courseReservations/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$reservations = $view->getVariable("eventReservation");
$assistants = $view->getVariable("assistants");
$events = $view->getVariable("events");
$view->setVariable ("title", i18n("Events Reservations List"));
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Events Reservations List") ?></li>
</ol>

<?php $alert = "" ?>
<?php if($alert =($view->popFlash())){ ?>
    <div class="alert alert-success" role="alert">
      <?= $alert ?>
    </div>
<?php } ?>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Events Reservations List") ?></h4><a href="index.php?controller=eventReservations&amp;action=search"> <span id="search_icon" class="oi oi-magnifying-glass" title="<?= i18n("Search") ?>"></a>
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
                  <th><?=i18n("Assistant")?></th>
                  <th><?=i18n("Event")?></th>
                  <th><?=i18n("Operations")?></th>
                </tr>
              </thead>
              <tbody>
                <?php $n=1; foreach ($reservations as $reservation): ?>
        						<tr>
                      <td><?= $n++ ?></td>
        							<td><?= date("d-m-Y", strtotime($reservation->getDateReservation())) ?></td>
        							<td><?= $reservation->getTimeReservation() ?></td>
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
                          foreach ($assistants as $assistant) {
                            if($assistant["id_user"] == $reservation->getId_assistant()){
                              $name = $assistant["name"];
                              $surname = $assistant["surname"];
                            }
                          }
                        ?>

                        <?= $name." ".$surname ?></td>
                      <td>
                        <?php
                          foreach ($events as $event) {
                            if($event["id_event"] == $reservation->getId_event()){
                              $name = $event["name"];
                            }
                          }
                        ?>

                        <?= $name?></td>
                      <td>
                        <a href="index.php?controller=eventReservations&amp;action=view&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-eye" title="<?= i18n("View") ?>"></span></a>

                        <?php
                          if($reservation->getIs_confirmed() == 0){
                            if($_SESSION["admin"]){
                        ?>
                          <a href="index.php?controller=eventReservations&amp;action=delete&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-trash" title="<?= i18n("Delete") ?>"></span></a>
                          <a href="index.php?controller=eventReservations&amp;action=confirm&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-circle-check" title="<?= i18n("Confirm") ?>"></span></a>
                        <?php
                            }else{
                        ?>
                              <a href="index.php?controller=eventReservations&amp;action=delete&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-trash" title="<?= i18n("Delete") ?>"></span></a>
                        <?php
                            }
                          }else{
                            if($_SESSION["admin"]){
                        ?>
                          <a href="index.php?controller=eventReservations&amp;action=delete&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-trash" title="<?= i18n("Delete") ?>"></span></a>
                          <a href="index.php?controller=eventReservations&amp;action=cancel&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-circle-x" title="<?= i18n("Cancel") ?>"></span></a>
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
