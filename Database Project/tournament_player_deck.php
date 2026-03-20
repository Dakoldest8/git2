<?php
include "db.php";

$message = "";

// Get tournament players without a deck
$tournaments = $db->query("SELECT tournament_id, tournament_name FROM tournaments")->fetchAll();
$decks       = $db->query("SELECT deck_id, deck_name FROM decks")->fetchAll();

if(isset($_POST['assign'])){
    $stmt = $db->prepare("UPDATE tournament_players SET deck_id = ? WHERE tournament_id = ? AND player_id = ?");
    $stmt->execute([$_POST['deck_id'], $_POST['tournament_id'], $_POST['player_id']]);
    $message = "<div style='color:green;'>Deck assigned successfully!</div>";
}

// Fetch players for selected tournament
$selected_tournament = $_POST['tournament_id'] ?? null;
$players = [];
if($selected_tournament){
    $stmt = $db->prepare("SELECT tp.player_id, p.player_name, tp.deck_id 
                          FROM tournament_players tp
                          JOIN players p ON tp.player_id = p.player_id
                          WHERE tp.tournament_id = ?");
    $stmt->execute([$selected_tournament]);
    $players = $stmt->fetchAll();
}
?>

<link rel="stylesheet" href="style.css">
<?php include "navbar.php"; ?>

<h2>Assign Decks to Tournament Players</h2>

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
            <tr><th>Player</th><th>Current Deck</th><th>Assign Deck</th></tr>
            <?php foreach($players as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['player_name']) ?></td>
                    <td><?= $p['deck_id'] ? getDeckName($p['deck_id'], $db) : 'None' ?></td>
                    <td>
                        <select name="deck_id" required>
                            <option value="">-- Select Deck --</option>
                            <?php foreach($decks as $d): ?>
                                <option value="<?= $d['deck_id'] ?>"><?= htmlspecialchars($d['deck_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="player_id" value="<?= $p['player_id'] ?>">
                        <button name="assign">Assign</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </form>
<?php endif; ?>

<?php
// Helper function to get deck name
function getDeckName($deck_id, $db){
    $stmt = $db->prepare("SELECT deck_name FROM decks WHERE deck_id = ?");
    $stmt->execute([$deck_id]);
    return $stmt->fetchColumn();
}
?>