<?php include "db.php"; ?>
<link rel="stylesheet" href="style.css">
<?php include "navbar.php"; ?>

<div class="container">
<h2>Tournaments</h2>

<table>
<tr><th>Name</th><th>Location</th></tr>
<?php
foreach($db->query("SELECT * FROM tournaments") as $t){
echo "<tr><td>{$t['tournament_name']}</td><td>{$t['location']}</td></tr>";
}
?>
</table>
</div>