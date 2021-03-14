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
				<li><a class="active" href="index.php?operation=guessgame">Guess Game</a></li>
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
					<h1>Guess Game</h1>
					<?php if($_SESSION["GuessGame"]->getState()!="correct"){ ?>
						<form method="post">
							<input type="text" name="guess" value="<?php echo($_REQUEST['guess']); ?>" /> <input type="submit" name="submit" value="guess" />
						</form>
					<?php } ?>
					<?php echo(view_errors($errors)); ?> 
					<?php 
						foreach($_SESSION['GuessGame']->history as $key=>$value){
							echo("<br/> $value");
						}
						if($_SESSION["GuessGame"]->getState()=="correct"){ 
					?>
							<form method="post">
								<input type="submit" name="submit" value="start again" />
							</form>
					<?php 
						} 
					?>
				</div>
				<div class="stats">
				<?php
					$user = $_SESSION["user"];
					$query = "SELECT * FROM appuser WHERE userid='$user';";
					$result = pg_prepare($dbconn, "", $query);
					$result = pg_execute($dbconn, "", array());
					$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
					$guessnum = $row["guessnum"];
					$guesswon = $row["guesswon"];
				?>
				<h2>Stats for Guess Game</h2>
				Total number of guesses: <?php echo ($guessnum); ?></br><br>
				Number of correct guesses: <?php echo ($guesswon); ?>
				</div>
			</div>
		</main>
		<footer>
			A project by Lang Qin
		</footer>
	</body>
</html>

