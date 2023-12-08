<?php


//Tilkoblingsinformasjon
$tjener = "localhost";
$brukernavn = "root";
$passord = "root";
$database = "termin";

if (isset($_POST["savebutton"])) {
	session_start();
	$username = $_SESSION["username"];
	$noteTitle = $_POST["formNoteTitle"];
	$noteContent = $_POST["noteContent"];

	$noteContent = base64_encode($noteContent);

	$kobling = new mysqli($tjener, $brukernavn, $passord, $database);

	//Sjekk om kobling virker
	if ($kobling->connect_error) {
		die("Noe gikk galt: " . $kobling->connect_error);
	}

	$kobling->set_charset("utf8");

	$sql = "INSERT INTO notes (username, title, content) VALUES ('$username', '$noteTitle', '$noteContent')";

	if ($kobling->query($sql)) {
		echo "<script>message('Note saved');</script>";
	} else {
		echo "Noe gikk galt med spørringen $sql ($kobling->error).";
	}

	$kobling->close();

	header("Location: /editor/editor?note=$noteTitle");
}
?>