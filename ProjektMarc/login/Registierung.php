<?php
session_start();
require_once 'config.php'; // Stelle sicher, dass du eine funktionierende Datenbankverbindung hast

if (isset($_POST['register'])) {
    $user = $_POST['user'];
    $pwd = $_POST['pwd'];

    // Überprüfen, ob Benutzername und Passwort ausgefüllt sind
    if (!empty($user) && !empty($pwd)) {

        // Benutzer in die Datenbank einfügen
        $stmt = $pdo->prepare("INSERT INTO login (user, pwd) VALUES (:user, :pwd)");
        $stmt->bindParam(':user', $user, PDO::PARAM_STR);
        $stmt->bindParam(':pwd', $pwd, PDO::PARAM_STR);

        // Ausführen und Bestätigung anzeigen
        if ($stmt->execute()) {
            // Weiterleiten zur Login-Seite nach erfolgreicher Registrierung
            header("Location: login.php");
            exit(); // Stellt sicher, dass kein weiterer Code nach der Weiterleitung ausgeführt wird
        } else {
            echo "Fehler bei der Registrierung.";
        }
    } else {
        echo "Bitte Benutzername und Passwort ausfüllen.";
    }
}
?>
<!doctype html>
<html>
<head>
    <title>Registrierung</title>
    <meta charset="utf-8">
    <style>
        body {
            background-image: url("../background.png");
            color: white;
            font-size: 1.20em;
        }
        .other {
            width: 650px;
            height: 500px;
            opacity: 0.0;
        }
    </style>
</head>
<body>
    <h3 align="center">Otaku Opine</h3> 
    <table>
        <td><img class="other" src="../white.png"></td>
        <td>
            <table>
                <tr>
                    <br><strong>Registrierung</strong><br><br>
                </tr>
                <tr>
                    <form method="post">
                        User:<br>
                        <input name="user" value=""><br><br>
                        Passwort:<br>
                        <input type="password" name="pwd" value=""><br><br>
                        <input type="submit" name="register" value="Registrieren">
                    </form>
                    <br><br>
                </tr>
            </table>
        </td>
        <td><img class="other" src="../white.png"></td>
    </table>
</body>
</html>