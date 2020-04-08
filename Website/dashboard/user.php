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


$sli = "SELECT punten, reden, tijd FROM leerlingen_activiteit WHERE id = " . $id . " ORDER BY tijd DESC;";
$done = $conn->query($sli);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teach Ground - User Information</title>
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
                    <div class="card-footer">
                        <div class="float-left">
                            <a><button type="button" data-toggle="modal" data-target="#addgebruiker" class="btn btn-primary">Edit Student</button> </a>
                        </div>
                        <div class="float-right">
                            <a href="del_user.php?id=<?php echo $id ?>"><button type="button" class="btn btn-danger">Disable Student</button> </a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <center><b>Activity Information</b></center>
                    </div>
                    <div class="card-body">
                        <?php
                        echo "<h3>" . $punten . " Points</h3>";
                        ?>
                    </div>
                    <div class="card-footer">
                        <center>
                            <a><button type="button" data-toggle="modal" data-target="#addactivity" class="btn btn-primary">Add Activity</button> </a>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <center><b>Student Activity Log</b></center>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Time</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col">Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($done as $item) {
                                    echo "<tr><td>" . $item['tijd'] . "</td>" . "<td>" . $item['reden'] . "</td>" . "<td>" . $item['punten'] . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addgebruiker" tabindex="-1" role="dialog" aria-labelledby="addgebruiker" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="../php/editleerling.php">
                        <div class="modal-body">
                            <div class="form-group">
                                <?php echo "<input type='hidden' name='id' value=" . $id . ""; ?>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="voornaam">First Name</label>
                                    <?php echo "<input type='text' class='form-control' id='voornaam' name='voornaam' placeholder='First Name' value=" . $voornaam . " required>"; ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="achternaam">Last Name</label>
                                    <?php echo "<input type='text' class='form-control' id='achternaam' name='achternaam' value=" . $achternaam . " placeholder='Last Name' required>"; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Telefoonummer">Tel (Parent)</label>
                                <?php echo "<input type='tel' class='form-control' id='telefoonummer' value=" . $telefoon . " placeholder='Tel' name='telefoon' required>"; ?>
                            </div>
                            <div class="form-group">
                                <label for="Email">E-Mail (Parent)</label>
                                <?php echo "<input type='email' class='form-control' id='email' value=" . $email . " placeholder='E-Mail' name='email' required>"; ?>
                            </div>
                            <div class="form-group">
                                <label for="klas">Class</label>
                                <?php
                                if ($admin == 1) {
                                    //Change (Admin [1])
                                    echo "<input type='text' class='form-control' id='klas' placeholder='Class' value='$klas' name='klas' required>";
                                } else {
                                    //Read (Normal [0])
                                    echo "<input readonly type='text' class='form-control' id='klas' placeholder='Class' value='$klas' name='klas' required>";
                                }
                                ?>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <p>Change Avatar</p>
                                    <table border="0" align="center" cellpadding="2" cellspacing="2">
                                        <tr>
                                            <td><img src="../IMG/avatars/Kid1.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid1.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid1.svg" name="avatar"></td>
                                            <td><img src="../IMG/avatars/Kid2.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid2.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid2.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid3.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid3.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid3.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid19.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid19.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid19.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid25.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid25.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid25.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid31.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid31.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid31.svg" name="avatar" /></td>
                                        </tr>
                                        <tr>
                                            <td><img src="../IMG/avatars/Kid4.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid4.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid4.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid5.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid5.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid5.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid6.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid6.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid6.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid20.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid20.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid20.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid26.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid26.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid26.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid32.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid32.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid32.svg" name="avatar" /></td>
                                        </tr>
                                        <tr>
                                            <td><img src="../IMG/avatars/Kid7.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid7.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid7.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid8.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid8.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid8.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid9.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid9.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid9.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid21.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid21.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid21.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid27.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid27.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid27.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid33.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid33.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid33.svg" name="avatar" /></td>
                                        </tr>
                                        <tr>
                                            <td><img src="../IMG/avatars/Kid10.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid10.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid10.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid11.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid11.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid11.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid12.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid12.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid12.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid22.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid22.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid22.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid28.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid28.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid28.svg" name="avatar" /></td>
                                        </tr>
                                        <tr>
                                            <td><img src="../IMG/avatars/Kid13.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid13.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid13.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid14.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid14.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid14.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid15.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid15.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid15.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid23.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid23.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid23.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid29.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid29.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid29.svg" name="avatar" /></td>
                                        </tr>
                                        <tr>
                                            <td><img src="../IMG/avatars/Kid16.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid16.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid16.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid17.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid17.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid17.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid18.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid18.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid18.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid24.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid24.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid24.svg" name="avatar" /></td>
                                            <td><img src="../IMG/avatars/Kid30.svg" alt="" width="32" height="32" /></td>
                                            <td><input type="radio" <?php if ($avatar == "Kid30.svg") {
                                                                        echo "checked";
                                                                    } ?> value="Kid30.svg" name="avatar" /></td>
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
        </div>
    </div>
    <div class="modal fade" id="addactivity" tabindex="-1" role="dialog" aria-labelledby="addactivity" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="../php/addactiviteit.php">
                    <div class="modal-body">
                        <div class="form-group">
                            <?php echo "<input type='hidden' name='id' value=" . $id . ""; ?>
                        </div>
                        <div class="form-group">
                            <label for="Telefoonummer">Points</label>
                            <?php
                            if ($punten == 4) {
                                echo "<input type='number' class='form-control' min='-4' max='5' id='punten' placeholder='50' name='punten' required>";
                            } else if ($punten == 3) {
                                echo "<input type='number' class='form-control' min='-3' max='5' id='punten' placeholder='50' name='punten' required>";
                            } else if ($punten == 2) {
                                echo "<input type='number' class='form-control' min='-2' max='5' id='punten' placeholder='50' name='punten' required>";
                            } else if ($punten == 1) {
                                echo "<input type='number' class='form-control' min='-1' max='5' id='punten' placeholder='50' name='punten' required>";
                            } else if ($punten == 0) {
                                echo "<input type='number' class='form-control' min='0' max='5' id='punten' placeholder='50' name='punten' required>";
                            } else if ($punten == 96) {
                                echo "<input type='number' class='form-control' min='-5' max='4' id='punten' placeholder='50' name='punten' required>";
                            } else if ($punten == 97) {
                                echo "<input type='number' class='form-control' min='-5' max='3' id='punten' placeholder='50' name='punten' required>";
                            } else if ($punten == 98) {
                                echo "<input type='number' class='form-control' min='-5' max='2' id='punten' placeholder='50' name='punten' required>";
                            } else if ($punten == 99) {
                                echo "<input type='number' class='form-control' min='-5' max='1' id='punten' placeholder='50' name='punten' required>";
                            } else if ($punten == 100) {
                                echo "<input type='number' class='form-control' min='-5' max='0' id='punten' placeholder='50' name='punten' required>";
                            } else {
                                echo "<input type='number' class='form-control' min='-5' max='5' id='punten' placeholder='50' name='punten' required>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="Email">Reason</label>
                            <?php echo "<input type='text' class='form-control' id='reden' placeholder='Reason' name='reden' required>"; ?>
                        </div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-success" value="Send">
                    </div>
                </form>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
