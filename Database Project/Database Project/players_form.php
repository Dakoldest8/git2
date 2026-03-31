<?php
include "db.php";

if(isset($_POST['add'])){
    $stmt = $db->prepare("INSERT INTO players (player_name,age,region,`rank`,join_date,email) VALUES (?,?,?,?,?,?)");

    $stmt->execute([$_POST['player_name'],
    $_POST['age'],
    $_POST['region'],
    $_POST['rank'],
    $_POST['join_date'],
    $_POST['email']
    ]);
}


if(isset($_GET['delete'])){
    $db->exec("DELETE FROM players WHERE player_id = " . $_GET['delete']);
}
?>

<link rel="stylesheet" href="style.css">
<?php include "navbar.php"; ?>

<h2>Players Form</h2>

<form method="post">

Player Name
<input name="player_name">

Age
<input name="age">

Region
<select name="region">
    <option value="NA">North America</option>
    <option value="EU">Europe</option>
    <option value="LA">Latin America</option>
    <option value="OC">Oceania</option>
    <option value="AS">Asia</option>
    <option value="JP">Japan</option>
</select>

Rank
<select name="rank">
    <option value="Rookie">Rookie</option>
    <option value="Bronze">Bronze</option>
    <option value="Gold">Gold</option>
    <option value="Platinum">Platinum</option>
    <option value="Diamond">Diamond</option>
    <option value="Master">Master</option>
</select>

Join Date
<input name="join_date" type="date">

Email
<input name="email">

<button name="add">Add Player</button>

</form>

<h3>Players list</h3>

<table border="1">
    <tr>
        <th>Name</th>
        <th>Rank</th>
        <th>Delete</th>
    </tr>

<?php
$rows = $db->query("SELECT * FROM players");

foreach($rows as $r){
    echo "<tr>";
    echo "<td>" . $r['player_name'] . "</td>";
    echo "<td>" . $r['rank'] . "</td>";
    echo "<td><a href='?delete=" . $r['player_id'] . "'>Delete</a></td>";
    echo "</tr>";
}
?>

</table>