<?php
include 'db.php';

if(isset($_POST['add'])){
    $stmt = $db->prepare("INSERT INTO cards
    (card_name,card_type,attribute,stars,atk,def,description,rarity,release_date) VALUES (?,?,?,?,?,?,?,?,?)");

    $stmt->execute([$_POST['card_name'],
    $_POST['card_type'],
    $_POST['attribute'],
    $_POST['stars'],
    $_POST['atk'],
    $_POST['def'],
    $_POST['description'],
    $_POST['rarity'],
    $_POST['release_date']
    ]);
}

if(isset($_GET['delete'])){
    $db->exec("DELETE FROM cards WHERE card_id = " . $_GET['delete']);
}
?>

<link rel="stylesheet" href="style.css">
<?php include "navbar.php"; ?>

<h2>Cards Form</h2>

<form method="post">

Card Name
<input name="card_name">

Card Type
<select name="card_type">
    <option value="Monster">Monster</option>
    <option value="Spell">Spell</option>
    <option value="Trap">Trap</option>
</select>

Attribute
<select name="attribute">
    <option value="Dark">Dark</option>
    <option value="Light">Light</option>
    <option value="Earth">Earth</option>
    <option value="Water">Water</option>
    <option value="Fire">Fire</option>
    <option value="Wind">Wind</option>
    <option value="Divine">Divine</option>
</select>

Stars
<input name="stars" type="number">

ATK
<input name="atk" type="number">

DEF
<input name="def" type="number">

Description
<input name="description">

Rarity
<select name="rarity">
    <option value="C">Common</option>
    <option value="NC">Normal Common</option>
    <option value="SPC">Short Print Common</option>
    <option value="SSP">Super Short Print Common</option>
    <option value="R">Rare</option>
    <option value="SR">Super Rare</option>
    <option value="HRF"> Holofoil Rare</option>
    <option value="UR">Ultra Rare</option>
    <option value="URP"> Ultra Rare (Pharaoh's Rare)</option>
    <option value="UtR">Ultimate Rare</option>
    <option value="ScR">Secret Rare</option>
    <option value="QSrR">Quarter Century Secret Rare</option>
    <option value="UScR">Ultra Secret Rare</option>
    <option value="ScUR">Secret Ultra Rare</option>
    <option value="PScR">Prismatic Secret Rare</option>
    <option value="PC">Parallel Common</option>
    <option value="PR">Parallel Rare</option>
    <option value="SPR">Super Parallel Rare</option>
    <option value="UPR">Ultra Parallel Rare</option>
    <option value="CR">Collector's Rare</option>
    <option value="MR">Millennium Rare</option>
    <option value="SFR">Starfoil Rare</option>
    <option value="SLR">Starlight Rare</option>
    <option value="GR">Ghost Rare</option>
    <option value="GUR">Gold Ultra Rare</option>
    <option value="GScR">Gold Secret Rare</option>
    <option value="PG">Premium Gold Rare</option>
    <option value="10000ScR">10000 Secret Rare</option>
</select>

Release Date
<input name="release_date" type="date">

<button name="add">Add Card</button>

</form>




