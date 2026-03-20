<?php
include "db.php";

$message = "";

$tournaments = $db->query("SELECT tournament_id, tournament_name FROM tournaments")->fetchAll();

if(isset($_POST['update'])){
    $stmt = $db->prepare("UPDATE tournament_players 
                          SET match_wins = ?, match_losses = ?, points = ?, placement = ?
                          WHERE tournament_id = ? AND player_id = ?");
    $stmt->execute([
        $_POST['match_wins'],
        $_POST['match_losses'],
        $_POST['points'],
        $_POST['placement'],
        $_POST['tournament_id'],
        $_POST['player_id']
    ]);
    $message = "<div style='color:green;'>Results updated!</div>";
}

// Fetch players for selected tournament
$selected_tournament = $_POST['tournament_id'] ?? null;
$players = [];
if($selected_tournament){
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

<h2>Enter Tournament Results</h2>

<?= $message ?>

<form method="post">
    <label>Select Tournament</label>
    <select name="tournament_id" onchange="this.form.submit()">
        <option value="">-- Select --</option>
        <?php foreach($tournaments as $t): ?>
            <option value="<?= $t['tournament_id'] ?>" <?= ($selected_tournament == $t['tournament_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($t['tournament_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if($players): ?>
    <form method="post">
        <input type="hidden" name="tournament_id" value="<?= $selected_tournament ?>">
        <table>
            <tr>
                <th>Player</th>
                <th>Deck</th>
                <th>Wins</th>
                <th>Losses</th>
                <th>Points</th>
                <th>Placement</th>
                <th>Update</th>
            </tr>
            <?php foreach($players as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['player_name']) ?></td>
                    <td><?= $p['deck_name'] ?? 'None' ?></td>
                    <td><input type="number" name="match_wins" value="<?= $p['match_wins'] ?>"></td>
                    <td><input type="number" name="match_losses" value="<?= $p['match_losses'] ?>"></td>
                    <td><input type="number" name="points" value="<?= $p['points'] ?>"></td>
                    <td><input type="number" name="placement" value="<?= $p['placement'] ?>"></td>
                    <td>
                        <input type="hidden" name="player_id" value="<?= $p['player_id'] ?>">
                        <button name="update">Update</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </form>
<?php endif; ?>