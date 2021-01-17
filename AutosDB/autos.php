<?php 
require_once "pdo.php";
if( !isset($_GET['name']) ){
    die("Name parameter missing");
}
$failure = false;  // If we have no POST data
$success = false;
if( isset($_POST['logout']) ){
    header('Location: index.php');
}
if ( isset($_POST['make']) && isset($_POST['year']) 
&& isset($_POST['mileage'])) {
    if ( !is_numeric($_POST['year']) || !is_numeric($_POST['mileage']) ) {
        $failure = "Mileage and year must be numeric";
    } elseif ( strlen($_POST['make']) < 1 ) {
        $failure = "Make is required";
    } else{
        $stmt = $pdo->prepare('INSERT INTO autos
        (make, year, mileage) VALUES ( :mk, :yr, :mi)');
        $stmt->execute(array(
        ':mk' => htmlentities($_POST['make']),
        ':yr' => htmlentities($_POST['year']),
        ':mi' => htmlentities($_POST['mileage'])));
        $success = 'Record inserted';
    }
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
<h1>Tracking Autos for <?php echo $_GET['name']; ?></h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
if ( $success !== false ) {
    echo('<p style="color: green;">'.htmlentities($success)."</p>\n");
}
?>
<form method="POST">
<label for="make">Make:</label>
<input type="text" name="make" id="make"><br/>
<label for="year">Year:</label>
<input type="text" name="year" id="year"><br/>
<label for="mileage">Mileage:</label>
<input type="text" name="mileage" id="mileage"><br/>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>
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
</div>
</body>