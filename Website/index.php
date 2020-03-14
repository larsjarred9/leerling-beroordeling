<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teach Ground - Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="IMG/logo/icon.ico">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
    <!-- Login Content-->
    <main class="container">
        <div class="login-box mx-auto shadow p-3 mb-5 bg-white rounded">
            <!-- Shadow, Center in the middle of screen -->
            <!-- Logo-->
            <center><img src="IMG/logo/logo.png"></center>
            <h4 class="card-title mb-4 mt-1">Inloggen</h4>
            <!-- Forum Itself -->
            <form method="POST" action="php/login/authenticate.php">
                <div class="form-group">
                    <label>E-mail</label>
                    <input name="username" id="username" name="username" class="form-control" placeholder="E-mail" type="email">
                </div>
                <div class="form-group">
                    <label>Wachtwoord</label>
                    <input name="password" id="password" class="form-control" placeholder="******" type="password">
                </div>
                <div class="form-group">
                    <button id="submit" type="submit" class="btn btn-primary btn-block" name="Inloggen">Inloggen</button>
                </div>
                <?php
                if (isset($_GET['pas'])) {
                    echo "<span style='color: rgb(0,185,255);'>The password or username you previously proved was incorect.</span>";
                }
                ?>
            </form>
        </div>
    </main>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--<script src="js/login.js"></script>-->
    <!-- 145.118.6.22:3000 -->
</body>

</html>