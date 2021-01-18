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

  require_once('includes/languages/' . $_SESSION['language'] . '/article_manager/article_info.php');

  if (isset($_POST['action']) && $_POST['action'] == 'send_email') {

    $error = false;
    $email_address = $_POST['to_email_address'];    
    
    if ( ! filter_var($email_address, FILTER_VALIDATE_EMAIL) || preg_match( "/[\r\n]/", $email_address ) ) {
        $messageStack->add('article-message-display', ERROR_EMAIL_INVALID);
        $error = true; 
    } 
 
    if (! tep_session_is_registered('customer_id')) {
        $messageStack->add('article-message-display', ERROR_EMAIL_INVALID_CUSTOMER);
        $error = true; 
    } 
        
    if (! $error) { 
        $db_query = tep_db_query("select customers_firstname as firstname, customers_lastname as lastname from customers where customers_id = '" . (int)$_SESSION['customer_id'] . "'");
        $db = tep_db_fetch_array($db_query);

        $subject = TEXT_TELL_A_FRIEND_SUBJECT;
        $msg = sprintf(TEXT_TELL_A_FRIEND_MESSAGE, $db['firstname'] . ' ' . $db['lastname']);
        $msg .= '<a href="' . HTTPS_SERVER . DIR_WS_HTTPS_CATALOG . 'article_blog.php?articles_id=' . $_POST['articles_id'] . '">'  . $_POST['articles_name'] . '</a>';
        tep_mail('', $email_address, $subject, $msg, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
        $messageStack->add('article-message-display', TEXT_TELL_A_FRIEND_SUCCESS, 'success');
    }
  }
   
  $article_check_query = tep_db_query("SELECT COUNT(*) as total from articles a, articles_description ad where a.articles_status = '1' and a.articles_id = '" . (int)$_GET['articles_id'] . "' and ad.articles_id = a.articles_id and ad.language_id = '" . (int)$languages_id . "'");
  $article_check = tep_db_fetch_array($article_check_query);
  
  require $oscTemplate->map_to_template(__FILE__, 'page');

  require 'includes/application_bottom.php'; 
  