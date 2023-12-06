<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<title>Log in</title>
</head>

<body>
	<main>
		<form method="post">
			<h1>Log in</h1>
			<div>
				<label for="username">Username:</label>
				<input type="text" name="username" id="username">
			</div>
			<div>
				<label for="password">Password:</label>
				<input type="password" name="password" id="password">
			</div>
			<button type="submit" name="submit">Log in</button>
			<footer>No account? <a href=" ./register">Register here</a></footer>

			<p id="info"></p>
		</form>

		<script>
			document.querySelector("#info").addEventListener("click", function() {
				document.querySelector("#info").innerHTML = "";
				document.querySelector("#info").style.display = "none";
			});

			function message(text) {
				document.querySelector("#info").innerHTML = text;
				document.querySelector("#info").style.display = "block";
			}
		</script>


		<?php


		//Tilkoblingsinformasjon
		$tjener = "localhost";
		$brukernavn = "root";
		$passord = "root";
		$database = "termin";



		if (isset($_POST["submit"])) {
			$username_form = $_POST["username"];
			$password_form = hash("sha256", $_POST["password"]);


			if (!ctype_alnum($username_form)) {
				echo "<script>message('Invalid username!');</script>";
				exit();
			}


			$kobling = new mysqli($tjener, $brukernavn, $passord, $database);

			//Sjekk om kobling virker
			if ($kobling->connect_error) {
				die("Noe gikk galt: " . $kobling->connect_error);
			}

			//Angi UTF-8 som tegnsett
			$kobling->set_charset("utf8");


			// check if user exists
			$sql = "SELECT * FROM user WHERE username = '$username_form' AND password = '$password_form'";

			$resultat = $kobling->query($sql);
			if ($resultat->num_rows == 1) {
				// login
				session_start();
				$_SESSION["username"] = $username_form;
				header("Location: /editor/editor");
				exit();
			} else {
				echo "<script>message('Wrong username or password!');</script>";
				exit();
			}


		}
		?>
	</main>
</body>

</html>