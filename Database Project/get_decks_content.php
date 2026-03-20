<?php
include "db.php";

if(isset($_GET['deck_id'])) {
    $stmt = $db->prepare("
        SELECT c.card_name, dc.quantity, dc.card_role 
        FROM deck_cards dc
        JOIN cards c ON dc.card_id = c.card_id
        WHERE dc.deck_id = ?
    ");
    $stmt->execute([$_GET['deck_id']]);
    $items = $stmt->fetchAll();

    if($items) {
        echo "<table><tr><th>Card</th><th>Qty</th><th>Role</th></tr>";
        foreach($items as $item) {
            echo "<tr>
                    <td>".htmlspecialchars($item['card_name'])."</td>
                    <td>".$item['quantity']."</td>
                    <td>".htmlspecialchars($item['card_role'])."</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<em>No cards in this deck yet.</em>";
    }
}
?>
