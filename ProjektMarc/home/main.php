<?php
/*<?php include 'main.php'; ?>*/
$stars = "../star.png";
$stargrey = "../stargrey.png";
$pdo = new PDO('mysql:host=localhost;dbname=anime_manga_daten', 'root', '');

$sql = "SELECT * FROM anime_manga";

// Neue und effizientere calculatePlace-Funktion
function calculatePlace($pdo) {
    // Hole alle Einträge und sortiere nach Bewertung (absteigend)
    $sql = "SELECT id, rating FROM anime_manga ORDER BY rating DESC";
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $rank = 1; // Startwert für den Rang
    foreach ($rows as $row) {
        // Update den Rang für jeden Eintrag
        $update = "UPDATE anime_manga SET rank = :rank WHERE id = :id";
        $stmtUpdate = $pdo->prepare($update);
        $stmtUpdate->execute(['rank' => $rank, 'id' => $row['id']]);
        $rank++; // Erhöhe den Rang für den nächsten Eintrag
    }
}

// Optional: Berechne die Rangliste direkt beim Laden der Seite
calculatePlace($pdo);

// Sortiere die Ergebnisse nach dem Rang, um sie korrekt anzuzeigen
$sql .= " ORDER BY rank ASC";

echo '<table align="center" border="0" cellpadding="10" cellspacing="0">';

foreach ($pdo->query($sql) as $row) {
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
}

echo '</table>';

$pdo = null;

?>
