<?php include "db.php"; ?>
<link rel="stylesheet" href="style.css">
<?php include "navbar.php"; ?>

<div class="container">
<h2>Players</h2>

<form method="post">
<input name="name" placeholder="Name">
<input name="age" placeholder="Age">
<input name="region" placeholder="Region">

<select name="rank">
<option>Rookie</option><option>Bronze</option><option>Silver</option>
<option>Gold</option><option>Platinum</option><option>Diamond</option><option>Master</option>
</select>

<input name="email" placeholder="Email">
<button name="add">Add</button>
</form>

<?php
if(isset($_POST['add'])){
    $stmt = $db->prepare("
    INSERT INTO players(player_name, age, region, rank, wins, losses, join_date, email)
    VALUES (?,?,?,?,0,0,CURDATE(),?)
    ");
    $stmt->execute([
        $_POST['name'],
        $_POST['age'],
        $_POST['region'],
        $_POST['rank'],
        $_POST['email']
    ]);
}
?>

<table>
<tr><th>Name</th><th>Rank</th></tr>
<?php
foreach($db->query("SELECT * FROM players") as $r){
    echo "<tr><td>{$r['player_name']}</td><td>{$r['rank']}</td></tr>";
}
?>
</table>
</div>