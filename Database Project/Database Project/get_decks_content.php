<?php
include "db.php";

if(isset($_GET['deck_id'])) {
    // Fetch deck cards grouped purely by card
    $stmt = $db->prepare("
        SELECT 
            c.card_id, 
            c.card_name, 
            SUM(dc.quantity) as total_qty,
            GROUP_CONCAT(DISTINCT dc.card_role SEPARATOR ', ') as roles,
            GROUP_CONCAT(DISTINCT dc.note SEPARATOR ', ') as notes
        FROM deck_cards dc
        JOIN cards c ON dc.card_id = c.card_id
        WHERE dc.deck_id = ?
        GROUP BY c.card_id, c.card_name
        ORDER BY c.card_name
    ");
    $stmt->execute([$_GET['deck_id']]);
    $items = $stmt->fetchAll();

    if($items) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Card</th><th>Quantity</th><th>Roles</th><th>Notes</th></tr>";
        foreach($items as $item) {
            $qty = $item['total_qty'];
            $roles = htmlspecialchars($item['roles']);
            $notes = htmlspecialchars($item['notes']);
            $cardName = htmlspecialchars($item['card_name']);
            
            echo "<tr>
                    <td>{$cardName}</td>
                    <td>{$qty}</td>
                    <td>{$roles}</td>
                    <td>{$notes}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<em>No cards in this deck yet.</em>";
    }
}
?>