<?php 
require('database.php');

session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_POST["voornaam"], $_POST["achternaam"], $_POST["telefoon"], $_POST["email"], $_POST["klas"], $_POST["avatar"])) {
    echo "Missing items!";
    header("Location: ../dashboard/user.php?id=".$_POST["id"]."");
    return false;
}
$sql = "UPDATE leerlingen SET voornaam=?, achternaam=?, telefoon=?, email=?, klas=?, avatar=? WHERE id=".$_POST["id"]."";


if ($stmt = $conn->prepare($sql)) {

    $stmt->bind_param(
        "ssisss",
        $_POST["voornaam"],
        $_POST["achternaam"],
        $_POST["telefoon"],
        $_POST["email"],
        $_POST["klas"],
        $_POST["avatar"],
    );

    $stmt->execute();
    $stmt->close();
    header("Location: ../dashboard/user.php?id=".$_POST["id"]."");
}
?>
