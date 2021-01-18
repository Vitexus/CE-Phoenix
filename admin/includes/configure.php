<?php

// set the level of error reporting
error_reporting(E_ALL);

const HTTP_SERVER = 'http://localhost';
const COOKIE_OPTIONS = [
    'lifetime' => 0,
    'domain' => 'localhost',
    'path' => '/PureHTML/CE-Phoenix/admin',
    'samesite' => 'Lax',
];
const DIR_WS_ADMIN = '/PureHTML/CE-Phoenix/admin/';

const DIR_FS_DOCUMENT_ROOT = '/home/vitex/Projects/PureHTML/CE-Phoenix/';
const DIR_FS_ADMIN = '/home/vitex/Projects/PureHTML/CE-Phoenix/admin/';
const DIR_FS_BACKUP = DIR_FS_ADMIN . 'backups/';

const HTTP_CATALOG_SERVER = 'http://localhost';
const DIR_WS_CATALOG = '/PureHTML/CE-Phoenix/';
const DIR_FS_CATALOG = '/home/vitex/Projects/PureHTML/CE-Phoenix/';

date_default_timezone_set('Europe/Bratislava');

// If you are asked to provide configure.php details
// please remove the data below before sharing
const DB_SERVER = '192.168.2.190';
const DB_SERVER_USERNAME = 'ph1';
const DB_SERVER_PASSWORD = 'ph1';
const DB_DATABASE = 'ph1';
const DB_CONNECTION = 'mysql';
const DB_SERVER_PORT = 3306;
  