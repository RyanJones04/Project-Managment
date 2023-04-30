<?php
session_start();
if (!isset($_SESSION['username'])){
        header("Location: index.php");
        exit();
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

        <section id="textholder1">
            <div id='portfolios'>
                <div class='pSections' name='pid'>Project ID</div>
                <div class='pSections' name='title'>Title</div>
                <div class='pSections' name='start_date'>Start Date</div>
                <div class='pSections' name='end_date'>End Date</div>
                <div class='pSections' name='phase'>Phase</div>
                <div class='pSections' name='description'>Description</div>
                <div class='pSections' name='uid'>User ID</div>
                <div class='pSections' name='files'>Files</div>
            </div>
            <br />
            <?php
            require_once('connectdb.php');
            try {
                $query = "select * from  projects ";
                $rows =  $db->query($query);
                
                if ($rows && $rows->rowCount() > 0) {
                    foreach ($rows as $row) {
                        echo "<div id='portfolios'>";
                        echo "<div class='pSections' name='pid'>" . $row['pid'] . "</div>";
                        echo "<div class='pSections' name='title'>" . $row['title'] . "</div>";
                        echo "<div class='pSections' name='start_date'>" . $row['start_date'] . "</div>";
                        echo "<div class='pSections' name='end_date'>" . $row['end_date'] . "</div>";
                        echo "<div class='pSections' name='phase'>" . $row['phase'] . "</div>";
                        echo "<div class='pSections' name='description'>" . $row['description'] . "</div>";
                        echo "<div class='pSections' name='uid'>" . $row['uid'] . "</div>";
                        echo "<div class='pSections' name='files'><a href=" . $row['files'] . " target='_blank' rel='noopener noreferrer'>Files</a></div>";
                        echo "</div>";
                        echo "<br />";
                    }
                }else{
                    echo "<p>No projects found!</p>";
                }
                } catch (PDOexception $ex) {
                    echo "Sorry, a database error occurred! <br>";
                    echo "Error details: <em>" . $ex->getMessage() . "</em>";
                }
            ?>
        </section>

        <a href="projectcreate.php">
            <Button type="button">Add Project</Button>
        </a>
    </div>
</body>

</html>