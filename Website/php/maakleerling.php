<?php 
require('database.php');

session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_POST["voornaam"], $_POST["achternaam"], $_POST["telefoon"], $_POST["email"])) {
    echo "Missing items!";
    header("Location: ../dashboard/index.php");
    return false;
}

if ($stmt = $conn->prepare("INSERT INTO leerlingen (id, voornaam, achternaam, telefoon, email, klas) VALUES (NULL,?,?,?,?,?)")) {

    $stmt->bind_param(
        "ssiss",
        $_POST["voornaam"],
        $_POST["achternaam"],
        $_POST["telefoon"],
        $_POST["email"],
        $_POST["klas"],
    );

    $stmt->execute();
    $stmt->close();
    header("Location: ../dashboard/index.php");
}
?>
