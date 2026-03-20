<?php include "db.php"; ?>
<link rel="stylesheet" href="style.css">
<?php include "navbar.php"; ?>

<div class="container">
<h2>Decks</h2>

<form method="post">
<input name="deck_name" placeholder="Deck Name">

<select name="player_id">
<?php
foreach($db->query("SELECT * FROM players") as $p){
    echo "<option value='{$p['player_id']}'>{$p['player_name']}</option>";
}
?>
</select>

<button name="add">Add</button>
</form>

<?php
if(isset($_POST['add'])){
    $stmt = $db->prepare("
    INSERT INTO decks(deck_name, player_id, theme, wins, losses, creation_date, format)
    VALUES (?,?,?,0,0,CURDATE(),'Standard')
    ");
    $stmt->execute([
        $_POST['deck_name'],
        $_POST['player_id'],
        "Custom Theme"
    ]);
}
?>

<table>
<tr><th>Deck</th><th>Player</th></tr>
<?php
$q = $db->query("SELECT decks.*, players.player_name FROM decks JOIN players ON decks.player_id=players.player_id");
foreach($q as $d){
echo "<tr><td>{$d['deck_name']}</td><td>{$d['player_name']}</td></tr>";
}
?>
</table>
</div>