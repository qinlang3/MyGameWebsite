<?php
	ini_set('display_errors', 'On');
	require_once "lib/lib.php";
	require_once "model/GuessGame.php";
	require_once "model/RockPaperScissors.php";
	require_once "model/Frogs.php";
	session_save_path("sess");
	session_start(); 

	$dbconn = db_connect();

	$errors=array();
	$validation=array();
	$view="";

	/* controller code */
	/* local actions, these are state transforms */
	if(!isset($_SESSION["state"])){
		$_SESSION["state"]="login";
	}
	switch($_SESSION['state']){
		case "login":
			// the view we display by default
			$view="login.php";
			if(!empty($_GET["operation"])&&$_GET["operation"]=="register"){
				$_SESSION["state"]="register";
				$view="register.php";
				break;
			}
			// check if submit or not
			if(empty($_REQUEST["submit"]) || $_REQUEST["submit"]!="login"){
				break;
			}
			// validate and set errors
			if(empty($_REQUEST["user"])){
				$validation["login1"]="Username is required";
				break;
			}
			if(empty($_REQUEST["password"])){
				$validation["login2"]="Password is required";
				break;
			}
			// perform operation, switching state and view if necessary
			if(!$dbconn){
				$errors[]="Failed to establish connection to server database";
				break;
			}
			$query = "SELECT * FROM appuser WHERE userid=$1 and password=$2;";
            $result = pg_prepare($dbconn, "", $query);
            $result = pg_execute($dbconn, "", array($_REQUEST['user'], $_REQUEST['password']));
            if($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
				$_SESSION["user"]=$_REQUEST["user"];
				$_SESSION["state"]="stats";
				$view="stats.php";
			} else {
				$validation["login1"]="Invalid Username or Password";
			}
			break;
		case "register":
			$view="register.php";
			if(!empty($_REQUEST["submit"])&&$_REQUEST["submit"]=="Cancel"){
				$_SESSION["state"]="login";
				$view="login.php";
				break;
			}
			if(empty($_REQUEST["submit"]) || $_REQUEST["submit"]!="Register"){
				break;
			}
			// username validation
			if(empty($_REQUEST["username"]) || strlen($_REQUEST["username"])<5 || strlen($_REQUEST["username"])>20){
				$validation["name"]="Username length must between 5 and 20 characters";
				break;
			}
			if(!$dbconn){
				$errors[]="Failed to establish connection to server database";
				break;
			}
			$query = "SELECT * FROM appuser WHERE userid=$1;";
            $result = pg_prepare($dbconn, "", $query);
            $result = pg_execute($dbconn, "", array($_REQUEST["username"]));
            if($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
				$validation["name"]="Username already exists, please try another one";
				break;
			}
			// email validation
			if(empty($_REQUEST["email"])){
				$validation["email"]="Email address can not be empty";
				break;
			}
			if(strlen($_REQUEST["email"])>50){
				$validation["email"]="Email address too long";
				break;
			}
			$query = "SELECT * FROM appuser WHERE email=$1;";
			$result = pg_prepare($dbconn, "", $query);
            $result = pg_execute($dbconn, "", array($_REQUEST["email"]));
			if($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
				$validation["email"]="Email address already used, please use another one";
				break;
			}
			// password validation
			if(empty($_REQUEST["password1"]) || strlen($_REQUEST["password1"])<5 || strlen($_REQUEST["password1"])>20){
				$validation["pwd1"]="Password length must between 5 and 20 characters";
				break;
			}
			if($_REQUEST["password1"]!=$_REQUEST["password2"]) {
				$validation["pwd2"]="Passwords entered don't match";
				break;
			}
			if(empty($_REQUEST["gender"])){
				$validation["gender"]="Please select your gender";
				break;
			}
			$username = $_REQUEST["username"];
			$password1 = $_REQUEST["password1"];
			$email = $_REQUEST["email"];
			$gender = $_REQUEST["gender"];
			$area = $_REQUEST["area"];
			$query = "INSERT INTO appuser (userid, password, email, gender, area, guessnum, guesswon, rpsplayer, rpscomp, frogsnum, frogswon) 
					  VALUES ('$username', '$password1', '$email', '$gender', '$area', 0, 0, 0, 0, 0, 0);";
			pg_query($dbconn, $query);
			$_SESSION["state"]="login";
			$view="login.php";
			break;
		case "stats":
			$view="stats.php";
			if(!empty($_GET['operation'])){
				if($_GET['operation']=="allstats"){
					$_SESSION['state']='stats';
					$view="stats.php";
				}
				if($_GET['operation']=="guessgame"){
					$_SESSION['GuessGame']=new GuessGame();
					$_SESSION['state']='guessGameplay';
					$view="guessGameplay.php";
				}
				if($_GET['operation']=="rockpaperscissors"){
					$_SESSION['RockPaperScissors']=new RockPaperScissors();
					$_SESSION['state']='rockPaperScissors';
					$view="rockPaperScissors.php";
				}
				if($_GET['operation']=="frogs"){
					$_SESSION['Frogs']=new Frogs();
					$_SESSION['state']='frogs';
					$view="frogs.php";	
				}
				if($_GET['operation']=="profile"){
					$_SESSION['state']='profile';
					$view="profile.php";	
				}
				if($_GET['operation']=="logout"){
					$_SESSION['state']='login';
					unset($_SESSION["user"]);
					$view="login.php";
				}
				break;
			}
			break;
		case "guessGameplay":
			$view="guessGameplay.php";
			if(!empty($_GET['operation'])&&$_GET['operation']!="guessgame"){
				if($_GET['operation']=="allstats"){
					$_SESSION['state']='stats';
					$view="stats.php";
				}
				if($_GET['operation']=="rockpaperscissors"){
					$_SESSION['RockPaperScissors']=new RockPaperScissors();
					$_SESSION['state']='rockPaperScissors';
					$view="rockPaperScissors.php";
				}
				if($_GET['operation']=="frogs"){
					$_SESSION['Frogs']=new Frogs();
					$_SESSION['state']='frogs';
					$view="frogs.php";	
				}
				if($_GET['operation']=="profile"){
					$_SESSION['state']='profile';
					$view="profile.php";	
				}
				if($_GET['operation']=="logout"){
					$_SESSION['state']='login';
					unset($_SESSION["user"]);
					$view="login.php";
				}
				break;
			}
			// check if submit or not
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="guess"){
				break;
			}
			// validate and set errors
			if(!is_numeric($_REQUEST["guess"]))$errors[]="Guess must be numeric.";
			if(!empty($errors))break;
			// perform operation, switching state and view if necessary
			$_SESSION["GuessGame"]->makeGuess($_REQUEST['guess']);
			$user = $_SESSION["user"];
			$query = "SELECT * FROM appuser WHERE userid='$user';";
			$result = pg_prepare($dbconn, "", $query);
			$result = pg_execute($dbconn, "", array());
			$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
			$row["guessnum"]+=1;
			$guessnum = $row["guessnum"];
			$guesswon = $row["guesswon"];
			if($_SESSION["GuessGame"]->getState()=="correct"){
				$guesswon += 1;
				$query = "UPDATE appuser SET guessnum='$guessnum', guesswon='$guesswon'
					  WHERE userid='$user';";
				pg_query($dbconn, $query);
				$_SESSION['state']="guessGamewon";
				$view="guessGamewon.php";
			}else {
				$query = "UPDATE appuser SET guessnum='$guessnum', guesswon='$guesswon'
					  	WHERE userid='$user';";
				pg_query($dbconn, $query);
			}
			$_REQUEST['guess']="";
			break;
		case "guessGamewon":
			// the view we display by default
			$view="guessGameplay.php";
			if(!empty($_GET['operation'])&&$_GET['operation']!="guessgame"){
				if($_GET['operation']=="allstats"){
					$_SESSION['state']='stats';
					$view="stats.php";
				}
				if($_GET['operation']=="rockpaperscissors"){
					$_SESSION['RockPaperScissors']=new RockPaperScissors();
					$_SESSION['state']='rockPaperScissors';
					$view="rockPaperScissors.php";
				}
				if($_GET['operation']=="frogs"){
					$_SESSION['Frogs']=new Frogs();
					$_SESSION['state']='frogs';
					$view="frogs.php";	
				}
				if($_GET['operation']=="profile"){
					$_SESSION['state']='profile';
					$view="profile.php";	
				}
				if($_GET['operation']=="logout"){
					$_SESSION['state']='login';
					unset($_SESSION["user"]);
					$view="login.php";
				}
				break;
			}
			// check if submit or not
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="start again"){
				$view="guessGamewon.php";
				break;
			}
			// validate and set errors
			if(!empty($errors))break;
	
			// perform operation, switching state and view if necessary
			$_SESSION["GuessGame"]=new GuessGame();
			$_SESSION['state']="guessGameplay";
			$view="guessGameplay.php";
			break;
		case "rockPaperScissors":
			$view="rockPaperScissors.php";
			if(!empty($_GET['operation'])&&$_GET['operation']!="rockpaperscissors"){
				if($_GET['operation']=="allstats"){
					$_SESSION['state']='stats';
					$view="stats.php";
				}
				if($_GET['operation']=="guessgame"){
					$_SESSION["GuessGame"]=new GuessGame();
					$_SESSION['state']='guessGameplay';
					$view="guessGameplay.php";
				}
				if($_GET['operation']=="frogs"){
					$_SESSION['Frogs']=new Frogs();
					$_SESSION['state']='frogs';
					$view="frogs.php";	
				}
				if($_GET['operation']=="profile"){
					$_SESSION['state']='profile';
					$view="profile.php";	
				}
				if($_GET['operation']=="logout"){
					$_SESSION['state']='login';
					unset($_SESSION["user"]);
					$view="login.php";
				}
				break;
			}
			if(!empty($_REQUEST['submit'])&&$_REQUEST['submit']=="Restart"){
				$_SESSION['RockPaperScissors']=new RockPaperScissors();
				$_SESSION['state']='rockPaperScissors';
				$view="rockPaperScissors.php";
				break;
			}
			// check if submit or not
			if(empty($_REQUEST['guess'])||($_REQUEST['guess']!="rock"&&$_REQUEST['guess']!="paper"&&$_REQUEST['guess']!="scissors")){
				break;
			}
			// validate and set errors
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			$_SESSION["RockPaperScissors"]->play($_REQUEST['guess']);
			$user = $_SESSION["user"];
			$query = "SELECT * FROM appuser WHERE userid='$user';";
			$result = pg_prepare($dbconn, "", $query);
			$result = pg_execute($dbconn, "", array());
			$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
			$rpsplayer = $row["rpsplayer"];
			$rpscomp = $row["rpscomp"];
			if($_SESSION["RockPaperScissors"]->getState()=="you won!"){
				$rpsplayer++;
			}
			if($_SESSION["RockPaperScissors"]->getState()=="you lost!"){
				$rpscomp++;
			}
			$query = "UPDATE appuser SET rpsplayer='$rpsplayer', rpscomp='$rpscomp'
					  	 WHERE userid='$user';";
			pg_query($dbconn, $query);
			$_REQUEST['guess']="";
			break;
		case "frogs":
			$view="frogs.php";
			if(!empty($_GET['operation'])&&$_GET['operation']!="frogs"){
				if($_GET['operation']=="allstats"){
					$_SESSION['state']='stats';
					$view="stats.php";
				}
				if($_GET['operation']=="guessgame"){
					$_SESSION["GuessGame"]=new GuessGame();
					$_SESSION['state']='guessGameplay';
					$view="guessGameplay.php";
				}
				if($_GET['operation']=="rockpaperscissors"){
					$_SESSION['RockPaperScissors']=new RockPaperScissors();
					$_SESSION['state']='rockPaperScissors';
					$view="rockPaperScissors.php";
				}
				if($_GET['operation']=="profile"){
					$_SESSION['state']='profile';
					$view="profile.php";	
				}
				if($_GET['operation']=="logout"){
					$_SESSION['state']='login';
					unset($_SESSION["user"]);
					$view="login.php";
				}
				break;
			}
			if(!empty($_REQUEST['submit'])&&$_REQUEST['submit']=="Reset"){
				$_SESSION['Frogs']=new Frogs();
				$_SESSION['state']='frogs';
				$view="frogs.php";
				break;
			}
			// check if submit or not
			if(empty($_REQUEST['frog'])){
				break;
			}
			if(!empty($errors))break;
			// perform operation, switching state and view if necessary
			$_SESSION["Frogs"]->play($_REQUEST['frog']);
			if($_SESSION["Frogs"]->getState()=="won"||$_SESSION["Frogs"]->getState()=="stuck"){
				$user = $_SESSION["user"];
				$query = "SELECT * FROM appuser WHERE userid='$user';";
				$result = pg_prepare($dbconn, "", $query);
				$result = pg_execute($dbconn, "", array());
				$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
				$row["frogsnum"]+=1;
				if($_SESSION["Frogs"]->getState()=="won"){
					$row["frogswon"]+=1;
				}
				$frogsnum = $row["frogsnum"];
				$frogswon = $row["frogswon"];
				$query = "UPDATE appuser SET frogsnum='$frogsnum', frogswon='$frogswon'
					  	 WHERE userid='$user';";
				pg_query($dbconn, $query);
				$_SESSION['state']="frogsend";
				$view="frogs.php";
			}
			break;
		case "frogsend":
			$view="frogs.php";
			if(!empty($_GET['operation'])&&$_GET['operation']!="frogs"){
				if($_GET['operation']=="allstats"){
					$_SESSION['state']='stats';
					$view="stats.php";
				}
				if($_GET['operation']=="guessgame"){
					$_SESSION["GuessGame"]=new GuessGame();
					$_SESSION['state']='guessGameplay';
					$view="guessGameplay.php";
				}
				if($_GET['operation']=="rockpaperscissors"){
					$_SESSION['RockPaperScissors']=new RockPaperScissors();
					$_SESSION['state']='rockPaperScissors';
					$view="rockPaperScissors.php";
				}
				if($_GET['operation']=="profile"){
					$_SESSION['state']='profile';
					$view="profile.php";	
				}
				if($_GET['operation']=="logout"){
					$_SESSION['state']='login';
					unset($_SESSION["user"]);
					$view="login.php";
				}
				break;
			}
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="Reset"){
				break;
			}
			$_SESSION['Frogs']=new Frogs();
			$_SESSION['state']='frogs';
			$view="frogs.php";
			break;
		case "profile":
			$view="profile.php";
			if(!empty($_GET['operation'])&&$_GET['operation']!="profile"){
				if($_GET['operation']=="allstats"){
					$_SESSION['state']='stats';
					$view="stats.php";
				}
				if($_GET['operation']=="guessgame"){
					$_SESSION["GuessGame"]=new GuessGame();
					$_SESSION['state']='guessGameplay';
					$view="guessGameplay.php";
				}
				if($_GET['operation']=="rockpaperscissors"){
					$_SESSION['RockPaperScissors']=new RockPaperScissors();
					$_SESSION['state']='rockPaperScissors';
					$view="rockPaperScissors.php";
				}
				if($_GET['operation']=="frogs"){
					$_SESSION['Frogs']=new Frogs();
					$_SESSION['state']='frogs';
					$view="frogs.php";	
				}
				if($_GET['operation']=="logout"){
					$_SESSION['state']='login';
					unset($_SESSION["user"]);
					$view="login.php";
				}
				break;
			}
			if(!empty($_REQUEST["submit"])&&$_REQUEST["submit"]=="Modify my profile"){
				$_SESSION["state"]="profModify";
				$view="profModify.php";
				break;
			}
			if(!empty($_REQUEST["submit"])&&$_REQUEST["submit"]=="Modify my password"){
				$_SESSION["state"]="pwdModify";
				$view="pwdModify.php";
				break;
			}
			break;
		case "profModify":
			$view="profModify.php";
			if(!empty($_REQUEST["submit"])&&$_REQUEST["submit"]=="Cancel"){
				$_SESSION["state"]="profile";
				$view="profile.php";
				break;
			}
			if(!empty($_GET['operation'])&&$_GET['operation']!="profile"){
				if($_GET['operation']=="allstats"){
					$_SESSION['state']='stats';
					$view="stats.php";
				}
				if($_GET['operation']=="guessgame"){
					$_SESSION["GuessGame"]=new GuessGame();
					$_SESSION['state']='guessGameplay';
					$view="guessGameplay.php";
				}
				if($_GET['operation']=="rockpaperscissors"){
					$_SESSION['RockPaperScissors']=new RockPaperScissors();
					$_SESSION['state']='rockPaperScissors';
					$view="rockPaperScissors.php";
				}
				if($_GET['operation']=="frogs"){
					$_SESSION['Frogs']=new Frogs();
					$_SESSION['state']='frogs';
					$view="frogs.php";	
				}
				if($_GET['operation']=="logout"){
					$_SESSION['state']='login';
					unset($_SESSION["user"]);
					$view="login.php";
				}
				break;
			}
			if(empty($_REQUEST["submit"]) || $_REQUEST["submit"]!="Modify"){
				break;
			}
			// email validation
			if(empty($_REQUEST["email"])){
				$validation["email"]="Email address can not be empty";
				break;
			}
			if(strlen($_REQUEST["email"])>50){
				$validation["email"]="Email address too long";
				break;
			}
			$user = $_SESSION["user"];
			$query = "SELECT * FROM appuser WHERE userid='$user';";
			$result = pg_prepare($dbconn, "", $query);
			$result = pg_execute($dbconn, "", array());
			$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
			$email = $row["email"];
			$query = "SELECT * FROM appuser WHERE email=$1;";
			$result = pg_prepare($dbconn, "", $query);
            $result = pg_execute($dbconn, "", array($_REQUEST["email"]));
			if($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
				if($row["email"]!=$email){
					$validation["email"]="Email address already used, please use another one";
					break;
				}
			}
			if(empty($_REQUEST["gender"])){
				$validation["gender"]="Please select your gender";
				break;
			}
			$email = $_REQUEST["email"];
			$gender = $_REQUEST["gender"];
			$area = $_REQUEST["area"];
			$query = "UPDATE appuser SET email='$email', gender='$gender', area='$area'
					  WHERE userid='$user';";
  			if ($result = pg_query($dbconn, $query)) {
	  			$_SESSION["state"]="profile";
	  			$view="profile.php";
	  			break;
  			}else {
	  			$errors[]="Failed to submit request";
  			}
			break;
		case "pwdModify":
			$view="pwdModify.php";
			if(!empty($_REQUEST["submit"])&&$_REQUEST["submit"]=="Cancel"){
				$_SESSION["state"]="profile";
				$view="profile.php";
				break;
			}
			if(!empty($_GET['operation'])&&$_GET['operation']!="profile"){
				if($_GET['operation']=="allstats"){
					$_SESSION['state']='stats';
					$view="stats.php";
				}
				if($_GET['operation']=="guessgame"){
					$_SESSION["GuessGame"]=new GuessGame();
					$_SESSION['state']='guessGameplay';
					$view="guessGameplay.php";
				}
				if($_GET['operation']=="rockpaperscissors"){
					$_SESSION['RockPaperScissors']=new RockPaperScissors();
					$_SESSION['state']='rockPaperScissors';
					$view="rockPaperScissors.php";
				}
				if($_GET['operation']=="frogs"){
					$_SESSION['Frogs']=new Frogs();
					$_SESSION['state']='frogs';
					$view="frogs.php";	
				}
				if($_GET['operation']=="logout"){
					$_SESSION['state']='login';
					unset($_SESSION["user"]);
					$view="login.php";
				}
				break;
			}
			if(empty($_REQUEST["submit"]) || $_REQUEST["submit"]!="Modify"){
				break;
			}
			$query = "SELECT * FROM appuser WHERE userid=$1;";
            $result = pg_prepare($dbconn, "", $query);
            $result = pg_execute($dbconn, "", array($_SESSION["user"]));
            if(!($row = pg_fetch_array($result, NULL, PGSQL_ASSOC))){
				$errors[]="Failed to fetch user information";
				break;
			}
			if($row["password"]!=$_REQUEST["password0"]){
				$validation["pwd0"]="Your entered wrong password";
				break;
			}
			if(empty($_REQUEST["password1"]) || strlen($_REQUEST["password1"])<5 || strlen($_REQUEST["password1"])>20){
				$validation["pwd1"]="Password length must between 5 and 20 characters";
				break;
			}
			if($_REQUEST["password1"]!=$_REQUEST["password2"]) {
				$validation["pwd2"]="Passwords entered don't match";
				break;
			}
			$user=$row["userid"];
			$pwd=$_REQUEST["password1"];
			$query = "UPDATE appuser SET password='$pwd'
					  WHERE userid='$user';";
			if ($result = pg_query($dbconn, $query)) {
				$_SESSION["state"]="profile";
				$view="profile.php";
				break;
			}else {
				$errors[]="Failed to submit request";
			}
			break;
	}
	require_once "view/$view";
?>