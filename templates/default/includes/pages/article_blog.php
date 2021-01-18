<?php

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link('articles_blog.php'));

  require $oscTemplate->map_to_template('template_top.php', 'component');


  if ($article_check['total'] < 1) { ?>
      <div class="page-header" ><?php echo HEADING_ARTICLE_NOT_FOUND; ?></div>
      <div class="main" ><?php echo TEXT_ARTICLE_NOT_FOUND; ?></div>

<?php
  } else {
    $article_info_query = tep_db_query("select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_image, ad.articles_url, ad.articles_viewed, au.authors_name, au.authors_image from articles a left join authors au using(authors_id), articles_description ad where a.articles_status = '1' and a.articles_id = '" . (int)$_GET['articles_id'] . "' and ad.articles_id = a.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "'");
    $article_info = tep_db_fetch_array($article_info_query);

    tep_db_query("update articles_description set articles_viewed = articles_viewed+1 where articles_id = '" . (int)$_GET['articles_id'] . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'");

    $articles_name = $article_info['articles_name'];
    $articles_author_id = $article_info['authors_id'];
    $articles_author = $article_info['authors_name'];
?>
    
    <div class="row">
      <div class="col">
        <h1 class="display-4"><?php echo $articles_name; ?></h1>
      </div>
      <?php 
      if (tep_not_null($article_info['articles_image']) && file_exists('images/article_manager_uploads/'.$article_info['articles_image'])) { ?>
        <div class="col text-right"><?php echo tep_image('images/article_manager_uploads/'.$article_info['articles_image'], $article_info['articles_name'], ARTICLES_IMAGE_WIDTH, ARTICLES_IMAGE_HEIGHT); 
        ?>       
        </div>
      <?php } ?>
    </div>         
    
    <?php
      if ($messageStack->size('article-message-display') > 0) {
        echo $messageStack->output('article-message-display');
      }
    ?>  

    <div class="row">
      <div class="col">      
        <?php
        if (REQUIRE_ARTICLE_BLOG_POST_APPROVAL == 'true' && tep_not_null($submitted_msg)) {
            echo '<div class="blog-submission-msg">' , $submitted_msg , '</div>';
        } 
        ?>
      </div>
    </div>
    
    <div class="row">
      <div class="col">
         <div>
         <span class="smallText">   
           <?php
           if (tep_not_null($articles_author) && DISPLAY_AUTHOR_ARTICLE_LISTING == 'true') {
              $authorsImage = 'images/article_manager_uploads/' . $article_info['authors_image'];
              if (file_exists($authorsImage) && is_file($authorsImage)) {
                  echo '<a>' . tep_image($authorsImage, HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT) . '</a>';
              } else {
                  echo TEXT_BY_AM . '<a>' . $articles_author . '</a>';
              }
           }
           ?>   
         </span>            
         <span><?php if ($article_info['articles_viewed']) echo sprintf(ARTICLE_VIEWED_COUNT, $article_info['articles_viewed']); ?></span>
        </div>

      </div>
    </div>
    
    <?php
     if (DISPLAY_DATE_ADDED_ARTICLE_LISTING == 'true') {
          echo '<div class="row mb-2">';
          if ($article_info['articles_date_available'] > date('Y-m-d H:i:s')) { ?>
            <div class="col articlePadding"><?php echo sprintf(TEXT_DATE_AVAILABLE, tep_date_long($article_info['articles_date_available'])); ?></div>
          <?php
          } else { ?>
            <div class="col articlePadding"><?php echo sprintf(TEXT_DATE_ADDED, tep_date_long($article_info['articles_date_added'])); ?></div>
      <?php
          }
          echo '</div>';
      }    
    ?>
    
    <div class="row article-listing mb-2">
      <div class="col">
        <?php echo stripslashes($article_info['articles_description']); ?>
      </div>

      <?php 
      if (tep_not_null($article_info['articles_url'])) { ?>
        <div class="col articlePadding"><?php echo sprintf(TEXT_MORE_INFORMATION, "https://" . urlencode($article_info['articles_url']) ); ?></div>
      <?php
      }
      ?> 
    </div>
    
    <!-- BEGIN SHOWING THE COMMENTS //-->
    <?php $comments_query = tep_db_query("SELECT * from articles_blog where articles_id = " . (int)$_GET['articles_id'] . " and comments_status = 1 and language_id = " . (int)$_SESSION['languages_id']);
    if (tep_db_num_rows($comments_query)) {
    ?> 
    <div claas="row">
      <div class="col"><?php echo TEXT_COMMENT; ?></div>
      <div class="col">
        <?php 
        while($comments = tep_db_fetch_array($comments_query)) {
        ?>
          <div class="article-comment-container">
            <div class="articlePadding pb-2"><i class="fas fa-asterisk"></i>
             <span class="smallText articleBlogEntry"><?php echo sprintf(TEXT_WHO_SAID, $comments['commenters_name'], date ("F d, Y \a\\t h:i A", strtotime($comments['comment_date_added']))); ?></span>
            </div>
            <div class="smallText articlePadding"><?php echo $comments['comment']; ?></div>
          </div>
        <?php } ?>
      </div>
    </div>  
    <?php } ?>
    <!-- END SHOWING THE COMMENTS //-->
        
    <!-- BEGIN POST A COMMENT SECTION //-->
    <?php echo tep_draw_form('article_new_comment', tep_href_link('article_blog.php', tep_get_all_get_params()), 'post') . tep_hide_session_id() . tep_draw_hidden_field('action', 'process_comment'); ?>
    <div class="row">
      <div class="col">
          <div class="smallText"><?php echo TEXT_POST_A_COMMENT; ?></div>
          <div class="smallText textareacontainer"><?php echo tep_draw_textarea_field('blog_comment', 'soft', 800, 5, '', '', false); ?></div>
          
          <div class="smallText">
          <?php 
          if (($row_cnt = tep_db_num_rows($comments_query))) {
              echo $row_cnt . ' ' . ($row_cnt > 1 ? TEXT_TOTAL_COMMENTS : TEXT_TOTAL_COMMENT); 
          } else {
              echo TEXT_TOTAL_COMMENTS_BE_FIRST;
          }
          ?>
          </div>
          
          <div class="smallText" align="right"><?php echo tep_draw_hidden_field('article_name', $articles_name) . 
          tep_draw_button(IMAGE_BUTTON_SUBMIT, 'fa fa-user', null, 'primary', null, 'btn btn-success'); ?>
          </div>
      </div>
    </div>
    </form>
    <!-- END POST A COMMENT SECTION //-->
      
    <div class="row">  
      <div class="col articlePadding">
      <?php
      //added for cross-sell
      include('includes/modules/article_manager/articles_xsell.php');
      ?>
      </div>
    </div>
    
    <?php
    if (ENABLE_TELL_A_FRIEND_ARTICLE == 'true') {
      if (isset($_GET['articles_id'])) {
       
          echo tep_draw_form('tell_a_friend', tep_href_link('article_blog.php', 'articles_id='.$_GET['articles_id'], $request_type), 'post') . tep_draw_hidden_field('action', 'send_email') , tep_hide_session_id();
          echo '<div class="row">';
          echo '<div class="col">'; 
          echo TEXT_TELL_A_FRIEND . '&nbsp;' . tep_draw_input_field('to_email_address', '', 'placeholder="' . BOX_TEXT_TELL_A_FRIEND_TEXT . '" size="10" maxlength="30" width=:40%"');
          echo tep_draw_button(IMAGE_BUTTON_SEND_EMAIL, 'fas fa-envelope-square', null, null, null); 
          echo tep_draw_hidden_field('articles_id', $_GET['articles_id']) ;
          echo tep_draw_hidden_field('articles_name', $articles_name) ;
          echo '</div>';
          echo '</div>';
          echo '</form>';  
      }
    }
    ?>     
        
  
 
 
<script language="javascript">      
function popupWindow(url) {
 window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=600,height=600,screenX=150,screenY=150,top=150,left=150')
}
document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link('article_popup_print.php', 'aID=' .  (int)$_GET['articles_id'] . '&language_id=' . (int)$_SESSION['languages_id']) . '\\\')">' . tep_draw_button(IMAGE_PRINT_ARTICLE, 'fas fa-print') . '</a>'; ?>');
</script>
      
<?php 
  }  
require $oscTemplate->map_to_template('template_bottom.php', 'component'); 
  
 