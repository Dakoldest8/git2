<?php
include "db.php";

// Fetch decks and cards for the dropdowns
$decks = $db->query("SELECT deck_id, deck_name FROM decks ORDER BY deck_name")->fetchAll();
$cards = $db->query("SELECT card_id, card_name FROM cards ORDER BY card_name")->fetchAll();

if(isset($_POST['add'])){
    $deck_id = $_POST['deck_id'];
    $card_id = $_POST['card_id'];
    $quantity = (int)$_POST['quantity'];
    $card_role = $_POST['card_role'];
    $note = $_POST['note'];

    // Check if the card is already in the deck
    $stmt = $db->prepare("SELECT quantity FROM deck_cards WHERE deck_id = ? AND card_id = ?");
    $stmt->execute([$deck_id, $card_id]);
    $existing = $stmt->fetchColumn();

    if($existing !== false){
        // Update quantity, ensure it doesn't exceed 60
        $newQty = min(60, $existing + $quantity);
        $update = $db->prepare("UPDATE deck_cards SET quantity = ?, card_role = ?, note = ? WHERE deck_id = ? AND card_id = ?");
        $update->execute([$newQty, $card_role, $note, $deck_id, $card_id]);
    } else {
        // Insert new card
        $insert = $db->prepare("INSERT INTO deck_cards (deck_id, card_id, quantity, card_role, note) VALUES (?,?,?,?,?)");
        $insert->execute([$deck_id, $card_id, $quantity, $card_role, $note]);
    }

    header("Location: " . $_SERVER['PHP_SELF']); // Refresh to show the updated deck
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

            <label>Quantity (Max 60)</label>
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

    fetch('get_decks_content.php?deck_id=' + deckId)
        .then(response => response.text())
        .then(html => {
            content.innerHTML = html;
        });
}
</script>