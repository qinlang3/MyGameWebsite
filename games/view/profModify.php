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
				<h2>Modify my profile</h2>
				<?php 
					$query = "SELECT * FROM appuser WHERE userid=$1;";
					$result = pg_prepare($dbconn, "", $query);
					$result = pg_execute($dbconn, "", array($_SESSION["user"]));
					$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
				?>
				<table class="tabProfModify">
					<form action="index.php" method="post">
						<tr><th><label for="email">Username</label></th><td><?php echo($row["userid"]); ?> </td></tr>
                        <tr><th><label for="email">Email*</label></th><td><input type="email" name="email" value="<?php echo($row["email"]); ?>" required/></td></tr>
						<tr><th>&nbsp;</th><td><span class="error"> <?php if (isset($validation["email"])){echo($validation["email"]);}?></span></td></tr>
                        <tr><th><label for="gender">Gender*</label></th><td> <input type="radio" name="gender" value="male">
                        <label for="male">Male</label><br> <input type="radio" name="gender" value="female">
                        <label for="female">Female</label><br><input type="radio" name="gender" value="other">
                        <label for="other">Other</label><br> <input type="radio" name="gender" value="secret">
                        <label for="secret">I intend to keep secret</label></td></tr>
						<tr><th>&nbsp;</th><td><span class="error"> <?php if (isset($validation["gender"])){echo($validation["gender"]);}?></span></td></tr>
                        <tr><th><label for="area">Area*</label></th> <td> 
                        <select name="area">
                            <option value="North America">North America</option>
                            <option value="South America">South America</option>
                            <option value="Europe">Europe</option>
                            <option value="Asia">Asia</option>
                            <option value="Oceania">Oceania</option>
                            <option value="Africa">Africa</option>
							<option value="Other">Other</option>
                        </select></td></tr>
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

