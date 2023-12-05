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
		<script>
			function message(text) {
				document.querySelector("#info").innerHTML = text;
			}
		</script>

		<form method="post">
			<h1>log in</h1>
			<div>
				<label for="username">username:</label>
				<input type="text" name="username" id="username">
			</div>
			<div>
				<label for="password">password:</label>
				<input type="password" name="password" id="password">
			</div>
			<button type="submit" name="submit">log in</button>
			<footer>no account? <a href=" ./register">register here</a></footer>

			<p id="info"></p>
		</form>



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
				echo "<script>message('username can only contain letters and numbers');</script>";
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
					echo "<script>message('invalid login');</script>";
					exit();
				}


		}
		?>
	</main>
</body>

</html>