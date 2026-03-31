<?php 
include "db.php"; 
include "navbar.php"; 
?>

<link rel="stylesheet" href="style.css">

<div class="container">
<h2>Dashboard</h2>

<?php
// Counts
$p = $db->query("SELECT COUNT(*) FROM players")->fetchColumn();
$d = $db->query("SELECT COUNT(*) FROM decks")->fetchColumn();
$t = $db->query("SELECT COUNT(*) FROM tournaments")->fetchColumn();
?>

<p><strong>Players:</strong> <?= $p ?></p>
<p><strong>Decks:</strong> <?= $d ?></p>
<p><strong>Tournaments:</strong> <?= $t ?></p>

<h3>Tournaments</h3>

<table border="1" cellpadding="8" cellspacing="0">
<tr>
    <th>Name</th>
    <th>Location</th>
    <th>Format</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Standings</th>
</tr>

<?php
$stmt = $db->query("SELECT * FROM tournaments ORDER BY start_date DESC");
while($tournament = $stmt->fetch()):
?>
<tr>
    <td><?= htmlspecialchars($tournament['tournament_name']) ?></td>
    <td><?= htmlspecialchars($tournament['location']) ?></td>
    <td><?= htmlspecialchars($tournament['format']) ?></td>
    <td><?= $tournament['start_date'] ?></td>
    <td><?= $tournament['end_date'] ?></td>
    <td>
        <a href="tournament_view.php?id=<?= $tournament['tournament_id'] ?>">View Standings</a>
    </td>
</tr>
<?php endwhile; ?>

</table>
</div>