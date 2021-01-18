<?php

use Ease\TWB4\Container;
use Ease\WebPage;
use PureOSC\Hall;
use PureOSC\ui\HallEditor;

/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2019 osCommerce

  Released under the GNU General Public License
 */

require('includes/application_top.php');

$hallId = WebPage::getRequestValue('id', 'int');

if (WebPage::isFormPosted() === false) {
    if (is_null($hallId) && isset($_SESSION['current_hall'])) {
        $hallId = intval($_SESSION['current_hall']);
    }
}



$haller = new Hall($hallId, ['autoload' => true]);
$addSegment = WebPage::getRequestValue('add_segment');
$delSegment = WebPage::getRequestValue('del_segment');

if ($addSegment) {
    if ($haller->addSegment($addSegment)) {
        tep_redirect('hall.php?id=' . $hallId);
        exit();
    }
}
if ($delSegment) {
    $haller->delSegment($delSegment);
}

$hallName = WebPage::getRequestValue('hall_name');

if (WebPage::isFormPosted()) {
    $haller->dbsync(['name' => WebPage::getRequestValue('hall_name'), 'capacity' => WebPage::getRequestValue('hall_capacity')]);
    $_SESSION['current_hall'] = $haller->getMyKey();
} else {


    $hallId = array_key_exists('current_hall', $_SESSION) ? $_SESSION['current_hall'] : null;
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
        <h1 class="display-4"><a href="halls.php"><?php echo MODULES_ADMIN_MENU_CATALOG_HALLS; ?></a></h1>
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
    $editor = new HallEditor($haller);

    $editor->finalize();
 
    echo new Container($editor);
    ?>
</div>

<?php
require('includes/template_bottom.php');
require('includes/application_bottom.php');

