<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<title>Register</title>
</head>

<body>
	<main>
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

		<form method="post">
			<h1>Sign up</h1>
			<div>
				<label for="username">Username:</label>
				<input type="text" name="username" id="username">
			</div>
			<div>
				<label for="password">Password:</label>
				<input type="password" name="password" id="password">
			</div>
			<div>
				<label for="agree">
					<input type="checkbox" name="agree" id="agree" value="yes" /> I agree
					with the
					<a href="./terms.php" title="term of services">Terms of Service</a>
				</label>
			</div>
			<button type="submit" name="submit">Register</button>
			<footer>Already have an account? <a href=" ./login.php">Login here</a></footer>

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
			$password_form = $_POST["password"];

			if (strlen($username_form) < 4) {
				echo "<script>message('username must be at least 4 characters long');</script>";
			} elseif (strlen($password_form) < 6) {
				echo "<script>message('password must be at least 6 characters long');</script>";
			} else {
				// check if username is only letters and numbers
				if (!ctype_alnum($username_form)) {
					echo "<script>message('username can only contain letters and numbers');</script>";
					exit();
				}

				$kobling = new mysqli($tjener, $brukernavn, $passord, $database);

				// check if connection works
				if ($kobling->connect_error) {
					die("Noe gikk galt: " . $kobling->connect_error);
				}

				$kobling->set_charset("utf8");

				$username_form = $_POST["username"];
				$password_form = hash('sha256', $_POST["password"]);

				// check if username already exists
				$sql = "SELECT * FROM user WHERE username = '$username_form'";

				$resultat = $kobling->query($sql);
				if ($resultat->num_rows > 0) {
					echo "<script>message('username already exists');</script>";
					exit();
				} else {


					$sql = "INSERT INTO user (username, password) VALUES ('$username_form', '$password_form')";

					if ($kobling->query($sql)) {
						header("Location: ./login.php");
					} else {
						echo "Noe gikk galt med spørringen $sql ($kobling->error).";
					}
				}

			}
		}
		?>
	</main>
</body>

</html>

<script>
	function message(text) {
		document.querySelector("#p").innerHTML = text;
	}

	document.querySelector("button").onclick = function (e) {
		if (!document.getElementById('agree').checked) {
			alert("no");
			e.preventDefault();
			e.stopPropagation();
		}

	}
</script>