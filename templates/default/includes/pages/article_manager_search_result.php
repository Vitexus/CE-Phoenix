<?php
  $breadcrumb->add(NAVBAR_TITLE, tep_href_link('article_manager_search_result.php'));

  require $oscTemplate->map_to_template('template_top.php', 'component');
?>

<div class="page-header">
  <h1><?php echo HEADING_TITLE; ?></h1>
</div>

<div class="contentContainer">
    
   <?php include('includes/modules/article_manager/article_listing.php'); ?>        

  <div class="buttonSet">
    <div class="text-right"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'far fa-hand-point-right', tep_href_link('index.php')); ?></div>
  </div>
</div>
<?php
  require $oscTemplate->map_to_template('template_bottom.php', 'component');
?>
