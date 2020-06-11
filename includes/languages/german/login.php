<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
 */

const NAVBAR_TITLE = 'Anmelden';
const HEADING_TITLE = 'Willkommen, melden Sie sich an';

const HEADING_NEW_CUSTOMER = 'Neuer Kunde';
const TEXT_NEW_CUSTOMER = 'Ich bin ein neuer Kunde.';
define('TEXT_NEW_CUSTOMER_INTRODUCTION',
    'Durch Ihre Anmeldung bei '.STORE_NAME.' sind Sie in der Lage schneller zu bestellen, kennen jederzeit den Status Ihrer Bestellungen und haben immer eine aktuelle übersicht über Ihre bisherigen Bestellungen.',
    true);

const HEADING_RETURNING_CUSTOMER = 'Bereits Kunde';
const TEXT_RETURNING_CUSTOMER = 'Ich bin bereits Kunde.';

define('TEXT_PASSWORD_FORGOTTEN',
    'Sie haben Ihr Passwort vergessen? Dann klicken Sie <u>hier</u>');

define('TEXT_LOGIN_ERROR',
    'Fehler: Keine übereinstimmung der eingebenen eMail-Adresse und/oder dem Passwort.',
    true);
define('TEXT_VISITORS_CART',
    '<font color="#ff0000"><b>Achtung:</b></font> Ihre Besuchereingaben werden automatisch mit Ihrem Kundenkonto verbunden. <a href="javascript:session_win();">[Mehr Information]</a>',
    true);
?>
