<?php
require_once('config/connection.php' );
require_once('config/database_tables.php');
require_once('classes/db.php');
require_once('config/common_functions.php');

/**
 * Connet to database and querys.
 */
$db = new wpdb( DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, DB_SERVER );

?>