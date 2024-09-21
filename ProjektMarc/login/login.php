<?php
session_start();
$f = '';
if (isset($_POST['sub'])) {
    $pdo = new PDO('mysql:host=localhost;dbname=otakuopine_login', 'root', '');
    $sql = "SELECT * FROM login";
    $user = $_POST['user'];
    $pwd = $_POST['pwd'];
    $st = $pdo->prepare("SELECT * FROM login WHERE user = :user AND pwd = :pwd");
    $st->execute(['user' => $user, 'pwd' => $pwd]);
    $anz = $st->rowCount();

    if ($anz == 1) {
      $_SESSION['user'] = $user;
      $_SESSION['loggedin'] = true; // Set the session variable to indicate the user is logged in

      // Set a cookie for login verification
      setcookie('user_login', $user, time() + (86400 * 30), "/"); // Cookie expires in 30 days

      header("Location: ../home/home.php");  
      exit(); // Always use exit() after header redirection to prevent further script execution
  } else {
      unset($_SESSION['user']);
      $_SESSION['loggedin'] = false; // Ensure loggedin is false if the login failed
      $f = "Login was wrong!";
  }
}
?>

 
<!doctype html>
<html>
  <head>
    <title>Login</title>
    <meta charset="utf-8">
    <style>
      body{
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
        <td><table><tr><br>
        <strong>Login</strong>
        <br><br>
        </tr>
        <tr>
            <?php
            echo $f
            ?>
            <form method="post">
            User:<br>
            <input name="user" value=""><br><br>
            Passwort:<br>
            <input type="password" name="pwd" value="">
            <br><br>
            <input type="submit" name="sub" value="Login">
            </form>
            <br><br>
            <div class="design" align="center"><tr><a href="Registierung.php"> Registrieren</a></tr></div>
            </tr>
            <tr></tr>
            </table>
            </td>
        <td><img class="other" src="../white.png"></td>
    </table>
</div>
</body>
</html>