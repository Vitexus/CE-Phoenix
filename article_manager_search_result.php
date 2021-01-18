<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2009 http://www.oscommerce-solution.com

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require('includes/languages/' . $language . '/article_manager/article_manager_search_result.php');

  $searchFor = preg_replace('/[^A-Za-z0-9_ -]/', '', $_GET['article_keywords']);
  $listing_sql = "select * from articles a left join articles_description ad on a.articles_id = ad.articles_id where a.articles_status = 1 and ( ad.articles_name LIKE '%" . $searchFor . "%' or ad.articles_description LIKE '%" . $searchFor . "%' ) and language_id = '" . (int)$languages_id . "'";
  
  require $oscTemplate->map_to_template(__FILE__, 'page');

  require 'includes/application_bottom.php'; 
