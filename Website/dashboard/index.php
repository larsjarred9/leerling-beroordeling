<?php
session_start();
require('../php/database.php');

if (!isset($_SESSION["loggedin"])) {
    header("Location: ../index.php");
    exit();
}

$admin = $_SESSION['admin'];
$klas = $_SESSION['klas'];
$sql = "SELECT * FROM leerlingen WHERE klas = " . $klas . " AND disable = 'false' ORDER BY punten DESC, voornaam ASC;";
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
                        <a class="nav-link"><button type="button" class="btn btn-light" data-toggle="modal" data-target="#addgebruiker"><i class="fas fa-plus"></i> Add User</button></a>

                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <?php
            if (!$result) {
                echo "                
                <div class='col-7'>
                    <a class='nourl' href='#'>
                        <div class='card'>
                            <div class='card-body'>
                                <h3>Users could not be loaded.</h3>
                            </div>
                            <div class='card-footer'>
                                Please contact your system administator if you think this is an issue.
                            </div>
                        </div>
                    </a>
                </div>";
            } else {
                if ($result->num_rows === 0) {
                    echo "                
                    <div class='col-7'>
                        <a class='nourl' href='#'>
                            <div class='card'>
                                <div class='card-body'>
                                    <h3>There are zero (0) students in your class.</h3>
                                </div>
                                <div class='card-footer'>
                                    You can add a student by contacting your system administator our add one yourself with the button.
                                </div>
                            </div>
                        </a>
                    </div>";
                } else {
                    foreach ($result as $item) {
                        echo "
                    <div class='col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3'>
                        <a class='nourl' href='user.php?id=".$item['id']."'>
                            <div class='card'>
                                <div class='card-body'>
                                    <div class='float-left'>
                                        <h3>" . $item['voornaam'] . "</h3>
                                        <br><h5>" . $item['punten'] . " Points</h5>
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
            }
            //Hier zo moet staan dat de docuent geen leerlingen in zijn groep heeft.
            ?>
        </div>
    </div>
    <div class="modal fade" id="addgebruiker" tabindex="-1" role="dialog" aria-labelledby="addgebruiker" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add a student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="../php/maakleerling.php">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="voornaam">First Name</label>
                                <input type="text" class="form-control" id="voornaam" name="voornaam" placeholder="First Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="achternaam">Last Name</label>
                                <input type="text" class="form-control" id="achternaam" name="achternaam" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Telefoonummer">Tel (Parent)</label>
                            <input type="tel" class="form-control" id="telefoonummer" placeholder="Tel" name="telefoon" required>
                        </div>
                        <div class="form-group">
                            <label for="Email">E-Mail (Parent)</label>
                            <input type="email" class="form-control" id="email" placeholder="E-Mail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="klas">Class</label>
                            <?php
                            if ($admin == 1) {
                                //Change (Admin [1])
                                echo "<input type='text' class='form-control' id='klas' placeholder='Class' name='klas' required>";
                            } else {
                                //Read (Normal [0])
                                echo "<input readonly type='text' class='form-control' id='klas' placeholder='Class' value='$klas' name='klas' required>";
                            }
                            ?>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <p>Select Avatar</p>
                                <table border="0" align="center" cellpadding="2" cellspacing="2">
                                    <tr>
                                        <td><img src="../IMG/avatars/Kid1.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" checked value="Kid1.svg" name="avatar"></td>
                                        <td><img src="../IMG/avatars/Kid2.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid2.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid3.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid3.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid19.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid19.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid25.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid25.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid31.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid31.svg" name="avatar" /></td>
                                    </tr>
                                    <tr>
                                        <td><img src="../IMG/avatars/Kid4.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid4.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid5.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid5.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid6.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid6.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid20.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid20.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid26.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid26.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid32.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid32.svg" name="avatar" /></td>
                                    </tr>
                                    <tr>
                                        <td><img src="../IMG/avatars/Kid7.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid7.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid8.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid8.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid9.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid9.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid21.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid21.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid27.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid27.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid33.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid33.svg" name="avatar" /></td>
                                    </tr>
                                    <tr>
                                        <td><img src="../IMG/avatars/Kid10.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid10.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid11.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid11.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid12.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid12.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid22.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid22.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid28.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid28.svg" name="avatar" /></td>
                                    </tr>
                                    <tr>
                                        <td><img src="../IMG/avatars/Kid13.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid13.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid14.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid14.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid15.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid15.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid23.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid23.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid29.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid29.svg" name="avatar" /></td>
                                    </tr>
                                    <tr>
                                        <td><img src="../IMG/avatars/Kid16.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid16.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid17.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid17.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid18.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid18.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid24.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid24.svg" name="avatar" /></td>
                                        <td><img src="../IMG/avatars/Kid30.svg" alt="" width="32" height="32" /></td>
                                        <td><input type="radio" value="Kid30.svg" name="avatar" /></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-success" value="Send">
                    </div>
                </form>
            </div>
        </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> <</body>
</html></html>