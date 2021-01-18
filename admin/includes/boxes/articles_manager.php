<?php
/*
  $Id: articles.php, v1.0 2003/12/04 12:00:00 ra Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/
 
  $cl_box_groups[] = array(
    'heading' => MODULES_ADMIN_MENU_ARTICLES_MANAGER_HEADING,
    'apps' => array(
      array(
        'code' => 'articles.php',
        'title' => MODULES_ADMIN_MENU_TOPICS_ARTICLES,
        'link' => tep_href_link('articles.php')
      ),
      array(
        'code' => 'authors.php',
        'title' => MODULES_ADMIN_MENU_ARTICLES_AUTHORS,
        'link' => tep_href_link('authors.php')
      ),
      array(
        'code' => 'article_manager_blog_comments.php',
        'title' => MODULES_ADMIN_MENU_ARTICLES_BLOG_COMMENTS,
        'link' => tep_href_link('article_manager_blog_comments.php')
      ),
      array(
        'code' => 'article_reviews.php',
        'title' => MODULES_ADMIN_MENU_ARTICLES_REVIEWS,
        'link' => tep_href_link('article_reviews.php')
      ),
      array(
        'code' => 'articles_xsell.php',
        'title' => MODULES_ADMIN_MENU_ARTICLES_XSELL,
        'link' => tep_href_link('articles_xsell.php')
      )
    )
  );

