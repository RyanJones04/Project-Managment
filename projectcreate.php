<?php
session_start();
if (!isset($_SESSION['username'])){
        header("Location: index.php");
        exit();
    }

if (isset($_POST['submitted'])) {

	require_once('connectdb.php');

	$title = isset($_POST['title']) ? $_POST['title'] : false;
	$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : false;
	$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : false;
    $phase = isset($_POST['phase']) ? $_POST['phase'] : false;
	$desc = isset($_POST['desc']) ? $_POST['desc'] : false;
    $files = isset($_POST['files']) ? $_POST['files'] : false;

    $sql = "select * from users where username like ". "'" . $_SESSION["username"] . "'";
    $result = $db->query($sql);
    $user = $result->fetch(PDO::FETCH_ASSOC);
    $uid = $user['uid'];

	if (!($title)) {
		echo "no title";
		exit;
	}
	if (!($start_date)) {
		echo "no start date";
		exit;
	}
	if (!($end_date)) {
		echo "no end date";
        exit;
	}
    if (!($phase)) {
		echo "no phase";
        exit;
	}
    if (!($desc)) {
		echo "no description";
        exit;
	}
    if(!($files)){
        echo "no files";
        exit();
    }
	try {

		$stat = $db->prepare("insert into projects values(default,?,?,?,?,?,?,?)");
		$stat->execute(array($title, $start_date, $end_date, $phase, $desc, $uid, $files));

		$id = $db->lastInsertId();
		echo "Project Created. Project ID is: $id  ";
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
            <a href="index.php"><Button type="button">Sign out</Button></a>
        </header>

        <div id="textholder1">
            <h2>Register</h2>
            <form method="post" action="projectcreate.php">
                Project Title: <input type="text" name="title" /><br>
                Start date: <input type="date" name="start_date" /><br>
                End date: <input type="date" name="end_date" /><br>
                Phase: <select name="phase">
                            <option value="Design">Design</option>
                            <option value="Development">Development</option>
                            <option value="Testing">Testing</option>
                            <option value="Complete">Complete</option>
                        </select><br>
                Description: 
                <textarea name="desc" cols="30" rows="10"></textarea><br>
                Files:
                <textarea name="files" cols="30" rows="10"></textarea><br><br>

                <input type="submit" value="Register" />
                <input type="reset" value="clear" />
                <input type="hidden" name="submitted" value="true" />
            </form>
        </div>
        <a href="project.php"><button>Back</Button></a>
    </div>
</body>

</html>