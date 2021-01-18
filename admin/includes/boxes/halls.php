<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2019 osCommerce

  Released under the GNU General Public License
*/

  foreach ( $cl_box_groups as &$group ) {
    if ( $group['heading'] == BOX_HEADING_CATALOG ) {
      $group['apps'][] = array('code' => 'hall.php',
                               'title' => MODULES_ADMIN_MENU_CATALOG_NEW_HALL,
                               'link' => tep_href_link('hall.php'));
      
      $group['apps'][] = array('code' => 'halls.php',
                               'title' => MODULES_ADMIN_MENU_CATALOG_HALLS,
                               'link' => tep_href_link('halls.php'));

      break;
    }
  }
