<?php
  /*
  Information Pages SEO by Jack York aka Jack_MCS at https://www.oscommerce-solution.com
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2018 osCommerce
  Portions Copyright 2019 oscommerce-solution.com

  Released under the GNU General Public License
  */
  define('HEADING_TITLE_INFORMATION_PAGES', 'Information Pages');
  define('HEADING_TITLE_AUTHOR', 'by Jack_mcs from <a href="http://www.oscommerce-solution.com/" target="_blank"><span style="font-family: Verdana, Arial, sans-serif; color: sienna; font-size: 12px;">oscommerce-solution.com</span></a>');
  define('HEADING_TITLE_SUPPORT_THREAD_IP', '<a href="https://forums.oscommerce.com/topic/412782-information-pages-seo-addon/" target="_blank"><span style="color: sienna;">(visit the support thread)</span></a>');

  define('HEADING_SUB_TITLE', '');


  define('ACTION_INFORMATION', 'Action');
  define('ACTIVATION_ID_INFORMATION', 'Activation of information ID=');
  define('ADD_INFORMATION', 'Add new information');
  define('ADD_QUEUE_INFORMATION', ' Add information to queue');
  define('ALERT_INFORMATION', 'Empty information system');
  define('ANSWER_INFORMATION', 'Answer');
  define('CONFIRM_INFORMATION', 'Confirm');
  define('DEACTIVATION_ID_INFORMATION', 'Deactivation of information ID=');
  define('DELETE_CONFIRMATION_ID_INFORMATION', 'Confirm removal of information ID=');
  define('DELETE_ID_INFORMATION', 'Delete the information ID=');
  define('DELETED_ID_INFORMATION', 'Deleted the information ID=');
  define('DO_DELETE' , 'Delete');
  define('DO_EDIT' , 'Edit');
  define('DO_VIEW' , 'View');
  define('DO_VIEW_NO' , 'View Disabled');
  define('EDIT_ID_INFORMATION', 'Edit %s (ID = %d)');
  define('ENTRY_BOX_ID', 'Box ID');
  define('ENTRY_DESCRIPTION', 'Description');
  define('ENTRY_PARENT_PAGE', 'Parent ID');
  define('ENTRY_PAGE_REDIRECT', 'Redirect');
  define('ENTRY_PAGES_STR', 'Pages');
  define('ENTRY_SORT_ORDER', 'Sort order');
  define('ENTRY_STATUS', 'Status');
  define('ENTRY_TITLE', 'Title');
  define('ENTRY_TEXT', 'Text');
  define('ERROR_20_INFORMATION', 'You have not defined a valid value for option <strong>Queue</strong>. You can only define a numeric value');
  define('ERROR_80_INFORMATION', 'You did not fill all <strong>necessary fields</strong>');
  define('ID_INFORMATION', 'ID');
  define('IMAGE_IM_CANCEL', 'Cancel');
  define('IMAGE_IM_CART', 'Add to Cart');
  define('IMAGE_IM_INSERT', 'Insert');
  define('IMAGE_IM_NEW_PAGE', 'New Page');
  define('IMAGE_IM_NEW_MESSAGE', 'New Message');
  define('IMAGE_IM_SAVE', 'Save');
  define('IMAGE_IM_VIEW', 'View');
  define('INFORMATION_ID_ACTIVE', 'this information is Active'); 
  define('INFORMATION_ID_DEACTIVE', 'this information is NOT active'); 
  define('QUEUE_INFORMATION', 'Queue');
  define('QUEUE_INFORMATION_LIST', 'QueueList: ');
  define('MANAGER_INFORMATION', 'Information Manager');
  define('NO_INFORMATION', 'No');
  define('SORT_BY', 'In information Page this Sort by');
  define('STATUS', 'Status');
  define('STATUS_CHANGE', 'Click to change the status.');
  define('STATUS_ACTIVE', 'Active');
  define('STATUS_INACTIVE', 'Inactive');  
  define('SUCCED_INFORMATION', ' Succeed');
  define('TEXT_NO_PARENT', 'not set');
  define('TEXT_SELECT_PARENT',  'No Parent');
  define('VIEW_INFORMATION', 'Information View');
  define('VISIBLE_INFORMATION', 'Visible');
  define('VISIBLE_INFORMATION_DO', '( To Do visible )');
  define('UPDATE_ID_INFORMATION', 'Updated information for ID=');
  define('WARNING_INFORMATION', 'Warning');
  define('WARNING_PARENT_PAGE', 'At least one page required to use this option.');
  define('ERROR_ADDING', 'Failed to add information to database.');
  define('ERROR_INVALID_BOX_ID', 'The Box ID is invalid.');  

  define('NOTES_TEXT_HIDE', 'Hide Notes:');
  define('NOTES_TEXT_SHOW', 'Show Notes:');
  define('NOTE_SHORTCUT_CATEGORY', 'Enter CID(XX)CID, where XX is a valid category ID, in the description and it will be replaced with links to all of the products in that category when the page is saved.');
  define('NOTE_SHORTCUT_PRODUCT', 'Enter PID(XX)PID, where XX is a valid product ID, in the description and it will be replaced with a link to that product when the page is saved.');
  define('NOTE_SHORTCUT_NAME', 'Enter PNAME(XX)PNAME, where XX is a word in the title of a product, in the description and it will be replaced with a links to products with that word in the name.');
  define('NOTE_SHORTCUT_CONFIG', 'Enter CONFIG(XX)CONFIG, where XX is a configuration key, like STORE_ADDRESS, in the configurations table and it will be replaced with the configuration value.');
  define('NOTE_SHORTCUT_EASY_TEXT', 'To add a message to any page in the shop, just include this line: &lt;?php echo GetInformationPageText(\'XXX\'); ?&gt;,where XXX is the Message Name or its ID.');
  define('NOTE_SHORTCUT_PAGES', 'To control where a page will show on the shop side, use one of these options:<br />&nbsp;
   all - show on all pages.<br />&nbsp;
   cid - show only on category pages.<br />&nbsp;
   cid=XX - show only on the category page with the ID of XX.<br />&nbsp;
   mid - show only on manufacturer pages.<br />&nbsp;
   mid=XX - show only on the manufacturer page with the ID of XX.<br />&nbsp;
   pid - show only on product pages.<br />&nbsp;
   pid=XX - show only on the product page with the ID of XX.<br />&nbsp;
  ');
  $noteArray = array(NOTE_SHORTCUT_CATEGORY,
                     NOTE_SHORTCUT_PRODUCT,
                     NOTE_SHORTCUT_NAME,
                     NOTE_SHORTCUT_CONFIG,
                     NOTE_SHORTCUT_EASY_TEXT,
                     NOTE_SHORTCUT_PAGES
                    );  
  define('HTS_SEO_TITLE', 'Browser Title');
  define('HTS_SEO_DESC', 'Meta Description');
  define('HTS_SEO_KWORDS', 'Meta Keywords');
  
  