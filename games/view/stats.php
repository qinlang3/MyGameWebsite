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
				<li><a class="active" href="index.php?operation=allstats">All Stats</a></li>
				<li><a href="index.php?operation=guessgame">Guess Game</a></li>
				<li><a href="index.php?operation=rockpaperscissors">Rock Paper Scissors</a></li>
				<li><a href="index.php?operation=frogs">Frogs</a></li>
				<li><a href="index.php?operation=profile">Profile</a></li>
				<li><a href="index.php?operation=logout">Logout</a></li>
				</ul>
			</nav>
		</div>
		<main>
			<div class="content">
				<div class="game">
				<?php
					$user = $_SESSION["user"];
					$query = "SELECT * FROM appuser WHERE userid='$user';";
					$result = pg_prepare($dbconn, "", $query);
					$result = pg_execute($dbconn, "", array());
					$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
					$guessnum = $row["guessnum"];
					$guesswon = $row["guesswon"];
					$rpsplayer = $row["rpsplayer"];
					$rpscomp = $row["rpscomp"];
					$frogsnum = $row["frogsnum"];
					$frogswon = $row["frogswon"];
				?>
				<h1>Stats By Game</h1>
				<h3>Guess Game:</h3>
				Total number of guesses: <?php echo ($guessnum); ?></br><br>
				Number of correct guesses: <?php echo ($guesswon); ?>
				<h3>Rock Paper Scissors:</h3>
				Your total score: <?php echo ($rpsplayer); ?></br><br>
				Computer's total score: <?php echo ($rpscomp); ?>
				<h3>Frogs:</h3>
				Total number of games: <?php echo ($frogsnum); ?><br></br>
				Number of games you won: <?php echo ($frogswon); ?>
				</div>
				<div class="stats">
				    <h2>Summary Stats</h2>
				    <h3>Games have played:</h3>	
					<?php if($guessnum!=0){echo"Guess Game</br><br>";}?>
					<?php if($rpsplayer!=0||$rpscomp!=0){echo"Rock Paper Scissors</br><br>";}?>
					<?php if($frogsnum!=0){echo"Frogs</br><br>";}?>
					<h3>Games have not played:</h3>
					<?php if($guessnum==0){echo"Guess Game</br><br>";}?>
					<?php if($rpsplayer==0&&$rpscomp==0){echo"Rock Paper Scissors</br><br>";}?>
					<?php if($frogsnum==0){echo"Frogs</br><br>";}?>
				</div>
			</div>
		</main>
		<footer>
			A project by Lang Qin
		</footer>
	</body>
</html>

