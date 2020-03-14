<?php
session_start();
require('../php/database.php');

if (!isset($_SESSION["loggedin"])) {
    header("Location: ../index.php");
    exit();
}

$admin = $_SESSION['admin'];
$klas = $_SESSION['klas'];
$sql = "SELECT * FROM leerlingen WHERE klas = " . $klas . " ORDER BY punten DESC;";
$result = $conn->query($sql);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teach Ground - Dashboard</title>
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
            <div class="navbar-collapse collapse" id="navbar9">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link margin-fix dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-circle"></i> <?= $_SESSION['name'] ?> </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="../account.php"><i class="fas fa-info-circle"></i> Account Information</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="..\php\login\logout.php"><i class="fas fa-sign-out-alt"></i> Log-Out</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"><button type="button" class="btn btn-light" data-toggle="modal" data-target="#addgebruiker"><i class="fas fa-plus"></i> Add User</button></a>

                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <?php
            if ($result == NULL) { //Dit is dus kaduk
                echo "                
                <div class='col-7'>
                    <a class='nourl' href='#'>
                        <div class='card'>
                            <div class='card-body'>
                                <h3>Er zitten momenteel nog geen leerlingen in deze klas.</h3>
                            </div>
                            <div class='card-footer'>
                                U kunt een leerling toevoegen via de administrator of via de maak leerling aan knop.
                            </div>
                        </div>
                    </a>
                </div>";
            } else {
                foreach ($result as $item) {
                    echo "
                <div class='col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3'>
                    <a class='nourl' href='#'>
                        <div class='card'>
                            <div class='card-body'>
                                <div class='float-left'>
                                    <h3>" . $item['voornaam'] . "</h3>
                                    <br><h5>" . $item['punten'] . " Punten</h5>
                                </div>
                                <div class='float-right'>
                                    <img src='../IMG/avatars/" . $item['avatar'] . "' style='min-height: 100px; min-width: 60px;'>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                ";
                }
            }
            //Hier zo moet staan dat de docuent geen leerlingen in zijn groep heeft.
            ?>
        </div>
    </div>
    <div class="modal fade" id="addgebruiker" tabindex="-1" role="dialog" aria-labelledby="addgebruiker" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Voeg leerling toe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="../php/maakleerling.php">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="voornaam">Voornaam</label>
                                <input type="text" class="form-control" id="voornaam" name="voornaam" placeholder="Voornaam" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="achternaam">Achternaam</label>
                                <input type="text" class="form-control" id="achternaam" name="achternaam" placeholder="Achternaam" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Telefoonummer">Telefoonummer (Ouder)</label>
                            <input type="tel" class="form-control" id="telefoonummer" placeholder="Telefoonummer" name="telefoon" required>
                        </div>
                        <div class="form-group">
                            <label for="klas">Klas</label>
                            <?php
                            if ($admin == 1) {
                                //Change (Admin [1])
                                echo "<input type='text' class='form-control' id='klas' placeholder='Klas' name='klas' required>";
                            } else {
                                //Read (Normal [0])
                                echo "<input readonly type='text' class='form-control' id='klas' placeholder='Klas' value='$klas' name='klas' required>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="Email">E-Mail (Ouder)</label>
                            <input type="email" class="form-control" id="email" placeholder="E-Mail" name="email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Anuleren</button>
                        <input type="submit" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>