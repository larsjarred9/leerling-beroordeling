<?php
    session_start();
    require("../../php/database.php");
    if(!isset($_POST["username"], $_POST["password"]) ) {
        die ("Vul beide invoervelden in alstublieft.");
    }

    if($stmt = $conn->prepare("SELECT id,username,password FROM users WHERE username = ?")) {
        $stmt->bind_param("s", $_POST["username"]);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $password);
            $stmt->fetch();

            //Nog een hahs systeem includen
            
            $pswrd = $_POST["password"];
            if (md5($pswrd) === $password) {
                session_regenerate_id();
                $_SESSION["loggedin"] = TRUE;
                $_SESSION["name"] = $username;
                $_SESSION["id"] = $id;
                header("Location: ../../dashboard/index.php");
            } else {
                session_start();
                session_destroy();
                header("Location: ../../index.php?pas=false");
            }
        } else {
            session_start();
            session_destroy();
            header("Location: ../../index.php?pas=false");
        }
        $stmt->close();
    }
?>