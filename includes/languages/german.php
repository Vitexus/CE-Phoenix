<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
 */
// look in your $PATH_LOCALE/locale directory for available locales
// or type locale -a on the server.
// Examples:
// on RedHat try 'en_US'
// on FreeBSD try 'en_US.ISO_8859-1'
// on Windows try 'en', or 'English'
//@setlocale(LC_TIME, 'de_DE.ISO_8859-1');
@setlocale(LC_ALL, array('de_DE.UTF-8', 'de_DE.UTF8', 'deu_deu'));

const DATE_FORMAT_SHORT = '%d/%m/%Y';
const DATE_FORMAT_LONG = '%A %d %B, %Y';
const DATE_FORMAT = 'd/m/Y';
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT.' %H:%M:%S');
const JQUERY_DATEPICKER_I18N_CODE = '';
const JQUERY_DATEPICKER_FORMAT = 'dd/mm/yy';

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function tep_date_raw($date, $reverse = false)
{
    if ($reverse) {
        return substr($date, 0, 2).substr($date, 3, 2).substr($date, 6, 4);
    } else {
        return substr($date, 6, 4).substr($date, 3, 2).substr($date, 0, 2);
    }
}
// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
const LANGUAGE_CURRENCY = 'EUR';

// Global entries for the <html> tag
const HTML_PARAMS = 'dir="ltr" lang="de"';

// charset for web pages and emails
const CHARSET = 'utf-8';

// page title
define('TITLE', STORE_NAME);

// header text in includes/header.php
const HEADER_TITLE_CREATE_ACCOUNT = 'Neues Konto';
const HEADER_TITLE_MY_ACCOUNT = 'Ihr Konto';
const HEADER_TITLE_CART_CONTENTS = 'Warenkorb';
const HEADER_TITLE_CHECKOUT = 'Kasse';
const HEADER_TITLE_TOP = 'Startseite';
const HEADER_TITLE_CATALOG = 'Katalog';
const HEADER_TITLE_LOGOFF = 'Abmelden';
const HEADER_TITLE_LOGIN = 'Anmelden';

// footer text in includes/footer.php
const FOOTER_TEXT_REQUESTS_SINCE = 'Zugriffe seit';

// text for gender
const MALE = 'Herr';
const FEMALE = 'Frau';
const MALE_ADDRESS = 'Herr';
const FEMALE_ADDRESS = 'Frau';

// text for date of birth example
const DOB_FORMAT_STRING = 'dd/mm/jjjj';

// checkout procedure text
const CHECKOUT_BAR_DELIVERY = 'Versandinformationen';
const CHECKOUT_BAR_PAYMENT = 'Zahlungsweise';
const CHECKOUT_BAR_CONFIRMATION = 'Bestätigung';
const CHECKOUT_BAR_FINISHED = 'Fertig!';

// pull down default text
const PULL_DOWN_DEFAULT = 'Bitte wählen';
const TYPE_BELOW = 'bitte unten eingeben';

// javascript messages
define('JS_ERROR', 'Notwendige Angaben fehlen!\nBitte richtig ausfüllen.\n\n’',
    true);

define('JS_REVIEW_TEXT',
    '* Der Text muss mindestens aus '.REVIEW_TEXT_MIN_LENGTH.' Buchstaben bestehen.\n',
    true);
const JS_REVIEW_RATING = '* Geben Sie Ihre Bewertung ein.\n';

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED',
    '* Bitte wählen Sie eine Zahlungsweise für Ihre Bestellung.\n');

define('JS_ERROR_SUBMITTED',
    'Diese Seite wurde bereits bestätigt. Betätigen Sie bitte OK und warten bis der Prozess durchgeführt wurde.',
    true);

define('ERROR_NO_PAYMENT_MODULE_SELECTED',
    'Bitte wählen Sie eine Zahlungsweise für Ihre Bestellung.');

const CATEGORY_COMPANY = 'Firmendaten';
const CATEGORY_PERSONAL = 'Ihre persönlichen Daten';
const CATEGORY_ADDRESS = 'Ihre Adresse';
const CATEGORY_CONTACT = 'Ihre Kontaktinformationen';
const CATEGORY_OPTIONS = 'Optionen';
const CATEGORY_PASSWORD = 'Ihr Passwort';

const ENTRY_COMPANY = 'Firmenname:';
//define('ENTRY_COMPANY_ERROR', '',true);
const ENTRY_COMPANY_TEXT = '';
const ENTRY_GENDER = 'Anrede:';
const ENTRY_GENDER_ERROR = 'Bitte das Geschlecht angeben.';
const ENTRY_GENDER_TEXT = '';
const ENTRY_FIRST_NAME = 'Vorname:';
define('ENTRY_FIRST_NAME_ERROR',
    'Der Vorname sollte mindestens '.ENTRY_FIRST_NAME_MIN_LENGTH.' Zeichen enthalten.',
    true);
const ENTRY_FIRST_NAME_TEXT = '';
const ENTRY_LAST_NAME = 'Nachname:';
define('ENTRY_LAST_NAME_ERROR',
    'Der Nachname sollte mindestens '.ENTRY_LAST_NAME_MIN_LENGTH.' Zeichen enthalten.',
    true);
const ENTRY_LAST_NAME_TEXT = '';
const ENTRY_DATE_OF_BIRTH = 'Geburtsdatum:';
define('ENTRY_DATE_OF_BIRTH_ERROR',
    'Bitte geben Sie Ihr Geburtsdatum in folgendem Format ein: TT/MM/JJJJ (z.B. 21/05/1970)',
    true);
const ENTRY_DATE_OF_BIRTH_TEXT = '* (z.B. 21/05/1970)';
const ENTRY_EMAIL_ADDRESS = 'eMail-Adresse:';
define('ENTRY_EMAIL_ADDRESS_ERROR',
    'Die eMail Adresse sollte mindestens '.ENTRY_EMAIL_ADDRESS_MIN_LENGTH.' Zeichen enthalten.',
    true);
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR',
    'Die eMail Adresse scheint nicht gültig zu sein - bitte korrigieren.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS',
    'Die eMail Adresse ist bereits gespeichert - bitte melden Sie sich mit dieser Adresse an oder eröffnen Sie ein neues Konto mit einer anderen Adresse.',
    true);
const ENTRY_EMAIL_ADDRESS_TEXT = '';
const ENTRY_STREET_ADDRESS = 'Strasse/Hausnr.:';
define('ENTRY_STREET_ADDRESS_ERROR',
    'Die Strassenadresse sollte mindestens '.ENTRY_STREET_ADDRESS_MIN_LENGTH.' Zeichen enthalten.',
    true);
const ENTRY_STREET_ADDRESS_TEXT = '';
const ENTRY_SUBURB = 'Stadtteil:';
const ENTRY_SUBURB_ERROR = '';
const ENTRY_SUBURB_TEXT = '';
const ENTRY_POST_CODE = 'Postleitzahl:';
define('ENTRY_POST_CODE_ERROR',
    'Die Postleitzahl sollte mindestens '.ENTRY_POSTCODE_MIN_LENGTH.' Zeichen enthalten.',
    true);
const ENTRY_POST_CODE_TEXT = '';
const ENTRY_CITY = 'Ort:';
define('ENTRY_CITY_ERROR',
    'Die Stadt sollte mindestens '.ENTRY_CITY_MIN_LENGTH.' Zeichen enthalten.',
    true);
const ENTRY_CITY_TEXT = '';
const ENTRY_STATE = 'Bundesland:';
define('ENTRY_STATE_ERROR',
    'Das Bundesland sollte mindestens '.ENTRY_STATE_MIN_LENGTH.' Zeichen enthalten.',
    true);
define('ENTRY_STATE_ERROR_SELECT',
    'Bitte wählen Sie ein Bundesland aus der Liste.');
const ENTRY_STATE_TEXT = '';
const ENTRY_COUNTRY = 'Land:';
const ENTRY_COUNTRY_ERROR = 'Bitte wählen Sie ein Land aus der Liste.';
const ENTRY_COUNTRY_TEXT = '';
const ENTRY_TELEPHONE_NUMBER = 'Telefonnummer:';
define('ENTRY_TELEPHONE_NUMBER_ERROR',
    'Die Telefonnummer sollte mindestens '.ENTRY_TELEPHONE_MIN_LENGTH.' Zeichen enthalten.',
    true);
const ENTRY_TELEPHONE_NUMBER_TEXT = '';
const ENTRY_FAX_NUMBER = 'Telefaxnummer:';
const ENTRY_FAX_NUMBER_ERROR = '';
const ENTRY_FAX_NUMBER_TEXT = '';
const ENTRY_NEWSLETTER = 'Newsletter:';
const ENTRY_NEWSLETTER_TEXT = '';
const ENTRY_NEWSLETTER_YES = 'abonniert';
const ENTRY_NEWSLETTER_NO = 'nicht abonniert';
const ENTRY_NEWSLETTER_ERROR = '';
const ENTRY_PASSWORD = 'Passwort:';
define('ENTRY_PASSWORD_ERROR',
    'Das Passwort sollte mindestens '.ENTRY_PASSWORD_MIN_LENGTH.' Zeichen enthalten.',
    true);
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING',
    'Beide eingegebenen Passwörter müssen identisch sein.');
const ENTRY_PASSWORD_TEXT = '';
const ENTRY_PASSWORD_CONFIRMATION = 'Bestätigung:';
const ENTRY_PASSWORD_CONFIRMATION_TEXT = '';
const ENTRY_PASSWORD_CURRENT = 'Aktuelles Passwort:';
const ENTRY_PASSWORD_CURRENT_TEXT = '';
define('ENTRY_PASSWORD_CURRENT_ERROR',
    'Das Passwort sollte mindestens '.ENTRY_PASSWORD_MIN_LENGTH.' Zeichen enthalten.',
    true);
const ENTRY_PASSWORD_NEW = 'Neues Passwort:';
const ENTRY_PASSWORD_NEW_TEXT = '';
define('ENTRY_PASSWORD_NEW_ERROR',
    'Das neue Passwort sollte mindestens '.ENTRY_PASSWORD_MIN_LENGTH.' Zeichen enthalten.',
    true);
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING',
    'Die Passwort-Bestätigung muss mit Ihrem neuen Passwort übereinstimmen.',
    true);
const PASSWORD_HIDDEN = '--VERSTECKT--';

const FORM_REQUIRED_INFORMATION = '* Notwendige Eingabe';

// constants for use in tep_prev_next_display function
const TEXT_RESULT_PAGE = 'Seiten:';
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS',
    'angezeigte Produkte: <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)',
    true);
define('TEXT_DISPLAY_NUMBER_OF_ORDERS',
    'angezeigte Bestellungen: <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)',
    true);
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS',
    'angezeigte Meinungen: <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)',
    true);
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW',
    'angezeigte neue Produkte: <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)',
    true);
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS',
    'angezeigte Angebote <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)',
    true);

const PREVNEXT_TITLE_FIRST_PAGE = 'erste Seite';
const PREVNEXT_TITLE_PREVIOUS_PAGE = 'vorherige Seite';
const PREVNEXT_TITLE_NEXT_PAGE = 'nächste Seite';
const PREVNEXT_TITLE_LAST_PAGE = 'letzte Seite';
const PREVNEXT_TITLE_PAGE_NO = 'Seite %d';
const PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE = 'Vorhergehende %d Seiten';
const PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE = 'Nächste %d Seiten';
const PREVNEXT_BUTTON_FIRST = '&lt;&lt;ERSTE';
const PREVNEXT_BUTTON_PREV = '[&lt;&lt;&nbsp;vorherige]';
const PREVNEXT_BUTTON_NEXT = '[nächste&nbsp;&gt;&gt;]';
const PREVNEXT_BUTTON_LAST = 'LETZTE&gt;&gt;';

const IMAGE_BUTTON_ADD_ADDRESS = 'Neue Adresse';
const IMAGE_BUTTON_ADDRESS_BOOK = 'Adressbuch';
const IMAGE_BUTTON_BACK = 'Zurück';
const IMAGE_BUTTON_BUY_NOW = 'In den Warenkorb';
const IMAGE_BUTTON_CHANGE_ADDRESS = 'Adresse ändern';
const IMAGE_BUTTON_CHECKOUT = 'Kasse';
const IMAGE_BUTTON_CONFIRM_ORDER = 'Bestellung bestätigen';
const IMAGE_BUTTON_CONTINUE = 'Weiter';
const IMAGE_BUTTON_CONTINUE_SHOPPING = 'Einkauf fortsetzen';
const IMAGE_BUTTON_DELETE = 'Löschen';
const IMAGE_BUTTON_EDIT_ACCOUNT = 'Daten ändern';
const IMAGE_BUTTON_HISTORY = 'Bestellübersicht';
const IMAGE_BUTTON_LOGIN = 'Anmelden';
const IMAGE_BUTTON_IN_CART = 'In den Warenkorb';
const IMAGE_BUTTON_NOTIFICATIONS = 'Benachrichtigungen';
const IMAGE_BUTTON_QUICK_FIND = 'Schnellsuche';
const IMAGE_BUTTON_REMOVE_NOTIFICATIONS = 'Benachrichtigungen löschen';
const IMAGE_BUTTON_REVIEWS = 'Bewertungen';
const IMAGE_BUTTON_SEARCH = 'Suchen';
const IMAGE_BUTTON_SHIPPING_OPTIONS = 'Versandoptionen';
const IMAGE_BUTTON_TELL_A_FRIEND = 'Weiterempfehlen';
const IMAGE_BUTTON_UPDATE = 'Aktualisieren';
const IMAGE_BUTTON_UPDATE_CART = 'Warenkorb aktualisieren';
const IMAGE_BUTTON_WRITE_REVIEW = 'Bewertung schreiben';

const SMALL_IMAGE_BUTTON_DELETE = 'Löschen';
const SMALL_IMAGE_BUTTON_EDIT = 'Bearbeiten';
const SMALL_IMAGE_BUTTON_VIEW = 'Ansicht';

const ICON_ARROW_RIGHT = 'Zeige mehr';
const ICON_CART = 'In den Warenkorb';
const ICON_ERROR = 'Fehler';
const ICON_SUCCESS = 'Erfolg';
const ICON_WARNING = 'Warnung';

define('TEXT_GREETING_PERSONAL',
    'Schön, dass Sie wieder da sind <span class="greetUser">%s!</span> Möchten Sie die <a href="%s"><u>neuen Produkte</u></a> ansehen?',
    true);
define('TEXT_GREETING_PERSONAL_RELOGON',
    '<small>Wenn Sie nicht %s sind, melden Sie sich bitte <a href="%s"><u>hier</u></a> mit Ihrem Kundenkonto an.</small>',
    true);
const TEXT_GREETING_GUEST = '';

const TEXT_SORT_PRODUCTS = 'Sortierung der Artikel ist ';
const TEXT_DESCENDINGLY = 'absteigend';
const TEXT_ASCENDINGLY = 'aufsteigend';
const TEXT_BY = ' nach ';

const TEXT_REVIEW_BY = 'von %s';
const TEXT_REVIEW_WORD_COUNT = '%s Worte';
const TEXT_REVIEW_RATING = 'Bewertung: %s [%s]';
const TEXT_REVIEW_DATE_ADDED = 'Datum hinzugefügt: %s';
const TEXT_NO_REVIEWS = 'Es liegen noch keine Bewertungen vor.';

const TEXT_NO_NEW_PRODUCTS = 'Zur Zeit gibt es keine neuen Produkte.';

const TEXT_UNKNOWN_TAX_RATE = 'Unbekannter Steuersatz';

const TEXT_REQUIRED = '<span class="errorText">erforderlich</span>';

define('ERROR_TEP_MAIL',
    '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>Fehler:</small> Die eMail kann nicht über den angegebenen SMTP-Server verschickt werden. Bitte kontrollieren Sie die Einstellungen in der php.ini Datei und führen Sie notwendige Korrekturen durch!</b></font>',
    true);

/*
  define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warnung: Das Installationverzeichnis ist noch vorhanden auf: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/install. Bitte löschen Sie das Verzeichnis aus Gründen der Sicherheit!',true);
  define('WARNING_CONFIG_FILE_WRITEABLE', 'Warnung: osC kann in die Konfigurationsdatei schreiben: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. Das stellt ein mögliches Sicherheitsrisiko dar - bitte korrigieren Sie die Benutzerberechtigungen zu dieser Datei!',true);
  define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warnung: Das Verzeichnis für die Sessions existiert nicht: ' . tep_session_save_path() . '. Die Sessions werden nicht funktionieren bis das Verzeichnis erstellt wurde!',true);
  define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warnung: osC kann nicht in das Sessions Verzeichnis schreiben: ' . tep_session_save_path() . '. Die Sessions werden nicht funktionieren bis die richtigen Benutzerberechtigungen gesetzt wurden!',true);
  define('WARNING_SESSION_AUTO_START', 'Warnung: session.auto_start ist enabled - Bitte disablen Sie dieses PHP Feature in der php.ini und starten Sie den WEB-Server neu!',true);
  define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warnung: Das Verzeichnis für den Artikel Download existiert nicht: ' . DIR_FS_DOWNLOAD . '. Diese Funktion wird nicht funktionieren bis das Verzeichnis erstellt wurde!',true);
 */
define('TEXT_CCVAL_ERROR_INVALID_DATE',
    'Das "Gültig bis" Datum ist ungültig. Bitte korrigieren Sie Ihre Angaben.',
    true);
define('TEXT_CCVAL_ERROR_INVALID_NUMBER',
    'Die "KreditkarteNummer", die Sie angegeben haben, ist ungültig. Bitte korrigieren Sie Ihre Angaben.',
    true);
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD',
    'Die ersten 4 Ziffern Ihrer Kreditkarte sind: %s. Wenn diese Angaben stimmen, wird dieser Kartentyp leider nicht akzeptiert. Bitte korrigieren Sie Ihre Angaben gegebenfalls.',
    true);


//pure:new link to advanced search
const IMAGE_BUTTON_ADVANCED_SEARCH_LINK = 'podrobné';

const TABLE_HEADING_DATE_AVAILABLE = 'Latest Products';
const TABLE_HEADING_CUSTOM_DATE = 'Evet\'s Date';
const TABLE_HEADING_SORT_ORDER = 'Sort Order';
//VAT numbber
const ENTRY_VAT_NUMBER_TEXT_2 = '';
const ENTRY_COMPANY_NUMBER = 'COMPANY ID:';
const ENTRY_COMPANY_NUMBER_TEXT_2 = '';
