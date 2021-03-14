<?php
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
		<div class="header2">
			<h1>GAMES</h1>
		</div>
		<div class="nav">
			<nav>
				<ul>
				<li><a href="index.php?operation=allstats">All Stats</a></li>
				<li><a href="index.php?operation=guessgame">Guess Game</a></li>
				<li><a href="index.php?operation=rockpaperscissors">Rock Paper Scissors</a></li>
				<li><a href="index.php?operation=frogs">Frogs</a></li>
				<li><a class="active" href="index.php?operation=profile">Profile</a></li>
				<li><a href="index.php?operation=logout">Logout</a></li>
				</ul>
			</nav>
		</div>
		<main>
			<div class="content">
				<div class="profile">
				<h2>Modify my password</h2>
				<?php 
					$query = "SELECT * FROM appuser WHERE userid=$1;";
					$result = pg_prepare($dbconn, "", $query);
					$result = pg_execute($dbconn, "", array($_SESSION["user"]));
					$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
				?>
				<table class="tabProfModify">
					<form action="index.php" method="post">
						<tr><th><label for="password">Old Password*</label></th><td> <input type="password" name="password0" required/></td></tr>
						<tr><th>&nbsp;</th><td><span class="error"> <?php if (isset($validation["pwd0"])){echo($validation["pwd0"]);}?></span></td></tr>
                        <tr><th><label for="password">New Password*</label></th><td> <input type="password" name="password1" required/></td></tr>
						<tr><th>&nbsp;</th><td><span class="error"> <?php if (isset($validation["pwd1"])){echo($validation["pwd1"]);}?></span></td></tr>
                        <tr><th><label for="password">Confirm new Password*</label></th><td> <input type="password" name="password2" required/></td></tr>
						<tr><th>&nbsp;</th><td><span class="error"> <?php if (isset($validation["pwd2"])){echo($validation["pwd2"]);}?></span></td></tr>
						<tr><th>&nbsp;</th><td><input type="submit" name="submit" value="Modify"/></form>
						<form action="index.php" method="post"><input type="submit" name="submit" value="Cancel"/></form></td></tr>
						<tr><th>&nbsp;</th><td><?php echo(view_errors($errors)); ?></td></tr>
				</table>
				</div>
			</div>
		</main>
		<footer>
			A project by Lang Qin
		</footer>
	</body>
</html>

