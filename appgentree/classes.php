<?php
// Files Include that helpful to run queries and connect database
/*******************************************************************************
* File Name        : Classess.php                                                     *
* File Description : Added all the files related to connection/File Upload/Comman connection,Data table/Admin user(Teacher)/                                                                             *
* Author           : SimSam                                                              *
*******************************************************************************/
require('config/connection.php' );
require('config/database_tables.php');
include('classes/db.php');


require ('classes/file_upload.php');
require ('classes/admin_user.php');
require('config/common_functions.php');

//require ('mail/PHPMailerAutoload.php');
/**
 * Connet to database and querys.
 */
$db = new wpdb( DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, DB_SERVER );

/* Admin user */
$administrator_user = new admin_user();

?>