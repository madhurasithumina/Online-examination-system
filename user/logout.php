<?php
session_start();
$_SESSION = array();
session_destroy();
header("Location: /online examination system/user/login.php");
exit();
?>
