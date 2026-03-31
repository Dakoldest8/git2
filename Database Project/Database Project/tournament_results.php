<?php
include "db.php";

$message = "";

// Fetch all tournaments
$tournaments = $db->query("SELECT tournament_id, tournament_name FROM tournaments")->fetchAll();

// Handle form submission
if (isset($_POST['update'])) {
    foreach ($_POST['match_wins'] as $player_id => $match_wins) {
        $stmt = $db->prepare("
            UPDATE tournament_players 
            SET match_wins = ?, match_losses = ?, points = ?, placement = ?
            WHERE tournament_id = ? AND player_id = ?
        ");
        $stmt->execute([
            (int)$match_wins,
            (int)$_POST['match_losses'][$player_id],
            (int)$_POST['points'][$player_id],
            (int)$_POST['placement'][$player_id],
            (int)$_POST['tournament_id'],
            (int)$player_id
        ]);
    }
    $message = "<div style='color:green;'>Results updated!</div>";
}

// Get selected tournament
$selected_tournament = $_POST['tournament_id'] ?? null;
$players = [];
if ($selected_tournament) {
    $stmt = $db->prepare("
        SELECT tp.*, p.player_name, d.deck_name
        FROM tournament_players tp
        JOIN players p ON tp.player_id = p.player_id
        LEFT JOIN decks d ON tp.deck_id = d.deck_id
        WHERE tp.tournament_id = ?
    ");
    $stmt->execute([$selected_tournament]);
    $players = $stmt->fetchAll();
}
?>

<link rel="stylesheet" href="style.css">
<?php include "navbar.php"; ?>

<div class="container">
<h2>Enter Tournament Results</h2>
<?= $message ?>

<!-- Select Tournament -->
<form method="post">
    <label>Select Tournament</label>
    <select name="tournament_id" onchange="this.form.submit()">
        <option value="">-- Select --</option>
        <?php foreach ($tournaments as $t): ?>
            <option value="<?= $t['tournament_id'] ?>" <?= ($selected_tournament == $t['tournament_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($t['tournament_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if ($players): ?>
<form method="post">
    <input type="hidden" name="tournament_id" value="<?= $selected_tournament ?>">
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Player</th>
            <th>Deck</th>
            <th>Wins</th>
            <th>Losses</th>
            <th>Points</th>
            <th>Placement</th>
        </tr>
        <?php foreach ($players as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['player_name']) ?></td>
            <td><?= $p['deck_name'] ?? 'None' ?></td>
            <td><input type="number" name="match_wins[<?= $p['player_id'] ?>]" value="<?= $p['match_wins'] ?>"></td>
            <td><input type="number" name="match_losses[<?= $p['player_id'] ?>]" value="<?= $p['match_losses'] ?>"></td>
            <td><input type="number" name="points[<?= $p['player_id'] ?>]" value="<?= $p['points'] ?>"></td>
            <td><input type="number" name="placement[<?= $p['player_id'] ?>]" value="<?= $p['placement'] ?>"></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <button name="update">Update All Results</button>
</form>
<?php endif; ?>
</div>