<?php session_start();



if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    if (!isset($_COOKIE['user_login'])) {
        header("Location: login/login.php");
        exit();
    } else {
        $_SESSION['user'] = $_COOKIE['user_login'];
        $_SESSION['loggedin'] = true;
    }
}

$user = $_SESSION['user'];

$pdo = new PDO('mysql:host=localhost;dbname=otakuopine_login', 'root', '');
$pdo2 = new PDO('mysql:host=localhost;dbname=anime_manga_daten', 'root', '');

if (isset($_GET['title'])) {
    $title = $_GET['title'];

    $st = $pdo2->prepare("SELECT * FROM anime_manga WHERE title = :title ");
    $st2 = $pdo->prepare("SELECT * FROM comment WHERE titel = :title ");
    $st->execute(['title' => $title]);
    $st2->execute(['title' => $title]);

    $anime = $st->fetch(PDO::FETCH_ASSOC);
    $commentContent = $st2->fetchAll(PDO::FETCH_ASSOC);

    // Funktion für das Rating
    function getSelectedStarRating($pdo2, $title) {
        if (isset($_POST['star_rating'])) {
            $newRating = $_POST['star_rating'];

            $st = $pdo2->prepare("SELECT rating FROM anime_manga WHERE title = :title");
            $st->execute(['title' => $title]);
            $row = $st->fetch(PDO::FETCH_ASSOC);
            $olderRating = $row['rating'];

            $ErgebnisDouble = ($olderRating + $newRating) / 2;
            if ($ErgebnisDouble >= 4.5) {
                $updateRating = 5;
            } else if ($ErgebnisDouble >= 3.5) {
                $updateRating = 4;
            } else if ($ErgebnisDouble >= 2.5) {
                $updateRating = 3;
            } else if ($ErgebnisDouble >= 1.5) {
                $updateRating = 2;
            } else {
                $updateRating = 1;
            }

            $sql = "UPDATE anime_manga SET rating = :updateRating WHERE title = :title";
            $stmt = $pdo2->prepare($sql);
            $stmt->bindParam(':updateRating', $updateRating);
            $stmt->bindParam(':title', $title);
            $stmt->execute();
        }
    }

    // Kommentarfunktion
    function Comment($pdo) {
        $userComment = $_SESSION['user'];
        $comment = $_POST['comment'] ?? '';
        $titleComment = $_GET['title'];

        if (!empty($comment)) {
            $insert = "INSERT INTO comment (user, comment, titel) VALUES (:user, :comment, :titel)";
            $stmt2 = $pdo->prepare($insert);
            $stmt2->bindParam(':user', $userComment);
            $stmt2->bindParam(':comment', $comment);
            $stmt2->bindParam(':titel', $titleComment);
            $stmt2->execute();
        }
    }

    if (isset($_POST['post'])) {
        Comment($pdo); // Korrekt die PDO-Verbindung übergeben
    }

    if (isset($_POST['star_submit'])) {
        getSelectedStarRating($pdo2, $title); // Korrekt den Titel übergeben
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otaku Opine</title>
    <link rel="stylesheet" href="style/style.css">
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
        input[type="radio"]{
            visibility:hidden;
        }
        #CommentTable { 
	        background-color:#dbdbdb; 
	        color: black;
        }
    </style>
    <script>
        function submitRating() {
            var rating = document.querySelector('input[name="star_rating"]:checked').value;

            if (!rating) {
                alert("Please select a rating.");
                return false;
            }

            document.getElementById('ratingForm').submit();
        }

        function submitComment() {
            var comment = document.getElementById("comment").value;
            if (comment.trim() === "") {
                alert("Please enter a comment.");
                return false;
            }
            document.getElementById('commentForm').submit();
        }
    </script>
</head>
<body>

    <div class="topnav">
        <a href="home/home.php"><i class="fa fa-fw fa-home"></i> Home</a>
        <a href="anime/anime.php"><i class="fa fa-fw fa-tv"></i> Anime</a>
        <a href="manga/manga.php"><i class="fa fa-fw fa-book"></i> Manga</a>
        <a href="search/search.php"><i class="fa fa-fw fa-search"></i> Search</a>
        <?php if (isset($_SESSION['loggedin']) === true): ?>
            <div class="dropdown">
                <button class="dropbtn"><i class="fa fa-fw fa-user"></i> <?php echo htmlspecialchars($user); ?></button>
                <div class="dropdown-content">
                    <a href="profile/profile.php">Profile</a>
                    <a href="login/logout.php">Logout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <h3 align="center">Otaku Opine</h3>

    <table>
        <tr>
            <td><img class="white" src="white.png"></td>
            <td>
                <table>
                <?php if ($anime) {
                    echo '<tr>';
                    echo '<h2><td>' . htmlspecialchars($anime['title']) . '</td></h2>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td><img class="other" src="' . $anime['image_url'] . '" alt="' . $anime['image_url'] . '"><br><br><strong>';
                    echo $anime['rank'] . '</strong><br></td>';
                    echo '<td><form id="ratingForm" method="POST">
                            <table>
                                <tr>
                                    <td colspan="1">
                                        <div class="star_rating">
                                            <input type="radio" id="star5" name="star_rating" class="star" value="5">
                                            <label for="star5" class="star" title="5 stars"></label>

                                            <input type="radio" id="star4" name="star_rating" class="star" value="4">
                                            <label for="star4" class="star" title="4 stars"></label>

                                            <input type="radio" id="star3" name="star_rating" class="star" value="3">
                                            <label for="star3" class="star" title="3 stars"></label>

                                            <input type="radio" id="star2" name="star_rating" class="star" value="2">
                                            <label for="star2" class="star" title="2 stars"></label>

                                            <input type="radio" id="star1" name="star_rating" class="star" value="1">
                                            <label for="star1" class="star" title="1 star"></label>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="submit" name="star_submit" value="Submit Rating" onclick="submitRating()" /></td>
                                </tr>
                            </table>
                        </form><br>';
                    echo '<strong>' . $anime['Genre'] . '</strong><br><br>';
                    echo $anime['summary'] . '<br><br>';
                    echo '<div class="CommentTable" id="CommentTable"><table >';
                    foreach ($commentContent as $comment):
                    echo '<tr><td><strong>' . htmlspecialchars($comment['user']) . '</strong></td></tr>';
                    echo '<tr><td>'.htmlspecialchars($comment['comment']) .'</td></tr>';
                    endforeach;
                    echo '</table></div></td></tr>';
                    
                    echo '<tr><td><td><table>';

                    echo '<form id="commentForm" method="POST">';
                    echo '<textarea id="comment" name="comment" placeholder="Add your comment" style="height:200px;width:600px;" maxlength="500"></textarea><br>';
                    echo '<input type="submit" name="post" value="Post Comment" onclick="submitComment()" />';
                    echo '</form>';
                } else {
                    echo "Anime not found!";
                }
                ?>
                </table>
            </td>
            <td><img class="white" src="white.png"></td>
        </tr>
    </table>
</body>
</html>
