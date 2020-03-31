<?php 
session_start();
require('database.php');

if (!isset($_SESSION["loggedin"])) {
    header("Location: ../index.php");
    exit();
}

$password = $_SESSION['password'];
$id = $_SESSION['id'];

$nameold = $_POST["nameold"];
$namenew = $_POST["namenew"];
$namever = $_POST["namever"];

if (!isset($_POST["nameold"], $_POST["namenew"], $_POST["namever"])) {
    //echo "Missing items!";
    header("Location: ../dashboard/account.php?fail=mis");
    return false;
}

if (md5($nameold) === $password) {
    if ($namenew == $namever) {
        $newpassword = md5($namever);

        if($stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?")){
            $stmt->bind_param("si", $newpassword, $id);
            $stmt->execute();
            $stmt->close();
            header("Location: login/logout.php");
        }
        else {
            header("Location: ../dashboard/account.php?fail=con");
            return false;
        }
    }
    else {
        header("Location: ../dashboard/account.php?fail=ver");
        return false;
    }
}
else {
    //echo "Het oude wachtwoord is niet juist.";
    header("Location: ../dashboard/account.php?fail=wro");
    return false;
}

?>