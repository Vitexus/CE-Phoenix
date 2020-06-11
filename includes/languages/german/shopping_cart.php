<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
 */

const NAVBAR_TITLE = 'Warenkorb';
const HEADING_TITLE = 'Ihr Warenkorb enthält :';
//define('TABLE_HEADING_QUANTITY', 'Anzahl',true);
//define('TABLE_HEADING_MODEL', 'Artikelnr.',true);
const TABLE_HEADING_PRODUCTS = 'Artikel';
//define('TABLE_HEADING_TOTAL', 'Summe',true);
const TEXT_CART_EMPTY = 'Sie haben noch nichts in Ihrem Warenkorb.';
const SUB_TITLE_SUB_TOTAL = 'Zwischensumme:';
const SUB_TITLE_TOTAL = 'Summe:';

define('OUT_OF_STOCK_CANT_CHECKOUT',
    'Die mit '.STOCK_MARK_PRODUCT_OUT_OF_STOCK.' markierten Produkte, sind leider nicht in der von Ihnen gewünschten Menge auf Lager.<br>/>Bitte reduzieren Sie Ihre Bestellmenge für die gekennzeichneten Produkte, ('.STOCK_MARK_PRODUCT_OUT_OF_STOCK.'),Vielen Dank',
    true);
define('OUT_OF_STOCK_CAN_CHECKOUT',
    'Die mit '.STOCK_MARK_PRODUCT_OUT_OF_STOCK.' markierten Produkte, sind leider nicht in der von Ihnen gewünschten Menge auf Lager.<br>/>Die bestellte Menge wird kurzfristig von uns geliefert, wenn Sie es wünschen nehmen wir auch eine Teillieferung vor.',
    true);

const TEXT_ALTERNATIVE_CHECKOUT_METHODS = '- ODER -';
const TEXT_OR = 'oder ';
const TEXT_REMOVE = 'Entfernen';
?>
