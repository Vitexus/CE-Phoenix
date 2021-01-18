<?php
/*
  $Id: article_listing.php, v1.0 2003/12/04 12:00:00 ra Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  $listing_split = new splitPageResults($listing_sql, MAX_ARTICLES_PER_PAGE);
  if ($listing_split->number_of_rows > 0) {
      $articles_listing_query = tep_db_query($listing_split->sql_query);
 
      while ($articles_listing = tep_db_fetch_array($articles_listing_query)) {
          $page = ($articles_listing['articles_is_blog'] ? 'article_blog.php' : 'article_info.php');
      ?>
          <div valign="top" class="main">
           <?php  
             echo '<a class="main" href="' . tep_href_link($page, 'articles_id=' . $articles_listing['articles_id']) . '"><b>' . $articles_listing['articles_name'] . '</b></a> ';
             if (DISPLAY_AUTHOR_ARTICLE_LISTING == 'true' && tep_not_null($articles_listing['authors_name'])) {
                 echo TEXT_BY_AM . ' ' . '<a href="' . tep_href_link('articles.php', 'authors_id=' . $articles_listing['authors_id']) . '"> ' . $articles_listing['authors_name'] . '</a>';
             }
           ?>
          </div>
          
          <?php
          if (DISPLAY_TOPIC_ARTICLE_LISTING == 'true' && tep_not_null($articles_listing['topics_name'])) {
              echo '<div class="article-line-padding"><span class="article-line-caption">' . TEXT_TOPIC . '</span><a href="' . tep_href_link('articles.php', 'tPath=' . $articles_listing['topics_id']) . '">' . $articles_listing['topics_name'] . '</a></div>';
          }
          if (DISPLAY_DATE_ADDED_ARTICLE_LISTING == 'true') {
              echo '<div class="article-line-padding"><span class="article-line-caption">' . TEXT_DATE_ADDED . '</span>' . tep_date_long($articles_listing['articles_date_added']) . '</div>';
          }
          if (DISPLAY_ABSTRACT_ARTICLE_LISTING == 'true') {
              $more = (strlen($articles_listing['articles_description']) > MAX_ARTICLE_ABSTRACT_LENGTH ? '<span style="color:red;">...</span>' : '');
              echo '<div class="article-line-padding">' . TruncateHTML($articles_listing['articles_description'], MAX_ARTICLE_ABSTRACT_LENGTH) . $more . '</div>';
          }
          
          echo '<div style="padding-top:20px;"></div>'; //separate the listings
      }  
  } else {
?>
     <div class="main">
     <?php 
      if     (tep_not_null($listing_no_article)) echo $listing_no_article; 
      else if ($topic_depth == 'articles')       echo TEXT_NO_ARTICLES;
      else if (isset($_GET['authors_id']))       echo TEXT_NO_ARTICLES2;
      else                                       echo TEXT_NO_ARTICLES_BLOG;
    ?>
    </div>
<?php
 }

  if (($listing_split->number_of_rows > 0) && ((ARTICLE_PREV_NEXT_BAR_LOCATION == 'bottom') || (ARTICLE_PREV_NEXT_BAR_LOCATION == 'both'))) {
?>
   <div class="row" style="padding-top:10px;">
     <div class="col-sm-6 pagenumber hidden-xs">
       <?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES); ?>
     </div>
     <div class="col-sm-6">
       <div class="pull-right pagenav"><ul class="pagination"><?php echo $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></ul></div>
       <span class="pull-right"><?php echo TEXT_RESULT_PAGE; ?></span>
     </div>
   </div>            
<?php
  }
