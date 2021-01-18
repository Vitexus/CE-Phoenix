<?php
/*
  $Id: articles.php, v1.5.1 2003/12/04 12:00:00 ra Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2020 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  $authors_description = '';
  $authors_url = '';

// the following tPath references come from application_top.php
  $topic_depth = 'top';

  if (isset($tPath) && tep_not_null($tPath)) {
      $topics_articles_query = tep_db_query("SELECT COUNT(*) as total from articles_to_topics where topics_id = '" . (int)$current_topic_id . "'");
      $topics_articles = tep_db_fetch_array($topics_articles_query);
      if ($topics_articles['total'] > 0) {
          $topic_depth = 'articles'; // display articles
      } else {
          $topic_parent_query = tep_db_query("SELECT COUNT(*) as total from topics where parent_id = '" . (int)$current_topic_id . "'");
          $topic_parent = tep_db_fetch_array($topic_parent_query);
          if ($topic_parent['total'] > 0) {
              $topic_depth = 'nested'; // navigate through the topics
          } else {
              $topic_depth = 'articles'; // topic has no articles, but display the 'no articles' message
          }
      }
  }

  require('includes/languages/' . $language . '/article_manager/articles.php');

  require $oscTemplate->map_to_template(__FILE__, 'page');

  require 'includes/application_bottom.php'; 