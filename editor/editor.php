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
		<div id="topbar">
			<h1>Welcome,
				<?php
				session_start();
				if (!isset($_SESSION["username"])) {
					header("Location: /auth/login.php");
				}
				echo $_SESSION["username"]
					?>
			</h1>

			<form method="post" action="new.php">
				<input type="submit" name="newbutton" class="newbutton" value="New"/>
			</form>


			<form method="post" action="save.php">
				<input type="submit" name="savebutton" class="savebutton" value="Save" />
				<input type="hidden" name="formNoteTitle" id="formNoteTitle" placeholder="Title" />
				<input type="hidden" name="noteContent" id="noteContent" />
			</form>

			
			<form method="post" action="load.php">
				<input type="submit" name="loadbutton" class="loadbutton" value="Load" />
			</form>

			<form method="post">
				<input type="submit" name="logoutbutton" class="logoutbutton" value="Log out" />
			</form>


		</div>

		<div id="editor"></div>
		<br>
		<br>
		<br>
		<br>


		<?php
		if (array_key_exists('logoutbutton', $_POST)) {
			echo "a";
			$_SESSION["username"] = "";
			session_destroy();
			header("Location: /auth/login");
		}

		?>

		<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

		<script>
			var quill = new Quill('#editor', {
				theme: 'snow'
			});

			const toolbar = document.querySelector(".ql-toolbar")

			// new text input
			var noteTitle = document.createElement("input");
			noteTitle.setAttribute("type", "text");
			noteTitle.setAttribute("id", "noteTitle");
			noteTitle.setAttribute("placeholder", "Title");

			// add text input to toolbar
			toolbar.appendChild(noteTitle);

			noteTitle.addEventListener("input", function () {
				document.querySelector("#formNoteTitle").value = noteTitle.value;
			});


			quill.on('text-change', () => {
				const { ops } = quill.getContents();
				document.querySelector("#noteContent").value = JSON.stringify(ops);
			});


		</script>

		<?php

		//Tilkoblingsinformasjon
		$tjener = "localhost";
		$brukernavn = "root";
		$passord = "root";
		$database = "termin";

		// get note title from url
		if (!isset($_GET["note"])) {
			exit();
		}
		$noteTitle = $_GET["note"];
		$username = $_SESSION["username"];

		$kobling = new mysqli($tjener, $brukernavn, $passord, $database);

		//Sjekk om kobling virker
		if ($kobling->connect_error) {
			die("Noe gikk galt: " . $kobling->connect_error);
		}

		$kobling->set_charset("utf8");

		$sql = "SELECT content FROM notes WHERE username = '$username' AND title = '$noteTitle'";
		$resultat = $kobling->query($sql);


		if ($resultat->num_rows > 0) {
			while ($row = $resultat->fetch_assoc()) {
				$noteContent = $row["content"];
				$noteContent = base64_decode($noteContent);

				echo "<script>
				quill.setContents({
					'ops': $noteContent
				});
			</script>";
				echo "<script>document.querySelector('#noteTitle').value = '$noteTitle';</script>";
			}
		}

		?>
	</main>
</body>

</html>