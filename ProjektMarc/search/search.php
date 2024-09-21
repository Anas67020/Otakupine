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
        

      form {
        background-color: #4654e1;
        width: 300px;
        height: 44px;
        border-radius: 5px;
        display:flex;
        flex-direction:row;
        align-items:center;
      }

      input {
        all: unset;
        font: 16px system-ui;
        color: #fff;
        height: 100%;
        width: 100%;
        padding: 6px 10px;
      }

      ::placeholder {
        color: #fff;
        opacity: 0.7; 
      }

      svg {
        color: #fff;
        fill: currentColor;
        width: 24px;
        height: 24px;
        padding: 10px;
      }

      .buttonSearch {
        all: unset;
        cursor: pointer;
        width: 44px;
        height: 44px;
      }
      .searchButton{
        opacity: 0;
      }
    
    </style>
</head>
<body>

    <div class="topnav">
        <a href="../home/home.php"><i class="fa fa-fw fa-home"></i> Home</a>
        <a href="../anime/anime.php"><i class="fa fa-fw fa-tv"></i> Anime</a>
        <a href="../manga/manga.php"><i class="fa fa-fw fa-book"></i> Manga</a>
        <a class="active" a href="../search/search.php"><i class="fa fa-fw fa-search"></i> Search</a>
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
            <form id="form" action="search.php" method="get">
                <input type="text" id="query" name="q" placeholder="Search...">
                <button type="submit" class="searchButton">Search</button>
            </form>
            <?php
                $stars = "../star.png";
                $stargrey = "../stargrey.png";
                $pdo = new PDO('mysql:host=localhost;dbname=anime_manga_daten', 'root', '');

                // Get the query from the URL
                $searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

                // Predefined genres array (same as in JavaScript)
                $genres = ["Fighting-Shounen", "Drama", "Fantasy", "Cooking", "Sports", "Romance", "Adventure", "Thriller", 
                    "Action-Comedy", "Horror", "Action", "Epic Historical Martial arts", "Dark Fantasy", "Western", 
                    "Krimi", "Comedy", "Music", "Mystery","Mystery-Action", "Gambling", "Magical Girl"
                ];

                // Check if the query is a genre or title
                if (in_array($searchQuery, $genres)) {
                // Genre search
                $stmt = $pdo->prepare("SELECT * FROM anime_manga WHERE genre = :query");
                } else {
                // Title search
                $stmt = $pdo->prepare("SELECT * FROM anime_manga WHERE title LIKE :query");
                $searchQuery = "%" . $searchQuery . "%";  // Use LIKE for partial match
                }

                // Execute the query
                $stmt->bindParam(':query', $searchQuery, PDO::PARAM_STR);
                $stmt->execute();

                // Fetch the results
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Display the results
                if ($results) {
                    echo '<table>';
                    foreach ($results as $row) {
                        echo '<tr>';
                        echo '<h2><td><a href="../rating.php?title=' . $row['title'] .'">' . $row['title'] . '</a></td></h2>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td><img class="other" src="' . $row['image_url'] . '" alt="' . $row['image_url'] . '"><br><br><strong>';
                        echo $row['rank'] . '</strong><br></td>';
                        echo '<td><div name="star_submit" id="star_submit" action="main.php" method="post">
                            <table>
                                <tr>
                                    <td colspan="1">
                                    <br>
                                    <div class="star"><tr>';

                        for ($i = 1; $i <= 5; $i++) {
                            if ($row['rating'] >= $i) {
                                echo '<img class="star" src="' . $stars . '">';
                            } else {
                                echo '<img class="star" src="' . $stargrey . '">';
                            }
                        }

                        echo '</tr></div></td></tr></table></div>';
                        echo '<strong>' . $row['Genre'] . '</strong><br><br>';
                        echo $row['summary'] . '</td>';
                        echo '</tr>';
                        }
                    echo '</table>';
                } else {
                    echo "No results found.";
                }

            ?>
            <script>
                // Get form and query input elements
                const f = document.getElementById('form');
                const q = document.getElementById('query');

                // Predefined genres array
                const genres = ["Fighting-Shounen", "Drama", "Fantasy", "Cooking", "Sports", "Romance", "Adventure", "Thriller", 
                    "Action-Comedy", "Horror", "Action", "Epic Historical Martial arts", "Dark Fantasy", "Western", 
                    "Krimi", "Comedy", "Music", "Mystery-Action", "Slice of Life"
                ];

                 // Check if the query matches any genres
                function isGenre(query) {
                    return genres.includes(query);
                }

                // Handle form submission
                function submitted(event) {
                    event.preventDefault();  // Prevent form from submitting normally
                    const searchQuery = q.value.trim();  // Get the search query

                    if (searchQuery) {  // If the user has entered something
                        const site = 'search.php';  // Target PHP file for search results
                        const url = site + '?q=' + encodeURIComponent(searchQuery);  // Build the URL with query parameter
                        window.location.href = url;  // Redirect to search.php with the search query
                    } else {
                        // If no query is entered, show main.php
                        window.location.href = 'search.php';
                    }
                }

                // Add event listener for form submission
                f.addEventListener('submit', submitted);
            </script>

            </td>
            <td><img class="white"src="../white.png"></td>
        </tr>
    </table>

</body>
</html>
