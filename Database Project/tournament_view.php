<?php
include "db.php";
include "navbar.php";

$id = $_GET['id'] ?? null;

if(!$id){
    echo "<p>No tournament selected.</p>";
    exit;
}

// Fetch tournament info
$stmt = $db->prepare("SELECT * FROM tournaments WHERE tournament_id = ?");
$stmt->execute([$id]);
$tournament = $stmt->fetch();
if(!$tournament){
    echo "<p>Tournament not found.</p>";
    exit;
}

// Fetch players and their results
$stmt = $db->prepare("
    SELECT 
        tp.*, 
        p.player_name, 
        d.deck_name
    FROM tournament_players tp
    JOIN players p ON tp.player_id = p.player_id
    LEFT JOIN decks d ON tp.deck_id = d.deck_id
    WHERE tp.tournament_id = ?
    ORDER BY tp.placement ASC, tp.points DESC
");
$stmt->execute([$id]);
$players = $stmt->fetchAll();
?>

<link rel="stylesheet" href="style.css">

<div class="container">
<h2><?= htmlspecialchars($tournament['tournament_name']) ?> - Standings</h2>
<p><strong>Location:</strong> <?= htmlspecialchars($tournament['location']) ?> | 
<strong>Format:</strong> <?= htmlspecialchars($tournament['format']) ?></p>

<table border="1" cellpadding="8" cellspacing="0">
<tr>
    <th>Placement</th>
    <th>Player</th>
    <th>Deck</th>
    <th>Wins</th>
    <th>Losses</th>
    <th>Points</th>
    <th>Win %</th>
</tr>

<?php foreach($players as $p): 
    $total_matches = $p['match_wins'] + $p['match_losses'];
    $win_rate = ($total_matches > 0) ? round($p['match_wins'] / $total_matches * 100, 1) : 0;
?>
<tr>
    <td><?= $p['placement'] ?? '-' ?></td>
    <td><?= htmlspecialchars($p['player_name']) ?></td>
    <td><?= $p['deck_name'] ?? 'Not submitted' ?></td>
    <td><?= $p['match_wins'] ?></td>
    <td><?= $p['match_losses'] ?></td>
    <td><?= $p['points'] ?></td>
    <td><?= $win_rate ?>%</td>
</tr>
<?php endforeach; ?>

</table>
</div>