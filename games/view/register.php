<?php
$_REQUEST['username']=!empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
$_REQUEST['password1']=!empty($_REQUEST['password1']) ? $_REQUEST['password1'] : '';
$_REQUEST['password2']=!empty($_REQUEST['password2']) ? $_REQUEST['password2'] : '';
$_REQUEST['email']=!empty($_REQUEST['email']) ? $_REQUEST['email'] : '';
$_REQUEST['gender']=!empty($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
$_REQUEST['area']=!empty($_REQUEST['area']) ? $_REQUEST['area'] : '';
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
				<h2>Registration</h2>
				<table id="tabRgstr">
					<form action="index.php" method="post">
					<tr><th><label for="username">Username*</label></th><td><input type="text" name="username" value="<?php echo($_REQUEST['username']); ?>" required/></td></tr>
					<tr><th>&nbsp;</th><td><span class="error"> <?php if (isset($validation["name"])){echo($validation["name"]);}?></span></td></tr>
                    <tr><th><label for="email">Email*</label></th><td><input type="email" name="email" value="<?php echo($_REQUEST['email']); ?>"required/></td></tr>
					<tr><th>&nbsp;</th><td><span class="error"> <?php if (isset($validation["email"])){echo($validation["email"]);}?></span></td></tr>
					<tr><th><label for="password">Password*</label></th><td> <input type="password" name="password1" required/></td></tr>
					<tr><th>&nbsp;</th><td><span class="error"> <?php if (isset($validation["pwd1"])){echo($validation["pwd1"]);}?></span></td></tr>
                    <tr><th><label for="password">Confirm Password*</label></th><td> <input type="password" name="password2" required/></td></tr>
					<tr><th>&nbsp;</th><td><span class="error"> <?php if (isset($validation["pwd2"])){echo($validation["pwd2"]);}?></span></td></tr>
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
                    <tr id="last"><th>&nbsp;</th><td><input type="checkbox" name="acknowledge" value="acknowledge" required>I agree to the <a href="">Terms and Conditions</a></td></tr>
					<tr><th>&nbsp;</th><td></td></tr>
					<tr><th>&nbsp;</th><td><input type="submit" name="submit" value="Register"/></form></td></tr>
					<tr><th>&nbsp;</th><td><form action="index.php" method="post"><input type="submit" name="submit" value="Cancel"/></form></td></tr>
					<tr><th>&nbsp;</th><td><?php echo(view_errors($errors)); ?></td></tr>
				</table>	
			</div>
		</main>
		<footer>
			A project by Lang Qin
		</footer>
	</body>
</html>
