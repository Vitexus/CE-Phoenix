<?php
  $breadcrumb->add(NAVBAR_TITLE, tep_href_link('article_info.php'));

  require $oscTemplate->map_to_template('template_top.php', 'component');

  if ($article_check['total'] < 1) { ?>
     <div class="page-header" ><?php echo HEADING_ARTICLE_NOT_FOUND; ?></div>
     <div class="main" ><?php echo TEXT_ARTICLE_NOT_FOUND; ?></div>
  <?php
   } else {
      $article_info_query = tep_db_query("select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_image, ad.articles_url, ad.articles_viewed, au.authors_name, au.authors_image from articles a left join authors au using(authors_id), articles_description ad where a.articles_status = '1' and a.articles_id = '" . (int)$_GET['articles_id'] . "' and ad.articles_id = a.articles_id and ad.language_id = '" . (int)$languages_id . "'");
      $article_info = tep_db_fetch_array($article_info_query);
      tep_db_query("update articles_description set articles_viewed = articles_viewed+1 where articles_id = '" . (int)$_GET['articles_id'] . "' and language_id = '" . (int)$languages_id . "'");
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
     <div style="col teft-left">
     
       <span class="smallText ml-3">   
         <?php      
         if (DISPLAY_AUTHOR_ARTICLE_LISTING == 'true' && tep_not_null($articles_author)) {
            $authorsImage = 'images/article_manager_uploads/' . $article_info['authors_image'];
            if (file_exists($authorsImage) && is_file($authorsImage)) {
                echo '<a>' . tep_image($authorsImage, HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT) . '</a>';
            } else {
                echo TEXT_BY_AM . '<a>' . $articles_author . '</a>';
            }
         }
         ?>   
       </span>            
       <?php 
       if ($article_info['articles_viewed']) { 
         echo '<span>' . sprintf(ARTICLE_VIEWED_COUNT, $article_info['articles_viewed']) . '</span>';
       }
      ?>       
     </div>
   </div>
    
   <div class="row"> 
    <div class="col article-listing">
      <div class="contentText">
        <?php echo stripslashes($article_info['articles_description']); ?>
      </div>
      
      <?php 
      if (tep_not_null($article_info['articles_url'])) { ?>
        <div class="articlePadding"><?php echo sprintf(TEXT_MORE_INFORMATION, "https://" . urlencode($article_info['articles_url']) ); ?></div>
      <?php
      }
      if (DISPLAY_DATE_ADDED_ARTICLE_LISTING == 'true') {
          if ($article_info['articles_date_available'] > date('Y-m-d H:i:s')) { ?>
             <div class="articlePadding"><?php echo sprintf(TEXT_DATE_AVAILABLE, tep_date_long($article_info['articles_date_available'])); ?></div>
          <?php
          } else { ?>
             <div class="articlePadding"><?php echo sprintf(TEXT_DATE_ADDED, tep_date_long($article_info['articles_date_added'])); ?></div>
      <?php
          }
      }
      ?>       

      <div class="articlePadding">
      <?php include('includes/modules/articles_xsell.php'); ?>
      </div>      
    
      <?php
      if (ENABLE_TELL_A_FRIEND_ARTICLE == 'true') {
        if (isset($_GET['articles_id'])) {
         
            echo tep_draw_form('tell_a_friend', tep_href_link('article_info.php', 'articles_id='.$_GET['articles_id'], $request_type), 'post') . tep_draw_hidden_field('action', 'send_email') , tep_hide_session_id();
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
   
             
      <div class="buttonSet">
        <div class="text-right"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'far fa-hand-point-right', tep_href_link('index.php')); ?></div>
      </div>
    </div>
  </div>  
<?php 
  }  
 
  require $oscTemplate->map_to_template('template_bottom.php', 'component');
 
