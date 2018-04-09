<?php
// file: view/courseReservations/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$reservations = $view->getVariable("courseReservation");
$pupils = $view->getVariable("pupils");
$courses = $view->getVariable("courses");
$view->setVariable ("title", "Show Courses Reservations");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Courses Reservations List") ?></li>
</ol>

<?php $alert = "" ?>
<?php if($alert =($view->popFlash())){ ?>
    <div class="alert alert-success" role="alert">
      <?= $alert ?>
    </div>
<?php } ?>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Courses Reservations List") ?></h4>
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
                  <th><?=i18n("Pupil")?></th>
                  <th><?=i18n("Course")?></th>
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
                          foreach ($pupils as $pupil) {
                            if($pupil["id_user"] == $reservation->getId_pupil()){
                              $name = $pupil["name"];
                              $surname = $pupil["surname"];
                            }
                          }
                        ?>

                        <?= $name." ".$surname ?></td>
                      <td>
                        <?php
                          foreach ($courses as $course) {
                            if($course["id_course"] == $reservation->getId_course()){
                              $name = $course["name"];
                              $type = $course["type"];
                            }
                          }
                        ?>

                        <?= $name." ".i18n($type) ?></td>
                      <td>
                        <a href="index.php?controller=courseReservations&amp;action=view&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-magnifying-glass"></span></a>
                        <a href="index.php?controller=courseReservations&amp;action=delete&amp;id_reservation=<?= $reservation->getId_reservation() ?>"><span class="oi oi-trash"></span></a>
                      </td>
        						</tr>
        				<?php endforeach; ?>

              </tbody>
            </table>
        </div>
    </div>

  </div>
</div>
