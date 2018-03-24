<?php
// file: view/courses/show.php
require_once (__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$courses = $view->getVariable("courses");
$view->setVariable ("title", "Show Courses");
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php"><?= i18n("Home") ?></a></li>
  <li class="breadcrumb-item active"><?= i18n("Courses List") ?></li>
</ol>

<?php $alert = "" ?>
<?php if($alert =($view->popFlash())){ ?>
    <div class="alert alert-success" role="alert">
      <?= $alert ?>
    </div>
<?php } ?>

<div id="container" class="container">
  <div id="background_title">
    <h4 id="view_title"><?= i18n("Courses List") ?></h4><a href="index.php?controller=courses&amp;action=add"> <span class="oi oi-plus"></span></a>
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
                  <th><?=i18n("Type")?></th>
                  <th><?=i18n("Capacity")?></th>
                  <th><?=i18n("Days")?></th>
                  <th><?=i18n("Start Time")?></th>
                  <th><?=i18n("End Time")?></th>
                  <th><?=i18n("Operations")?></th>
                </tr>
              </thead>
              <tbody>
                <?php $n=1; foreach ($courses as $course): ?>

        						<tr>
                      <td><?= $n++ ?></td>
        							<td><?= $course->getName() ?></td>
        							<td><?= $course->getType() ?></td>
        							<td><?= $course->getCapacity() ?></td>
                      <td>
                        <?php
                          $arrayDays = explode(',' , $course->getDays());
                          $stringDays="";
                          for($i=0; $i<count($arrayDays); $i++){
                            $stringDays = $stringDays.i18n($arrayDays[$i]).", ";
                          }
                          $size = strlen($stringDays);
                          $stringDays = substr($stringDays, 0, $size-2);
                         ?>
                        <?=$stringDays?>
                      </td>
        							<td><?= $course->getStart_time() ?></td>
                      <td><?= $course->getEnd_time() ?></td>
                      <td>
                        <a href="index.php?controller=courses&amp;action=view&amp;id_course=<?= $course->getId_course() ?>"><span class="oi oi-magnifying-glass"></span></a>
                        <a href="index.php?controller=courses&amp;action=update&amp;id_course=<?= $course->getId_course() ?>"><span class="oi oi-loop"></span></a>
                        <a href="index.php?controller=courses&amp;action=delete&amp;id_course=<?= $course->getId_course() ?>"><span class="oi oi-trash"></span></a>
                      </td>
        						</tr>
        				<?php endforeach; ?>

              </tbody>
            </table>
        </div>
    </div>

  </div>
</div>
