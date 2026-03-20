<?php include "db.php"; ?>
<link rel="stylesheet" href="style.css">
<?php include "navbar.php"; ?>

<div class="container">
<h2>Dashboard</h2>

<?php
$p = $db->query("SELECT COUNT(*) FROM players")->fetchColumn();
$d = $db->query("SELECT COUNT(*) FROM decks")->fetchColumn();
$t = $db->query("SELECT COUNT(*) FROM tournaments")->fetchColumn();
?>

<p>Players: <?= $p ?></p>
<p>Decks: <?= $d ?></p>
<p>Tournaments: <?= $t ?></p>
</div>