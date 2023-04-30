<?php
//if form submitted
if (isset($_POST['submitted'])) {
    if (!isset($_POST['username'], $_POST['password'])) {
        // Could not get the data that should have been sent.
        exit('Please fill both the username and password fields!');
    }
    // connect to DB
    require_once("connectdb.php");
    try {
        //Query DB to find matching username/password
        //using prepare/bindparameter to prevent SQL injection.
        $stat = $db->prepare('SELECT password FROM users WHERE username = ?');
        $stat->execute(array($_POST['username']));

        // fetch the results row and check 
        if ($stat->rowCount() > 0) {  // matching username
            $row = $stat->fetch();

            if (password_verify($_POST['password'], $row['password'])) { //matching password

                //recording the user session variable and go to the projects page
                session_start();
                $_SESSION["username"] = $_POST['username'];
                header("Location:project.php");
                exit();
            } else {
                echo "<p style='color:red'>Error logging in, password does not match </p>";
            }
        } else {
            //else display an error
            echo "<p style='color:red'>Error logging in, Username not found </p>";
        }
    } catch (PDOException $ex) {
        echo ("Failed to connect to the database.<br>");
        echo ($ex->getMessage());
        exit;
    }
}
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Managment Tool</title>
    <link href="style.css" rel="stylesheet" type="text/css"/>
</head>

<body>
    <div id="contentHolder">
        <header id="main-header">
            <h1 id="TCheading"><a href="index.php" open="onClick">Project Managment Tool</a></h1>

            <form id="Form" name="signInForm" action="index.php" method="post">
                <label>Username</label>
                <input type="text" name="username" size="15" maxlength="25" />
                <label>Password:</label>
                <input type="password" name="password" size="15" maxlength="25" />

                <input type="submit" value="Login" />
                <input type="hidden" name="submitted" value="TRUE" />
            </form>
        </header>

        <section id="join-up-message">
            <h2>facilisi cras fermentum odio eu</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <a href="signup.php"><Button type="button">Sign Up!</Button></a>
        </section>

        <section id="testimonials">
            <h2>What our clients have said about us</h2>
            <blockquote>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Bibendum neque egestas congue quisque egestas diam." - Steve</blockquote>
            <blockquote>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lectus magna fringilla urna porttitor." - John</blockquote>
        </section>
    </div>
</body>

</html>