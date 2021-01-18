<?php
  $breadcrumb->add(NAVBAR_TITLE_DEFAULT, tep_href_link('article-topics.php'));

  require $oscTemplate->map_to_template('template_top.php', 'component');
  
?>
<h1 class="display-4"><?php echo HEADING_TITLE; ?></h1>

<div class="row">
  <div class="col">
    <?php echo TEXT_NEW_ARTICLES; ?>
  </div>
</div>

<?php include('includes/modules/article_manager/article_listing.php'); ?>  

<div class="row">
 <div class="col buttonSet">
   <div class="text-right"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'far fa-hand-point-right', tep_href_link('index.php')); ?></div>
 </div>
</div>
 
 <?php
  require $oscTemplate->map_to_template('template_bottom.php', 'component');
 
