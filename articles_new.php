<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce
  Portions Copyright 2009 http://www.oscommerce-solution.com

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require('includes/languages/' . $language . '/' . 'article_manager/articles_new.php');
  
  $articles_new_array = array();
  $listing_sql = "select a.articles_id, a.articles_date_added, a.articles_is_blog, ad.articles_name, ad.articles_description, au.authors_id, au.authors_name, td.topics_id, td.topics_name from ((articles a), articles_to_topics a2t) left join topics_description td on a2t.topics_id = td.topics_id left join authors au on a.authors_id = au.authors_id, articles_description ad where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a.articles_id = ad.articles_id and ad.language_id = '" . (int)$languages_id . "' and td.language_id = '" . (int)$languages_id . "' and a.articles_date_added > SUBDATE(now( ), INTERVAL '" . NEW_ARTICLES_DAYS_DISPLAY . "' DAY) order by a.articles_sort_order, a.articles_date_added desc, ad.articles_name";
  $listing_no_article = sprintf(TEXT_NO_NEW_ARTICLES, NEW_ARTICLES_DAYS_DISPLAY);  
  
  require $oscTemplate->map_to_template(__FILE__, 'page');

  require 'includes/application_bottom.php'; 