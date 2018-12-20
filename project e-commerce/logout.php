<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>

<meta http-equiv="refresh" content="0;login.php">
</head>
</html>
<?php

unset($_COOKIE['newcookie']);
setcookie("newcookie", "", time() - (365*24*3600));
unset($_COOKIE['cookieadmin']);
setcookie("cookieadmin", "", time() - (365*24*3600));
session_destroy();
?>