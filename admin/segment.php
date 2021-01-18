<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2019 osCommerce

  Released under the GNU General Public License
 */

require('includes/application_top.php');


//if(\Ease\WebPage::isFormPosted()){
//    tep_redirect('hall.php?add_segment='.\Ease\WebPage::getRequestValue('segment_code'));
//}


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


        $("#segrows").change(function () {
            $("#segmentcode").val($("#segname").val() + "|" + $("#segrows").val() + "x" + $("#rowchairs").val());
            this.form.submit();
        });
        $("#rowchairs").change(function () {
            $("#segmentcode").val($("#segname").val() + "|" + $("#segrows").val() + "x" + $("#rowchairs").val());
            this.form.submit();
        });

        $("#segname").change(function () {
           $("#segmentcode").val($("#segname").val() + "|" + $("#segrows").val() + "x" + $("#rowchairs").val());
           $("#usenow").attr("href","hall.php?add_segment=" + $("#segmentcode").val()); 
        });

        
    });
</script>


<div class="row">
    <div class="col">
        <h1 class="display-4"><?php echo 'Segment Editor'; ?></h1>
    </div>
</div>

<div class="row">
    <?php
    echo new \Ease\TWB4\Container(new PureOSC\ui\HallSegmentEditor());
    ?>
</div>

<?php
require('includes/template_bottom.php');
require('includes/application_bottom.php');
?>
