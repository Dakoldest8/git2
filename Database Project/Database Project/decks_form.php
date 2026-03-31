<?php
include "db.php";

$players = $db->query("SELECT player_id, player_name FROM players")->fetchAll(PDO::FETCH_ASSOC);
$formats = ["Advanced", "Traditional", "Speed Duel","Common Charity"];

if(isset($_POST['add'])){
$stmt=$db->prepare("INSERT INTO decks
(deck_name,player_id,theme,creation_date,format)
VALUES (?,?,?,?,?)");

$stmt->execute([
    $_POST['deck_name'],
    (int)$_POST['player_id'],
    $_POST['theme'],
    $_POST['creation_date'],
    $_POST['format']
]);
}
?>

<link rel="stylesheet" href="style.css">
<?php include "navbar.php"; ?>

<h2>Decks Form</h2>

<form method="post">

Deck Name
<input name="deck_name">

Player ID
<select name="player_id" required>
    <option value="">-- Select Player --</option>
    <?php foreach($players as $p): ?>
        <option value="<?= $p['player_id'] ?>">
            <?= $p['player_name'] ?>
        </option>
    <?php endforeach; ?>
</select>

Theme
<input name="theme">

Creation Date
<input type="date" name="creation_date">

Format
<label>Format</label>
    <select name="format" required>
        <option value="">-- Select Format --</option>
        <?php foreach($formats as $f): ?>
            <option value="<?= $f ?>"><?= $f ?></option>
        <?php endforeach; ?>
    </select>

<button name="add">Add Deck</button>

</form>
