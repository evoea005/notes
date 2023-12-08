<?php

session_start();

if (!isset($_SESSION["username"])) {
	header("Location: /auth/login");
} else {
	header("Location: /editor/editor");
}

?>