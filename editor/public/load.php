<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
	<title>editor</title>
</head>

<body>
	<main>
		<div id="saved">
			<?php

			session_start();
			if (!isset($_SESSION["username"])) {
				header("Location: /auth/login");
			}

			$username = $_SESSION["username"];

			//Tilkoblingsinformasjon
			$tjener = "localhost";
			$brukernavn = "root";
			$passord = "root";
			$database = "termin";

			//Opprette en kobling
			$kobling = new mysqli($tjener, $brukernavn, $passord, $database);

			//Sjekk om koblingen virker
			if ($kobling->connect_error) {
				die("Noe gikk galt: " . $kobling->connect_error);
			} else {
				//echo "Koblingen virker.<br>";
			}

			$kobling->set_charset("utf8");

			$sql = "SELECT * FROM notes where username = '$username'";
			$resultat = $kobling->query($sql);

			if ($resultat->num_rows > 0) {
				while ($rad = $resultat->fetch_assoc()) {
					$title = $rad["title"];

					echo "<div class='savedNote'>";
					echo "<a href='/editor/editor?note=$title'>$title</h1>";
					echo "</div>";
				}
			} else {
				echo "No notes saved";
			}

			?>

		</div>





	</main>
</body>

</html>