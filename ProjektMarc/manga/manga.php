<?php
session_start();

$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
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
    </style>
</head>
<body>
    <div class="topnav">
        <a href="../home/home.php"><i class="fa fa-fw fa-home"></i> Home</a>
        <a href="../anime/anime.php"><i class="fa fa-fw fa-tv"></i> Anime</a>
        <a class="active" href="../manga/manga.php"><i class="fa fa-fw fa-book"></i> Manga</a>
        <a href="../search/search.php"><i class="fa fa-fw fa-search"></i> Search</a>

        <?php if ($isLoggedIn){ ?>
            <div class="dropdown">
                <button class="dropbtn"><i class="fa fa-fw fa-user"></i> <?php echo htmlspecialchars($user); ?></button>
                <div class="dropdown-content">
                    <a href="../profile/profile.php">Profile</a>
                    <a href="../login/logout.php">Logout</a>
                </div>
            </div>
        <?php }else{ ?>
            <a href="../login/login.php"><i class="fa fa-fw fa-user"></i> Login</a>
        <?php } ?>
    </div>
    <h3 align="center">Otaku Opine</h3>
    <table>
        <td><img class="other" src="../white.png"></td>
        <td>
            <?php include 'main.php';?>
        </td>
        <td><img class="other" src="../white.png"></td>
    </table>
    

</body>
<?php
/*echo '<td><form name="star_submit" id="star_submit" action="main.php" method="post">
<table>
    <tr>
        <td colspan="1">
            <br>
            <div class="star_rating">
                <input type="checkbox" id="star5" name="Star_Rating_of_5_Stars" class="star" value="5">
                <label for="star5" class="star" title="5 stars"></label>
                <input type="checkbox" id="star4" name="Star_Rating_of_5_Stars" class="star" value="4">
                <label for="star4" class="star" title="4 stars"></label>
                <input type="checkbox" id="star3" name="Star_Rating_of_5_Stars" class="star" value="3">
                <label for="star3" class="star" title="3 stars"></label>
                <input type="checkbox" id="star2" name="Star_Rating_of_5_Stars" class="star" value="2">
                <label for="star2" class="star" title="2 stars"></label>
                <input type="checkbox" id="star1" name="Star_Rating_of_5_Stars" class="star" value="1">
                <label for="star1" class="star" title="1 stars"></label>
            </div>
        </td>
    </tr>
</table>
</form><br><br><br><br><br><br>';*/
?>
</html>
