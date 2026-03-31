<?php
include "db.php";

$message = "";

$formats = ["Advanced", "Traditional", "Speed Duel","Common Charity"];

if(isset($_POST['add'])){
    
    $check = $db->prepare("SELECT COUNT(*) FROM tournaments WHERE tournament_name = ?");
    $check->execute([$_POST['tournament_name']]);
    
    if($check->fetchColumn() > 0) {
        $message = "<div style='color:red;'>Error: A tournament with this name already exists.</div>";
    } 
    
    elseif(strtotime($_POST['end_date']) < strtotime($_POST['start_date'])) {
        $message = "<div style='color:red;'>Error: End date cannot be before start date.</div>";
    } 
    else {
        try {
            $stmt = $db->prepare("INSERT INTO tournaments 
                (tournament_name, location, start_date, end_date, format, prize_pool, total_players) 
                VALUES (?,?,?,?,?,?,?)");

            $stmt->execute([
                $_POST['tournament_name'],
                $_POST['location'],
                $_POST['start_date'],
                $_POST['end_date'],
                $_POST['format'],
                $_POST['prize_pool'],
                $_POST['total_players']
            ]);

            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit;
        } catch (PDOException $e) {
            $message = "<div style='color:red;'>Database Error: " . $e->getMessage() . "</div>";
        }
    }
}

if(isset($_GET['success'])) $message = "<div style='color:green;'>Tournament created successfully!</div>";
?>

<link rel="stylesheet" href="style.css">
<?php include "navbar.php"; ?>

<h2>Create New Tournament</h2>

<?= $message ?>

<form method="post">

    <label>Tournament Name</label>
    <input name="tournament_name" required placeholder="e.g. Summer Championship">

    <label>Location</label>
    <input name="location" required placeholder="e.g. Local Game Store">

    <label>Start Date</label>
    <input type="date" name="start_date" required>

    <label>End Date</label>
    <input type="date" name="end_date" required>

    <label>Format</label>
    <select name="format" required>
        <option value="">-- Select Format --</option>
        <?php foreach($formats as $f): ?>
            <option value="<?= $f ?>"><?= $f ?></option>
        <?php endforeach; ?>
    </select>

    <label>Prize Pool ($)</label>
    <input type="number" step="0.01" name="prize_pool" value="0.00" min="0">

    <label>Total Players (Max Capacity)</label>
    <input type="number" name="total_players" value="0" min="0">

    <button name="add" type="submit">Create Tournament</button>

</form>
