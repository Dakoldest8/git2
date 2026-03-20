<?php
include "db.php";


$decks = $db->query("SELECT deck_id, deck_name FROM decks ORDER BY deck_name")->fetchAll();
$cards = $db->query("SELECT card_id, card_name FROM cards ORDER BY card_name")->fetchAll();

if(isset($_POST['add'])){
    $stmt=$db->prepare("INSERT INTO deck_cards (deck_id,card_id,quantity,card_role,note) VALUES (?,?,?,?,?)");
    $stmt->execute([
        $_POST['deck_id'],
        $_POST['card_id'],
        $_POST['quantity'],
        $_POST['card_role'],
        $_POST['note']
    ]);
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh to show the new card in the preview
    exit;
}
?>


<link rel="stylesheet" href="style.css">
<?php include "navbar.php"; ?>

<div style="display: flex; gap: 20px;">
    
   
    <div style="flex: 1;">
        <h2>Deck Cards Form</h2>
        <form method="post">
            <label>Select Deck</label>
            <select name="deck_id" id="deck_select" required onchange="updatePreview()">
                <option value="">-- Choose Deck --</option>
                <?php foreach($decks as $d): ?>
                    <option value="<?= $d['deck_id'] ?>"><?= htmlspecialchars($d['deck_name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Select Card</label>
            <select name="card_id" required>
                <option value="">-- Choose Card --</option>
                <?php foreach($cards as $c): ?>
                    <option value="<?= $c['card_id'] ?>"><?= htmlspecialchars($c['card_name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Quantity</label>
            <input type="number" name="quantity" min="1" max="60" value="1">

            <label>Card Role</label>
            <input name="card_role" placeholder="e.g. Main Deck">

            <label>Note</label>
            <input name="note">

            <button name="add">Add Card to Deck</button>
        </form>
    </div>

    
    <div id="deck-preview" style="flex: 0 0 35%; padding: 20px; border: 1px solid #ffffff; background: #0c0c0c;">
        <h3>Deck Preview</h3>
        <div id="preview-content">Select a deck to see cards...</div>
    </div>

</div>


<script>
function updatePreview() {
    const deckId = document.getElementById('deck_select').value;
    const content = document.getElementById('preview-content');
    
    if (!deckId) {
        content.innerHTML = "Select a deck to see cards...";
        return;
    }

    fetch('get_deck_contents.php?deck_id=' + deckId)
        .then(response => response.text())
        .then(html => {
            content.innerHTML = html;
        });
}
</script>
