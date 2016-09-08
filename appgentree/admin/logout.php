<?
require ("../classes.php");
session_start();
session_destroy();
if(isset($_GET['passwordreset']))
{
  redirct("password-reset-msg.php");
}else
{
  redirct("index.php");
}
?>