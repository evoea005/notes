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
		<h1>Welcome,



		<?php
		session_start();
		if (!isset($_SESSION["username"])) {
			header("Location: /auth/login");
		}
		echo $_SESSION["username"]
			?>
		</h1>

		<div id="editor"></div>
		<br>
		<br>
		<br>
		<br>
		<form method="post">
			<input type="submit" name="logoutbutton" class="logoutbutton" value="log out" />
		</form>

		<?php
		if (array_key_exists('logoutbutton', $_POST)) {
			echo "a";
			$_SESSION["username"] = "";
			session_destroy();
			header("Location: /auth/login");
		}

		?>

		<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

		<!-- Initialize Quill editor -->
		<script>
			var quill = new Quill('#editor', {
				theme: 'snow'
			});
		</script>
	</main>
</body>

</html>