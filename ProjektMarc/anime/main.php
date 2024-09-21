<?php
/*<?php include 'main.php'; ?>*/
$stars = "../star.png";
$stargrey = "../stargrey.png";
$pdo = new PDO('mysql:host=localhost;dbname=anime_manga_daten', 'root', '');

$sql = "SELECT * FROM anime_manga";

function calculatePlace($pdo) {
    $j = 1;
    for($i = 2; $i <= 500; $i++){
        // Fetch the rating for id = $j
        $sqlhelp = "SELECT rating FROM anime_manga WHERE id = $j";
        $stmtHelp = $pdo->query($sqlhelp);
        $rowHelp = $stmtHelp->fetch(PDO::FETCH_ASSOC);
        $ratingHelp = $rowHelp['rating'];

        // Fetch the rating for id = $i
        $sqlvergleich = "SELECT rating FROM anime_manga WHERE id = $i";
        $stmtVergleich = $pdo->query($sqlvergleich);
        $rowVergleich = $stmtVergleich->fetch(PDO::FETCH_ASSOC);
        $ratingVergleich = $rowVergleich['rating'];

        if($ratingHelp > $ratingVergleich){
            $a = 1; //help
        } elseif($ratingHelp < $ratingVergleich){
            $a = -1; //vergleich
        } else {
            $a = 0; //equal
        }

        if($a === 1){
            $update = "UPDATE anime_manga SET rank = $j WHERE id = $j";
        } elseif($a === -1){
            $update = "UPDATE anime_manga SET rank = $j WHERE id = $i";
        } else {
            $update = "UPDATE anime_manga SET rank = $j WHERE id = $j";
        }

        $pdo->query($update);
        $j++;
    }
}

if (isset($_GET['orderby'])) {
    $orderby = htmlspecialchars($_GET['orderby'], ENT_QUOTES, 'UTF-8');
    $sql .= " ORDER BY $orderby";
}




echo '<table align="center" border="0" cellpadding="10" cellspacing="0">';
//echo '<tr><td><a href="?orderby=title">title</a></td></tr><tr><td>image_url<br>rank</td><td>rating<br>Genre<br>summary</td></tr>';

foreach ($pdo->query($sql) as $row) {
    if($row['manga'] === 0){
        echo '<tr>';
        echo '<h2><td><a href="../rating.php?title=' . $row['title'] .'">'.$row['title'].'</a></td></h2>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><img class="other" src="' . $row['image_url'] . '" alt="' . $row['image_url'] . '"><br><br><strong>';
        echo $row['rank'] . '</strong><br></td>';
        //echo '<td>' . $row['rating'] . '<br>';
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
    }
    else{
        echo '';
    }
}

echo '</table>';

$pdo = null;


?>
