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
				<h1>Welcome! <?php echo($_SESSION["user"])?></h1>
				<?php 
					$query = "SELECT * FROM appuser WHERE userid=$1;";
					$result = pg_prepare($dbconn, "", $query);
					$result = pg_execute($dbconn, "", array($_SESSION["user"]));
					if(!($row = pg_fetch_array($result, NULL, PGSQL_ASSOC))){
						echo("Unable to fetch your information");
					}
				?>
				<table id="tabProf">
					<th id="tablename" colspan="2">Profile</th>
					<tr><th class="rowheader">Username:</th><td><?php echo($row["userid"]); ?></td></tr>
					<tr><th class="rowheader">Password:</th><td>******</td></tr>
					<tr><th class="rowheader">Email:</th><td><?php echo($row["email"]); ?></td></tr>
					<tr><th class="rowheader">Gender:</th><td><?php echo($row["gender"]); ?></td></tr>
					<tr><th class="rowheader">Area:</th><td><?php echo($row["area"]); ?></td></tr>
					<tr><th>&nbsp;</th><td><form action="index.php" method="post">
						<input type="submit" name="submit" value="Modify my profile"/>
						<input type="submit" name="submit" value="Modify my password"/>
					</form></td></tr>
				</table>
				</div>
				</div>
		</main>
		<footer>
			A project Lang Qin
		</footer>
	</body>
</html>

