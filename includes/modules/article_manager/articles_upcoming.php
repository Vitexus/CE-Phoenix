<?php
/*
  $Id: articles_upcoming.php, v1.0 2003/12/04 12:00:00 ra Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
  $expected_query = tep_db_query("select a.articles_id, a.articles_date_added, a.articles_is_blog, a.articles_date_available as date_expected, ad.articles_name, ad.articles_description, au.authors_id, au.authors_name, td.topics_id, td.topics_name 
    from 
    articles a left join articles_description ad using (articles_id) left join 
      articles_to_topics a2t using (articles_id) left join 
      topics_description td on a2t.topics_id = td.topics_id left join
      authors au on a.authors_id = au.authors_id
        where 
         to_days(a.articles_date_available) > to_days(now()) and 
         a.articles_status = '1' and 
         ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and 
         td.language_id = '" . (int)$_SESSION['languages_id'] . "' 
           order by date_expected limit " . MAX_DISPLAY_UPCOMING_ARTICLES);   
   
  if (tep_db_num_rows($expected_query)) {
      echo '<div class="main" style="font-weight:bold;padding-bottom:20px;">' . TEXT_UPCOMING_ARTICLES . '</div>';
      
      while ($articles_expected = tep_db_fetch_array($expected_query)) {
     
          echo '<div class="">';
          echo '<span style="color:#999999;font-weight:bold;">' . $articles_expected['articles_name'] . '</span> ';
          if (DISPLAY_AUTHOR_ARTICLE_LISTING == 'true') {
             echo TEXT_BY_AM . ' ' . $articles_expected['authors_name'];
          }
          echo '</div>';
   
          if (DISPLAY_TOPIC_ARTICLE_LISTING == 'true') {
              echo '<div class="article-line-padding "><span class="article-line-caption">' . TEXT_TOPIC . '</span>' . $articles_expected['topics_name'] . '</div>';
          }
          
          echo '<div class="article-line-padding "><span class="article-line-caption">' . TEXT_DATE_EXPECTED . '</span>' . tep_date_long($articles_expected['date_expected']) . '</div>';
          
          if (DISPLAY_ABSTRACT_ARTICLE_LISTING == 'true') {
              echo '<div class="article-line-padding ">' . TruncateHTML($articles_expected['articles_description'], MAX_ARTICLE_ABSTRACT_LENGTH) . '</div>';
          }          
      } 
  }

