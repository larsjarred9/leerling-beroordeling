<?php 
require('database.php');

session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_POST["id"], $_POST["punten"], $_POST["reden"])) {
    echo "Missing items!";
    header("Location: ../dashboard/user.php?id=".$_POST["id"]."");
    return false;
}

$sql = "UPDATE leerlingen SET punten= punten + ? WHERE id=".$_POST["id"]."";

if ($stmt = $conn->prepare($sql)) {

    $stmt->bind_param(
        "i",
        $_POST["punten"],
    );

    $stmt->execute();
    $stmt->close();
}

if ($stmt = $conn->prepare("INSERT INTO leerlingen_activiteit (acid, id, punten, reden) VALUES (NULL,?,?,?)")) {

    $stmt->bind_param(
        "iis",
        $_POST["id"],
        $_POST["punten"],
        $_POST["reden"]
    );

    $stmt->execute();
    $stmt->close();
    header("Location: ../dashboard/user.php?id=".$_POST["id"]."");
}
?>