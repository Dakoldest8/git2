<?php include "db.php"; ?>
<link rel="stylesheet" href="style.css">
<?php include "navbar.php"; ?>

<div class="container">
<?php $id = $_GET['id']; ?>

<table>
<tr><th>Player</th><th>Win %</th></tr>

<?php
$q=$db->query("
SELECT players.player_name,
ROUND(SUM(CASE WHEN placement=1 THEN 1 ELSE 0 END)/COUNT(*)*100,1) as win_rate
FROM tournament_players
JOIN players ON tournament_players.player_id=players.player_id
WHERE tournament_id=$id
GROUP BY players.player_id
");

foreach($q as $r){
echo "<tr><td>{$r['player_name']}</td><td>{$r['win_rate']}%</td></tr>";
}
?>
</table>
</div>