<?php
session_start();
require('../php/database.php');

if (!isset($_SESSION["loggedin"])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
}

$admin = $_SESSION['admin'];
$id = $_GET['id'];

if ($stmt = $conn->prepare("SELECT id, voornaam, achternaam, email, telefoon, avatar, punten, klas FROM leerlingen WHERE id = ?;")) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $voornaam, $achternaam, $email, $telefoon, $avatar, $punten, $klas);
        $stmt->fetch();
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teach Ground - Disable User</title>
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
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <center><b>Student Details</b></center>
                    </div>
                    <div class="card-body">
                        <div class='float-left'>
                            <?php
                            echo "<img src='../IMG/avatars/" . $avatar . "' style='width: 64px;'>"
                            ?>
                        </div>
                        <div class='float-right'>
                            <?php
                            echo "<h5>" . $voornaam . " " . $achternaam . "</h5>";
                            echo "<p>" . $email . "<br>" . $telefoon . "</p>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <form class="card p-4" action="../php/disableleerling.php" method="POST">
                    <h3 class="modal-title">Are you sure that you want to disable this student?</h3>
                    <p>This can only be undone trough your system administrator.</p>
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Yes, Delete!</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>