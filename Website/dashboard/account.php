<?php
session_start();
require('../php/database.php');

if (!isset($_SESSION["loggedin"])) {
    header("Location: ../index.php");
    exit();
}
$id = $_SESSION['id'];
$klas = $_SESSION['klas'];
$email = $_SESSION['name'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teach Ground - My Account</title>
    <link rel="shortcut icon" type="image/x-icon" href="..\IMG\logo\icon.ico">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/dashboard.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css" integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php"><img id="navbar-logo" src="../IMG/logo/logo_white.png"></a>
        <button class=" navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor02">
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link margin-fix dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-circle"></i> <?= $_SESSION['name'] ?> </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="../dashboard/account.php"><i class="fas fa-info-circle"></i> Account Information</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="..\php\login\logout.php"><i class="fas fa-sign-out-alt"></i> Log-Out</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><button type="button" class="btn btn-light"><i class="fas fa-users"></i> My Classroom</button></a>

                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <form class="card p-3" action="../php/changepassword.php" method="POST">
            <h5 class="modal-title">Edit your Information</h5>
            <div class="form-group">
                <label for="name">Your Email</label>
                <input required type="email" class="form-control" id="email" value="<?php echo $email; ?>" disabled>
                <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
            </div>
            <div class="form-group">
                <label for="class">Your Class</label>
                <input required type="number" class="form-control" id="email" value="<?php echo $klas; ?>" disabled>
            </div>
            <hr>
            <h5 class="modal-title">Change your Password</h5>
            <div class="form-group">
                <label for="class">Old Password</label>
                <input required type="password" class="form-control" name="nameold" placeholder="*********">
            </div>
            <div class="form-group">
                <label for="class">New Password</label>
                <input required type="password" class="form-control" name="namenew" placeholder="*********">
            </div>
            <div class="form-group">
                <label for="class">Verify Password</label>
                <input required type="password" class="form-control" name="namever" placeholder="*********">
            </div>
            <button type="submit" class="btn btn-primary">Change Details</button>
            <?php 
            if (isset($_GET["fail"])) {
                if ($_GET["fail"] == "con") {
                    echo "<span style='color: rgb(0,185,255);'>There has been a database issue, please contact your system administrator.</span>";
                }
                else if ($_GET["fail"] == "ver") {
                    echo "<span style='color: rgb(0,185,255);'>New passwords did not match.</span>";
                }
                else if ($_GET["fail"] == "wro") {
                    echo "<span style='color: rgb(0,185,255);'>You have entered the wrong password.</span>";
                }
                else if ($_GET["fail"] == "mis") {
                    echo "<span style='color: rgb(0,185,255);'>Password missing</span>";
                }
            }
            ?>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>