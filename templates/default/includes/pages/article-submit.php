<?php
  $breadcrumb->add(NAVBAR_TITLE_DEFAULT, tep_href_link('article-submit.php'));

  require $oscTemplate->map_to_template('template_top.php', 'component');
  
?>

<div class="page-header">
  <h1 class="h3"><?php echo HEADING_ARTICLE_SUBMIT; ?></h1>
</div>

<div class="contentContainer">
  <div class="contentText">

<?php if ($wasSubmitted == true) { ?>
    <div class="pageHeading"><?php echo TEXT_ARTICLE_SUBMITTED; ?></div>
    
    <div class="buttonSet">
      <div class="text-right"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'far fa-hand-point-right', tep_href_link('index.php')); ?></div>
    </div>    
<?php } else { ?>
    <div <class="main" style="padding-bottom:20px;"><?php echo TEXT_ARTICLE_SUBMIT; ?></div>
<?php
  if ($messageStack->size('article_submit') > 0) {
?>
     <div><?php echo $messageStack->output('article_submit'); ?></div>
<?php
  }
?>
     <?php echo tep_draw_form('article_submit', tep_href_link('article-submit.php', '', $request_type), 'post', 'enctype="multipart/form-data" onSubmit="return true;" onReset="return true"') . tep_draw_hidden_field('action', 'process'); ?>
     <div class="textSmall" align="left" width="90"><?php echo TEXT_AUTHORS_NAME; ?></div>
     <div class="textSmall articlePaddingSubmit"><?php echo tep_draw_input_field('authors_name', $authorInfo['authors_name'], 'maxlength="60" size="40"', false); ?> </div>
     
     <div class="textSmall" align="left" width="90"><?php echo TEXT_AUTHORS_IMAGE; ?></div>
     <div class="textSmall articlePaddingSubmit"><input type="hidden" name="authors_image_size" value="100000"><input name="authors_image" type="file"></div>
     <div class="textSmall" align="left" width="110" valign="top"><?php echo TEXT_AUTHORS_INFO; ?></div>
     <div class="textSmall articlePaddingSubmit"><?php echo tep_draw_textarea_field('authors_description', 'soft', '5', '2', $authorInfo['authors_description'], '', false); ?></div>

     <div class="textSmall" align="left" width="110"><?php echo TEXT_ARTICLE_NAME; ?></div>
     <div class="textSmall articlePaddingSubmit"><?php echo tep_draw_input_field('article_name', $article['name'], 'maxlength="60" size="40"', false); ?> </div>
     <div class="textSmall" align="left"><?php echo TEXT_SHORT_DESCRIPTION; ?></div>
     <div class="textSmall articlePaddingSubmit"><?php echo tep_draw_input_field('article_short_desc', $article['meta_desc'], 'maxlength="60" size="40"', false); ?></div>
     
     <div class="textSmall" align="left"><?php echo TEXT_ARTICLE_PLACEMENT; ?></div>
     <div class="textSmall articlePaddingSubmit"><?php echo tep_draw_pull_down_menu('topics_list', $topicsList); ?></div>
     
     <div class="textSmall" align="left"><?php echo TEXT_ARTICLE_UPLOAD_IMAGE; ?></div>
     <div class="textSmall articlePaddingSubmit"><input type="hidden" name="MAX_FILE_SIZE" value="100000"><input name="uploadedfile" type="file"></div>
     
     <div class="textSmall" align="left"><?php echo TEXT_ARTICLE_TEXT; ?></div>
     <div class="textSmall"><?php echo tep_draw_textarea_field('article_long_desc', 'soft', '40', '15', $article['text'], '', false); ?></div>
     
     <div class="buttonSet">
        <div align="right"><?php echo tep_draw_button(IMAGE_BUTTON_SUBMIT, 'far fa-hand-point-right', null, null, array('type' => 'submit')); ?></div>
     </div>
     </form>
     <?php } //end of wasSubmitted ?>
  </div>
</div>

 <?php
  require $oscTemplate->map_to_template('template_bottom.php', 'component');
?>
