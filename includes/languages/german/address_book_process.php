<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
 */

const NAVBAR_TITLE_1 = 'Ihr Konto';
const NAVBAR_TITLE_2 = 'Adressbuch';

const NAVBAR_TITLE_ADD_ENTRY = 'Neuer Eintrag';
const NAVBAR_TITLE_MODIFY_ENTRY = 'Eintrag ändern';
const NAVBAR_TITLE_DELETE_ENTRY = 'Eintrag löschen';

const HEADING_TITLE_ADD_ENTRY = 'Adressbuch: Neuer Eintrag';
const HEADING_TITLE_MODIFY_ENTRY = 'Adressbuch: Eintrag ändern';
const HEADING_TITLE_DELETE_ENTRY = 'Adressbuch: Eintrag löschen';

const DELETE_ADDRESS_TITLE = 'Eintrag löschen';
define('DELETE_ADDRESS_DESCRIPTION',
    'Wollen Sie diese Adresse unwiderruflich aus Ihrem Adressbuch entfernen?',
    true);

const NEW_ADDRESS_TITLE = 'Adressbuch: Neuer Eintrag';

const SELECTED_ADDRESS = 'Standardadresse';
const SET_AS_PRIMARY = 'Als Standardadresse gesetzt.';

define('SUCCESS_ADDRESS_BOOK_ENTRY_DELETED',
    'Der ausgewählte Eintrag wurde erflogreich gelöscht.');
define('SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED',
    'Ihr Adressbuch wurde erfolgreich aktualisiert!');

define('WARNING_PRIMARY_ADDRESS_DELETION',
    'Die Standardadresse kann nicht gelöscht werden. Bitte erst eine andere Standardadresse wählen. Danach kann der Eintrag gelöscht werden.',
    true);

define('ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY',
    'Dieser Adressbucheintrag ist nicht vorhanden.');
define('ERROR_ADDRESS_BOOK_FULL',
    'Ihr Adressbuch kann keine weiteren Adressen aufnehmen. Bitte löschen Sie eine nicht mehr benötigte Adresse. Danach können Sie einen neuen Eintrag speichern.',
    true);
?>
