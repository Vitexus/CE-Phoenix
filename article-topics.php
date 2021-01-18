<?php
/*
  $Id: articles-topics.php, v1.5.1 2003/12/04 12:00:00 ra Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2009 oscommerce-solution.com

  Released under the GNU General Public License
*/
  require('includes/application_top.php');
  require('includes/languages/' . $language . '/article_manager/article-topics.php');
  require $oscTemplate->map_to_template(__FILE__, 'page');
  require 'includes/application_bottom.php'; 