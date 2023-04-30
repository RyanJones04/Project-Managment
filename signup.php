<?php
//if the form has been submitted
if (isset($_POST['submitted'])) {
	#prepare the form input

	// connect to the database
	require_once('connectdb.php');

	$email = isset($_POST['email']) ? $_POST['email'] : false;
	$username = isset($_POST['username']) ? $_POST['username'] : false;
	$password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : false;

	if(!($email)){
		echo "Email wrong!";
		exit;
	}
	if(!($username)){
		echo "Username wrong!";
		exit;
	}
	if(!($password)){
		echo ("password wrong!");
		exit;
	}
	try {
		# Checks if email or username is already used
		$query = "select username from  users where username like ". "'" . $_POST["username"] . "'";
		$rows =  $db->query($query);
		$query2 = "select email from  users where email like ". "'" . $_POST["email"] . "'";
		$rows2 =  $db->query($query2);
		$query3 = "select uid from users order by uid desc";
		$rows3 = $db->query($query3);
		$user = $rows3->fetch(PDO::FETCH_ASSOC);
    	$uid = $user['uid'] + 1;
		if($rows->rowCount() == 0){
			if($rows2->rowCount() == 0){
				#register user by inserting the users info 
				$stat = $db->prepare("insert into users values(?,?,?,?)");
				$stat->execute(array($uid, $username, $password, $email));
				header('location: index.php');
			}else{
				echo "Email already taken!";
			}
		}else{
			echo "Username already taken!";
		}
	} catch (PDOexception $ex) {
		echo "Sorry, a database error occurred! <br>";
		echo "Error details: <em>" . $ex->getMessage() . "</em>";
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Project Managment Tool</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="contentHolder">
		<header id="main-header">
			<h1 id="TCheading"><a href="index.php" open="onClick">Project Managment Tool</a></h1>
		</header>

		<div id="textholder1">
			<h2>Register</h2>
			<form method="post" action="signup.php">
				Email: <input type="email" name="email" /><br>
				Username: <input type="text" name="username" /><br>
				Password: <input type="password" name="password" /><br><br>

				<input type="submit" value="Register" />
				<input type="reset" value="clear" />
				<input type="hidden" name="submitted" value="true" />
			</form>
		</div>
		<a href="index.php"><Button type="button">Back</Button></a>
	</div>
</body>

</html>