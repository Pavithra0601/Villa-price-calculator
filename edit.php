<?php
require_once("db_connection.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
function formatColumnName($columnName) {
    // Define custom formatting for column names
    $columnFormats = [
        'material' => 'Construction Material',
        'kitchen' => 'Kitchen Material',
        'plumbing'=>'Plumbing Material',
        'door_window' => 'Doors & Windows',
        'paints' => 'Paints Brand',
        'tiles'=> 'Tiles ',
        'electrical'=> 'Electrical Items/Brand ',
        'misc' => 'Miscellaneous',
    ];

    return isset($columnFormats[$columnName]) ? $columnFormats[$columnName] : $columnName;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css"/>
    <link rel="stylesheet" href="table.css"/>
</head>
<body>
    <header>
        <div class="header-content">
            <img src="image/spe.png" class="logo"/>
            <p class="header-text blinking-text" style="font-size: 30px">
                &emsp;&emsp;&emsp;View / Edit Material Details
            </p>
        </div>
    </header>
    <div class="sidebar">
        <a href="admin_dash.php">Home</a>
        <a href="admin_form.php">Add Project Details</a>
        <a class="active" href="edit.php">View/Edit Material Details</a>
        <a href="logout.php">LogOut</a>
    </div>
    <div class="content">
        <?php
        $tableNames = ['eco_cons_material', 'essential_cons_material', 'superior_cons_material'];
        
        foreach ($tableNames as $table) {
            if($table=='eco_cons_material'){
               echo "<h3> Economical Villa Construction Material Details</h3>";
            }
            elseif($table=='essential_cons_material'){
                     echo "<h3> Essential Villa Construction Material Details</h3>";
            }
             else if($table=='superior_cons_material'){
                     echo "<h3> Superior Villa Construction Material Details</h3>";
            }
            echo '<table>';
            echo '<tr><th><b>Description</b></th>'
            . '<th><b>Material/Brand Used</b></th>'
                    . '<th><b>Modify</b></th></tr>';
            
            $sql = "SELECT * FROM $table";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $columnName => $columnValue) {
                        if ($columnName !== 'id') { // Exclude the 'id' column
                            echo '<tr>';
                            echo "<td>" . formatColumnName($columnName) . "</td>";
                            echo "<td>$columnValue</td>";
                            echo "<td><a href='edit_material.php?table=$table&column=$columnName'>Edit</a></td>";
                            echo '</tr>';
                        }
                    }
                }
            }
            
            echo '</table>';
        }
        ?>
    </div>
</body>
</html>
