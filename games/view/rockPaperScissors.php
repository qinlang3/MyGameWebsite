<?php
	$_REQUEST['guess']=!empty($_REQUEST['guess']) ? $_REQUEST['guess'] : '';
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
				<li><a class="active" href="index.php?operation=rockpaperscissors">Rock Paper Scissors</a></li>
				<li><a href="index.php?operation=frogs">Frogs</a></li>
				<li><a href="index.php?operation=profile">Profile</a></li>
				<li><a href="index.php?operation=logout">Logout</a></li>
				</ul>
			</nav>
		</div>
		<main>
			<div class="content">
				<div class="game">
				<h1>Rock Paper Scissors</h1>
				<h3>Please make a choice.</h3>
				<form method="post">
					<input type="submit" name="guess" value="rock" /> <input type="submit" name="guess" value="paper" /> <input type="submit" name="guess" value="scissors" />
				</form>
				<?php echo("<br/>Your score: ")?> <?php echo $_SESSION['RockPaperScissors']->score ?>
				<?php echo("<br/>Computer's score: ")?> <?php echo $_SESSION['RockPaperScissors']->computerScore ?>
				<br/><br/>
				<?php echo $_SESSION['RockPaperScissors']->result ?>
				<br/>
				<br/>
				<form method="post">
					<input type="submit" name="submit" value="Restart" />
				</form>
				</div>
				<div class="stats">
				<?php
					$user = $_SESSION["user"];
					$query = "SELECT * FROM appuser WHERE userid='$user';";
					$result = pg_prepare($dbconn, "", $query);
					$result = pg_execute($dbconn, "", array());
					$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
					$rpsplayer = $row["rpsplayer"];
					$rpscomp = $row["rpscomp"];
				?>
				<h2>Stats for Rock Paper Scissors</h2>
				Your total score: <?php echo ($rpsplayer); ?></br><br>
				Computer's total score: <?php echo ($rpscomp); ?>
				</div>
			</div>
		</main>
		<footer>
			A project by Lang Qin
		</footer>
	</body>
</html>

