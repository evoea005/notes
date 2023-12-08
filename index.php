<?php

session_start();

if (!isset($_SESSION["username"])) {
	header("Location: /auth/login.php");
} else {
	header("Location: /editor/editor.php");
}

?>