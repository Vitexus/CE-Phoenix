<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
 */

const NAVBAR_TITLE_1 = 'Erweiterte Suche';
const NAVBAR_TITLE_2 = 'Suchergebnisse';

const HEADING_TITLE_1 = 'Geben Sie Ihre Suchkriterien ein';
const HEADING_TITLE_2 = 'Artikel, welche den Suchkriterien entsprechen';

const HEADING_SEARCH_CRITERIA = 'Geben Sie Ihre Stichworte ein';

const TEXT_SEARCH_IN_DESCRIPTION = 'Auch in den Beschreibungen suchen';
const ENTRY_CATEGORIES = 'Kategorien:';
const ENTRY_INCLUDE_SUBCATEGORIES = 'Unterkategorien mit einbeziehen';
const ENTRY_MANUFACTURERS = 'Hersteller:';
const ENTRY_PRICE_FROM = 'Preis ab:';
const ENTRY_PRICE_TO = 'Preis bis:';
const ENTRY_DATE_FROM = 'hinzugefügt von:';
const ENTRY_DATE_TO = 'hinzugefügt bis:';

const TEXT_SEARCH_HELP_LINK = '<u>Hilfe zur erweiterten Suche</u> [?]';

const TEXT_ALL_CATEGORIES = 'Alle Kategorien';
const TEXT_ALL_MANUFACTURERS = 'Alle Hersteller';

const HEADING_SEARCH_HELP = 'Hilfe zur erweiterten Suche';
define('TEXT_SEARCH_HELP',
    'Die Suchfunktion ermöglicht Ihnen die Suche in den Produktnamen, Produktbeschreibungen, Herstellern und Artikelnummern.<br><br>Sie haben die Möglichkeit logische Operatoren wie "AND" (Und) und "OR" (oder) zu verwenden.<br><br>Als Beispiel könnten Sie also angeben: <u>Microsoft AND Maus</u>.<br><br>Desweiteren können Sie Klammern verwenden um die Suche zu verschachteln, also z.B.:<br><br><u>Microsoft AND (Maus OR Tastatur OR "Visual Basic")</u>.<br><br>Mit Anführungszeichen können Sie mehrere Worte zu einem Suchbegriff zusammenfassen.',
    true);
const TEXT_CLOSE_WINDOW = '<u>Fenster schliessen</u> [x]';

const TABLE_HEADING_IMAGE = '';
const TABLE_HEADING_MODEL = 'Artikelnummer';
const TABLE_HEADING_PRODUCTS = 'Bezeichnung';
const TABLE_HEADING_MANUFACTURER = 'Hersteller';
const TABLE_HEADING_QUANTITY = 'Anzahl';
const TABLE_HEADING_PRICE = 'Einzelpreis';
const TABLE_HEADING_WEIGHT = 'Gewicht';
const TABLE_HEADING_BUY_NOW = 'jetzt bestellen';

define('TEXT_NO_PRODUCTS',
    'Es wurden keine Artikel gefunden, die den Suchkriterien entsprechen.');

define('ERROR_AT_LEAST_ONE_INPUT',
    'Wenigstens ein Feld des Suchformulars muss ausgefüllt werden.');
const ERROR_INVALID_FROM_DATE = 'Unzulässiges <b>von</b> Datum';
const ERROR_INVALID_TO_DATE = 'Unzulässiges <b>bis jetzt</b> Datum';
define('ERROR_TO_DATE_LESS_THAN_FROM_DATE',
    'Das Datum <b>von</b> muss grösser oder gleich dem <b>bis jetzt</b> Datum sein',
    true);
define('ERROR_PRICE_FROM_MUST_BE_NUM', '<b>Preis ab</b> muss eine Zahl sein',
    true);
define('ERROR_PRICE_TO_MUST_BE_NUM', '<b>Preis bis</b> muss eine Zahl sein',
    true);
define('ERROR_PRICE_TO_LESS_THAN_PRICE_FROM',
    '<b>Preis bis</b> muss grö&szlig;er oder gleich <b>Preis ab</b> sein.');
const ERROR_INVALID_KEYWORDS = 'Suchbegriff unzul&aumässig';
//pure:new
const IMAGE_BUTTON_BACK_ADVANCED_SEARCH = 'back to advanced search';
?>
