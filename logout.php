<?php
setcookie('user_data', "", time() - (86400 * 30), "/"); // unsset cockie
session_start();
session_destroy();
header('Location: index.php');
exit();
