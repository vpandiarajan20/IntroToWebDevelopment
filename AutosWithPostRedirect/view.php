<?php
session_start();
require_once "pdo.php";
if( !isset($_SESSION['who']) ){
    die("Name parameter missing");
}

$stmt = $pdo->query("SELECT make, year, mileage FROM autos ORDER BY make");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Vignesh Pandiarajan's Automobile Tracker</title>
</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php echo $_SESSION['who']; ?></h1>
<p>
<?php 
    if ( isset($_SESSION["success"]) ) {
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
        unset($_SESSION["success"]);
    }
    if ( isset($_SESSION["failure"]) ) {
        echo('<p style="color:red">'.$_SESSION["failure"]."</p>\n");
        unset($_SESSION["failure"]);
    }
?>
</p>
<h2>Automobiles</h2>
<p>
<?php
echo '<table border="1">'."\n";
foreach ( $rows as $row ) {
    echo $row['year'] . " " . $row['make'] . " / " . $row['mileage'] . "<br>";
    
}
echo "</table>\n";
?>
</p>
<p>
    <a href="add.php">Add New</a> |
    <a href="logout.php">Logout</a>
</p>
</div>
</body>
</html>