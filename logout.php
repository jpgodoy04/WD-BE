<?php
session_start();
session_unset();   // clear session data
session_destroy(); // destroy session
header('Location: login.php');
exit;
