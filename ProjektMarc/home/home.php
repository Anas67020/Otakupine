<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    if (isset($_COOKIE['user_login'])) {
        $_SESSION['user'] = $_COOKIE['user_login'];
        $_SESSION['loggedin'] = true;
    }
}
$user = isset($_SESSION['user']) ? $_SESSION['user'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otaku Opine</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .star {
            width: 35px;
            height: 35px;
        }
        .other {
            width: 200px;
            height: 300px;
        }
        .white{
            width: 200px;
            height: 300px;
            opacity: 0.0;
        }
    </style>
</head>
<body>

    <div class="topnav">
        <a class="active" href="#home"><i class="fa fa-fw fa-home"></i> Home</a>
        <a href="../anime/anime.php"><i class="fa fa-fw fa-tv"></i> Anime</a>
        <a href="../manga/manga.php"><i class="fa fa-fw fa-book"></i> Manga</a>
        <a href="../search/search.php"><i class="fa fa-fw fa-search"></i> Search</a>
        <?php if (isset($_SESSION['loggedin']) === true): ?>
            <div class="dropdown">
                <button class="dropbtn"><i class="fa fa-fw fa-user"></i> <?php echo htmlspecialchars($user); ?></button>
                <div class="dropdown-content">
                    <a href="../profile/profile.php">Profile</a>
                    <a href="../login/logout.php">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <a href="../login/login.php"><i class="fa fa-fw fa-user"></i> Login</a>
        <?php endif; ?>
    </div>
    <h3 align="center">Otaku Opine</h3>

    <table>
        <tr>
            <td><img class="white" src="../white.png"></td>
            <td>
                <?php include 'main.php'; ?></td>
            <td><img class="white"src="../white.png"></td>
        </tr>
    </table>

</body>
</html>
