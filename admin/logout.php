<?php

 // Start the session
require_once("./inc/header.php");
// Destroy the session
 // Remove all session variables
session_destroy(); // Destroy the session

// Optionally, you can unset cookies related to the session
// if (ini_get("session.use_cookies")) {
//     $params = session_get_cookie_params();
//     setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
// }




?>
<script>location.assign("../index.php")</script>
