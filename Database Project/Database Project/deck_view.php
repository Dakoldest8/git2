<?php include "db.php"; ?>
<link rel="stylesheet" href="style.css">
<?php include "navbar.php"; ?>

<div class="container">
<?php $id = $_GET['id']; ?>

<h2>Deck Cards</h2>

<form method="post">
<select name="card_id">
<?php
foreach($db->query("SELECT * FROM cards") as $c){
    echo "<option value='{$c['card_id']}'>{$c['card_name']}</option>";
}
?>
</select>

<input name="qty" placeholder="Qty">
<button name="add">Add</button>
</form>

<?php
if(isset($_POST['add'])){
    // Specify columns explicitly: deck_id, card_id, quantity
    $stmt = $db->prepare("INSERT INTO deck_cards (deck_id, card_id, quantity) VALUES (?, ?, ?)");
    $stmt->execute([$id, $_POST['card_id'], $_POST['qty']]);
}
?>
</div>