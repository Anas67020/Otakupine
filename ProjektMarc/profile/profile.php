<?php session_start();
$stars = "../star.png";
$stargrey = "../stargrey.png";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    if (!isset($_COOKIE['user_login'])) {
        header("Location: ../login/login.php");
        exit();
    } else {
        $_SESSION['user'] = $_COOKIE['user_login'];
        $_SESSION['loggedin'] = true;
    }
}
 
$user = $_SESSION['user'];
 
$pdo = new PDO('mysql:host=localhost;dbname=otakuopine_login', 'root', '');
$pdo2 = new PDO('mysql:host=localhost;dbname=anime_manga_daten', 'root', '');
 
/*$title = "SELECT titel FROM comment WHERE user = :user";
$sql = "SELECT * FROM anime_manga WHERE title = :title";*/
 
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
        .white {
            width: 200px;
            height: 300px;
            opacity: 0.0;
        }
        #CommentTable {
            background-color:#dbdbdb;
            color: black;
        }
    </style>
</head>
<body>
 
    <div class="topnav">
        <a href="../home/home.php"><i class="fa fa-fw fa-home"></i> Home</a>
        <a href="../anime/anime.php"><i class="fa fa-fw fa-tv"></i> Anime</a>
        <a href="../manga/manga.php"><i class="fa fa-fw fa-book"></i> Manga</a>
        <a href="../search/search.php"><i class="fa fa-fw fa-search"></i> Search</a>
        <?php if (isset($_SESSION['loggedin']) === true): ?>
            <div class="dropdown">
                <button class="dropbtn"><i class="fa fa-fw fa-user"></i> <?php echo htmlspecialchars($user); ?></button>
                <div class="dropdown-content">
                    <a class="active" href="#profile">Profile</a>
                    <a href="../login/logout.php">Logout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
   
    <h3 align="center">Otaku Opine</h3>
 
    <table>
        <tr>
        <td><img class="white" src="../white.png"></td>
            <td>
                <table>
                <?php
                    // Prepare the first SQL statement to get the titles
                    $titleQuery = $pdo->prepare("SELECT titel FROM comment WHERE user = :user");
                    $titleQuery->execute(['user' => $user]); // Execute with the user parameter

                    $commentQuery = $pdo->prepare("SELECT titel FROM comment WHERE user = :user");
                    $commentQuery->execute(['user' => $user]); // Execute the query with the user's name
                    $commentCount = $commentQuery->rowCount(); // Count how many comments exist

                    if ($commentCount == 0) {
                        // If no comments are found, display the message
                        echo '<p align="center">You have to write comments first.</p>';
                    } else {
                    while ($titleRow = $titleQuery->fetch(PDO::FETCH_ASSOC)) {
                    $title = $titleRow['titel'];
                    $st2 = $pdo->prepare("SELECT * FROM comment WHERE titel = :title ");
                    $st2->execute(['title' => $title]);
                    $commentContent = $st2->fetchAll(PDO::FETCH_ASSOC);
 
                    // Prepare the second SQL statement to get the anime/manga details for the title
                        $animeQuery = $pdo2->prepare("SELECT * FROM anime_manga WHERE title = :title");
                        $animeQuery->execute(['title' => $title]); // Execute with the title parameter
 
                    // Fetch and display the results
                        while ($row = $animeQuery->fetch(PDO::FETCH_ASSOC)) {
                            echo '<table align="center" border="0" cellpadding="10" cellspacing="0">';
                            echo '<tr>';
                            echo '<h2><td><a href="../rating.php?title=' . $row['title'] .'">'.$row['title'].'</a></td></h2>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td><img class="other" src="' . $row['image_url'] . '" alt="' . $row['image_url'] . '"><br><br><strong>';
                            echo $row['rank'] . '</strong><br></td>';
                            echo '<td><form name="star_submit" id="star_submit" action="main.php" method="post">
                            <table>
                                <tr>
                                <td colspan="1">
                                <br>
                                <div class="star"><tr>';
 
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($row['rating'] >= $i) {
                                        echo '<img class="star" src="'. $stars .'">';
                                    } else {
                                        echo '<img class="star" src="'. $stargrey .'">';
                                    }
                                }
 
                            echo '</tr></div>
                                </td>
                                </tr>
                                </table>
                                </form>';
                            echo '<strong>'. $row['Genre'] . '</strong><br><br>';
                            echo $row['summary'] . '</td>';
                            echo '</tr>';
                            echo '</table>';
 
                            // Handle comments display (assuming $commentContent is already defined and valid)
                            echo '<div class="CommentTable" id="CommentTable"><table >';
                            foreach ($commentContent as $comment) {
                                echo '<tr><td><strong>' . htmlspecialchars($comment['user']) . '</strong></td></tr>';
                                echo '<tr><td>'.htmlspecialchars($comment['comment']) .'</td></tr>';
                            }
                            echo '</table></div>';
                        }
                    }
                }
                ?>
                </table>
            </td><td><img class="white"src="../white.png"></td>
        </tr>
    </table>
</body>
</html>