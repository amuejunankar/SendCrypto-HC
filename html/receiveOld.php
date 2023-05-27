<?php
session_start();

?>

<!DOCTYPE html>
<html>

<head>
	<title>User Not Logged In</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="../styles/navbar.css">

	<style>
		.content {
			text-align: center;
		}

		body {
			background-color: #1F1F1F;
			font-family: 'segoe ui';
			color: #FFFFFF;

		}

		h1 {
			font-size: 4em;
			margin-top: 3em;
			text-align: center;
		}

		p {
			font-size: 2em;
			margin-top: 1em;
			margin-bottom: 2em;
			text-align: center;
		}

		button {
			font-size: 1.5em;
			padding: 0.5em 2em;
			background-color: #0066FF;
			color: #FFFFFF;
			border: none;
			border-radius: 2em;
			cursor: pointer;
			transition: background-color 0.3s ease;
			text-align: center;

		}

		button:hover {
			background-color: #0052CC;
		}
	</style>
</head>

<body>


	<div class="nav">
		<input type="checkbox" id="nav-check">
		<div class="nav-header">
			<div class="nav-title">
				SendCrypto
			</div>
		</div>
		<div class="nav-btn">
			<label for="nav-check">
				<span></span>
				<span></span>
				<span></span>
			</label>
		</div>

		<div class="nav-links">
			<a href="../index.php">Home</a>
			<?php
			echo '<a href="./sendOld.php">Send</a>';
			?>
			<a href="<?php
						echo './receiveOld.php';
						?>">Receive</a>
			<?php
			echo '<a href="./login.php">Login</a>';
			?>
		</div>


	</div>


	<div class="content">
		<h1>User Not Logged In</h1>
		<p>Please log in to access this page.</p>
		<a href="./login.php">
			<button>Log In</button>
		</a>
	</div>

</body>

</html>