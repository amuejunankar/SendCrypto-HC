<!DOCTYPE html>
<html>

<head>
	<title>User Not Logged In</title>
	<style>
		body {
			background-color: #1F1F1F;
			font-family: Arial, sans-serif;
			color: #FFFFFF;
			text-align: center;
		}

		h1 {
			font-size: 4em;
			margin-top: 3em;
		}

		p {
			font-size: 2em;
			margin-top: 1em;
			margin-bottom: 2em;
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
		}

		button:hover {
			background-color: #0052CC;
		}
	</style>
</head>

<body>
	<h1>User Not Logged In</h1>
	<p>Please log in to access this page.</p>
	<a href="./login.php">
		<button>Log In</button>
	</a>

</body>

</html>