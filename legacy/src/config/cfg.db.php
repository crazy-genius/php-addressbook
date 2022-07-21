<?php

global $db, $dbname, $dbuser, $dbserver; // declare as global to be used in include files
// Database access definition
$dbserver = "db:3306"; // your database hostname
$dbname = "addressbook";      // your database name
$dbuser = "addressbook_user";      // your database username
$dbpass = "addressbook_user_password";          // your database password

// You may use a table-prefix if you have only one DB-User
$table_prefix = "";

// Keep a history of all changes, incl. deletion. Used for intelligent merge.
$keep_history = true;
