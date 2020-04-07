<?php 
require('database.php');

session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_POST["id"])) {
    echo "Missing items!";  
    header("Location: ../dashboard/index.php");
    return false;
}
$sql = "UPDATE leerlingen SET disable='true' WHERE id=".$_POST["id"]."";
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $stmt->close();header("Location: ../dashboard/index.php");
}

?>