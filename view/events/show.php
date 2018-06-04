<?php
// file: view/events/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$events = $view->getVariable("events");
$view->setVariable ("title", i18n("Events List"));
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Events List") ?></li>
</ol>

<?php $alert = "" ?>
<?php if($alert =($view->popFlash())){ ?>
    <div class="alert alert-success" role="alert">
      <?= $alert ?>
    </div>
<?php } ?>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Events List") ?></h4>
    <a href="index.php?controller=events&amp;action=search">
      <span id="search_icon" class="oi oi-magnifying-glass" title="<?= i18n("Search") ?>">
    </a>
    <?php
      if($_SESSION["admin"]){
    ?>
    <a href="index.php?controller=events&amp;action=add">
      <span class="oi oi-plus" title="<?= i18n("Add") ?>"></span>
    </a>
    <?php
      }
    ?>
  </div>
  <div class="row justify-content-around">

    <div id="background_table" class="col-12">
      <div class="table-responsive">
        <br/>
            <table id="table_color" class="table table-sm table-dark">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th><?=i18n("Name")?></th>
                  <th><?=i18n("Capacity")?></th>
                  <th><?=i18n("Date")?></th>
                  <th><?=i18n("Time")?></th>
                  <th><?=i18n("Operations")?></th>
                </tr>
              </thead>
              <tbody>
                <?php $n=1; foreach ($events as $event): ?>

        						<tr>
                      <td><?= $n++ ?></td>
        							<td><?= $event->getName() ?></td>
        							<td><?= $event->getCapacity() ?></td>
                      <td><?= date("d-m-Y", strtotime($event->getDate())); ?></td>
        							<td><?= $event->getTime() ?></td>
                      <td>
                        <a href="index.php?controller=events&amp;action=view&amp;id_event=<?= $event->getId_event() ?>"><span class="oi oi-zoom-in" title="<?= i18n("View") ?>"></span></a>
                        <?php
                          if($_SESSION["admin"]){
                        ?>
                          <a href="index.php?controller=events&amp;action=update&amp;id_event=<?= $event->getId_event() ?>"><span class="oi oi-loop" title="<?= i18n("Update") ?>"></span></a>
                          <a href="index.php?controller=events&amp;action=delete&amp;id_event=<?= $event->getId_event() ?>"><span class="oi oi-trash" title="<?= i18n("Delete") ?>"></span></a>
                          <?php
                            }
                            if($_SESSION["pupil"] || $_SESSION["competitor"]){
                          ?>
                            <a href="index.php?controller=eventReservations&amp;action=add&amp;id_event=<?= $event->getId_event() ?>"><span class="oi oi-task" title="<?= i18n("Reserve") ?>"></span></span></a>
                          <?php
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
