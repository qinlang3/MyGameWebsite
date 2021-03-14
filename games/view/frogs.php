<?php
	$_REQUEST['frog']=!empty($_REQUEST['frog']) ? $_REQUEST['frog'] : '';
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
				<li><a class="active" href="index.php?operation=frogs">Frogs</a></li>
				<li><a href="index.php?operation=profile">Profile</a></li>
				<li><a href="index.php?operation=logout">Logout</a></li>
				</ul>
			</nav>
		</div>
		<main>
			<div class="content">
				<div class="game">
					<h1>Frogs Puzzle</h1>
                    <div id="frogs">
                    	<div class="slot">
                        	<form class="token" method="post">
					        	<input class="<?php echo($_SESSION["Frogs"]->board[0]); ?>" type="submit" name="frog" value=1 />
				        	</form>
                    	</div>
                    	<div class="slot">
                        	<form class="token" method="post">
					        	<input class="<?php echo($_SESSION["Frogs"]->board[1]); ?>" type="submit" name="frog" value=2 />
				        	</form>
                    	</div>
                    	<div class="slot">
                        	<form class="token" method="post">
					        	<input class="<?php echo($_SESSION["Frogs"]->board[2]); ?>" type="submit" name="frog" value=3 />
				        	</form>
                    	</div>
                    	<div class="slot">
                        	<form class="token" method="post">
					        	<input class="<?php echo($_SESSION["Frogs"]->board[3]); ?>" type="submit" name="frog" value=4 />
				        	</form>
                    	</div>
                    	<div class="slot">
                        	<form class="token" method="post">
					        	<input class="<?php echo($_SESSION["Frogs"]->board[4]); ?>" type="submit" name="frog" value=5 />
				        	</form>
                    	</div>
                    	<div class="slot">
                        	<form class="token" method="post">
					        	<input class="<?php echo($_SESSION["Frogs"]->board[5]); ?>" type="submit" name="frog" value=6 />
				        	</form>
                    	</div>
                    	<div class="slot">
                        	<form class="token" method="post">
					        	<input class="<?php echo($_SESSION["Frogs"]->board[6]); ?>" type="submit" name="frog" value=7 />
				        	</form>
                    	</div>
                    	<div id="message">
                    	<?php if($_SESSION["Frogs"]->getState()=="won"){ ?>
                        	<h4> You won! Click reset to start again.</h4>
                    	<?php } ?>
                    	<?php if($_SESSION["Frogs"]->getState()=="stuck"){ ?>
                        	<h4> Seems like you are stuck, click reset to try again.</h4>
                    	<?php } ?>
                    	<?php if($_SESSION["Frogs"]->getState()=="play"){ ?>
                        	<br/>
                    	<?php } ?>
                    	<?php echo("Moves: ")?> <?php echo $_SESSION["Frogs"]->moves ?>
                    	<br/><br/>
                    	<form method="post">
					    	<input type="submit" name="submit" value="Reset" />
				    	</form>
                    	</div>
					</div>
				</div>
				<div class="stats">
					<?php
						$user = $_SESSION["user"];
						$query = "SELECT * FROM appuser WHERE userid='$user';";
						$result = pg_prepare($dbconn, "", $query);
						$result = pg_execute($dbconn, "", array());
						$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
						$frogsnum = $row["frogsnum"];
						$frogswon = $row["frogswon"];
					?>
					<h2>Stats for Frogs</h2>
					Total number of games: <?php echo ($frogsnum); ?><br></br>
					Number of games you won: <?php echo ($frogswon); ?>
				</div>
			</div>
		</main>
		<footer>
			A project by Lang Qin
		</footer>
	</body>
</html>

