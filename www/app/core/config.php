<?php

//database name
define('DB_file', "app/core/Database.db");
define('DB_TYPE', "sqlite");

define('BASE_URL', "");


ini_set('date.timezone', 'Asia/Colombo');
date_default_timezone_set('Asia/Colombo');


define('DEBUG', true);
if (DEBUG) {
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}
