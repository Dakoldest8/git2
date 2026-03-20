<?php
include "db.php";

$message = ""; 


$tournaments = $db->query("SELECT tournament_id, tournament_name FROM tournaments")->fetchAll();
$players     = $db->query("SELECT player_id, player_name FROM players")->fetchAll();
$decks       = $db->query("SELECT deck_id, deck_name FROM decks")->fetchAll();

if(isset($_POST['add'])){
    
    $check = $db->prepare("SELECT COUNT(*) FROM tournament_players WHERE tournament_id = ? AND player_id = ?");
    $check->execute([$_POST['tournament_id'], $_POST['player_id']]);
    
    if($check->fetchColumn() > 0) {
        $message = "<div style='color:red;'>Error: This player is already registered for this tournament.</div>";
    } else {
        
        $stmt = $db->prepare("INSERT INTO tournament_players 
            (tournament_id, player_id, deck_id, placement, match_wins, match_losses, points) 
            VALUES (?,?,?,?,?,?,?)");

        $stmt->execute([
            $_POST['tournament_id'], $_POST['player_id'], $_POST['deck_id'],
            $_POST['placement'], $_POST['match_wins'], $_POST['match_losses'], $_POST['points']
        ]);
        
        
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
        exit;
    }
}

if(isset($_GET['success'])) $message = "<div style='color:green;'>Player successfully added!</div>";
?>

<link rel="stylesheet" href="style.css">
<?php include "navbar.php"; ?>

<h2>Tournament Registration</h2>


<?= $message ?>

<form method="post">
    <label>Tournament</label>
    <select name="tournament_id" required>
        <option value="">-- Select --</option>
        <?php foreach($tournaments as $t): ?>
            <option value="<?= $t['tournament_id'] ?>"><?= htmlspecialchars($t['tournament_name']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Player</label>
    <select name="player_id" required>
        <option value="">-- Select --</option>
        <?php foreach($players as $p): ?>
            <option value="<?= $p['player_id'] ?>"><?= htmlspecialchars($p['player_name']) ?></option>
        <?php endforeach; ?>
    </select>

  

    <button name="add" type="submit">Add Entry</button>
</form>
