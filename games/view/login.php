<?php
// So I don't have to deal with unset $_REQUEST['user'] when refilling the form
// You can also take a look at the new ?? operator in PHP7

$_REQUEST['user']=!empty($_REQUEST['user']) ? $_REQUEST['user'] : '';
$_REQUEST['password']=!empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="style/style.css" />
		<title>Games</title>
	</head>
	<body>
		<div class="header">
			<h1>Welcome to GAMES</h1>
		</div>
		<main>
			<div class="form">
				<h2>Login</h2>
				<form action="index.php" method="post">
					<table id="tabLogin">
						<tr><th><label for="user">Username:</label></th><td><input type="text" name="user" value="<?php echo($_REQUEST['user']); ?>" /></td></tr>
						<tr><th>&nbsp;</th><td><span class="error"> <?php if (isset($validation["login1"])){echo($validation["login1"]);}?></span></td></tr>
						<tr><th><label for="password">Password:</label></th><td> <input type="password" name="password" /></td></tr>
						<tr><th>&nbsp;</th><td><span class="error"> <?php if (isset($validation["login2"])){echo($validation["login2"]);}?></span></td></tr>
						<tr><th>&nbsp;</th><td><input type="submit" name="submit" value="login" /></td></tr><tr><th>&nbsp;</th><td></td></tr>
					</table>
				</form>
				<div id="bottom"><a href="index.php?operation=register">Register Now</a></div>
			</div>
		</main>
		<footer>
			A project by Lang Qin
		</footer>
	</body>
</html>

