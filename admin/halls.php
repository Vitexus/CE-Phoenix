<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2019 osCommerce

  Released under the GNU General Public License
 */

require('includes/application_top.php');

$hallName = \Ease\WebPage::getRequestValue('hall_name');
$hallId = \Ease\WebPage::getRequestValue('id', 'int');

if (\Ease\WebPage::isFormPosted()) {

    $engine = new PureOSC\Hall(['name' => $hallName, 'capacity' => \Ease\WebPage::getRequestValue('hall_capacity')]);
    $engine->dbsync();
    $_SESSION['current_hall'] = $engine->getMyKey();

    tep_redirect('hall.php?id=' . $engine->getMyKey());
    exit;
} else {
    $engine = new PureOSC\Hall(is_null($hallId) ? (array_key_exists('current_hall', $_SESSION) ? $_SESSION['current_hall'] : null ) : $hallId);

    $delId = \Ease\WebPage::getRequestValue('del_hall', 'int');
    if ($delId) {
        $engine->deleteFromSQL($delId);
    }
}


$languages = tep_get_languages();
$languages_array = [];
$languages_selected = DEFAULT_LANGUAGE;
for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
    $languages_array[] = ['id' => $languages[$i]['code'], 'text' => $languages[$i]['name']];
    if ($languages[$i]['directory'] == $language) {
        $languages_selected = $languages[$i]['code'];
    }
}

require('includes/template_top.php');
?>
<style>
    .chair_place {
        width: 30px;
        height: 30px;
    }

    .rownumber { font-size: 10px; width: 20px; display: inline-block}

</style>

<script>
    $(document).ready(function () {
    });
</script>


<div class="row">
    <div class="col">
        <h1 class="display-4"><?php echo MODULES_ADMIN_MENU_CATALOG_HALLS; ?></h1>
    </div>
    <?php
    if (sizeof($languages_array) > 1) {
        ?>
        <div class="col-sm-4 text-right"><?php echo tep_draw_form('adminlanguage', 'index.php', '', 'get') . tep_draw_pull_down_menu('language', $languages_array, $languages_selected, 'onchange="this.form.submit();"') . tep_hide_session_id() . '</form>'; ?></div>
        <?php
    }
    ?>
</div>

<div class="row">
    <?php
    $editor = new PureOSC\ui\HallsEditor($engine);

//    $editor->delHall(\Ease\WebPage::getRequestValue('del_hall'));
    //  $editor->addHall(\Ease\WebPage::getRequestValue('add_hall'));
    $editor->finalize();

    $hallRow = new Ease\TWB4\Row();
    $hallRow->addColumn(8, $editor);
    $hallRow->addColumn(4, ['<h2>New Hall</h2>', strval(new PureOSC\ui\HallForm())]);

    echo new \Ease\TWB4\Container($hallRow);
    ?>
</div>

<?php
require('includes/template_bottom.php');
require('includes/application_bottom.php');
?>
