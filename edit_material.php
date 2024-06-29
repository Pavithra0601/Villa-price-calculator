<?php
require_once("db_connection.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$tableFormats = [
    'eco_cons_material' => 'Economical Villa Construction Material Updation Form',
    'essential_cons_material' => 'Essential Villa Construction Material Updation Form',
    'superior_cons_material' => 'Superior Villa Construction Material Updation Form',
];

$columns = ['material', 'kitchen', 'plumbing', 'door_window', 'paints', 'tiles', 'electrical', 'misc'];


function formatTableName($table) {
    global $tableFormats; // Access the global array
    return isset($tableFormats[$table]) ? $tableFormats[$table] : $table;
}

function formatColumnName($column) {
    // Define custom formatting for column names
    $columnFormats = [
        'material' => 'Construction Material',
        'kitchen' => 'Kitchen Material',
        'plumbing' => 'Plumbing Material',
        'door_window' => 'Doors & Windows',
        'paints' => 'Paints Brand',
        'tiles' => 'Tiles',
        'electrical' => 'Electrical Items/Brand',
        'misc' => 'Miscellaneous',
    ];

    return isset($columnFormats[$column]) ? $columnFormats[$column] : $column;
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['table']) && isset($_GET['column'])) {
    $table = $_GET['table'];
    $column = $_GET['column'];


    // Check if the provided table and column are valid
     if (array_key_exists($table, $tableFormats) && in_array($column, $columns)) {
        // Retrieve the specific row from the database based on the table and column
        $sql = "SELECT * FROM $table WHERE $column IS NOT NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Edit Material</title>
                   <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <link rel="stylesheet" href="dashboard.css"/>
            </head>
            <body>
               
                    <header>
        <div class="header-content">
            <img src="image/spe.png" class="logo"/>
                <p class=" header-text blinking-text " style="font-family: cursive;font-size: 30px">
                  Admin Dashboard
                </p>
        </div>
    </header>
    <div class="sidebar">
        <a href="admin_dash.php">Home</a>
        <a href="admin_form.php">Add Project Details</a>
        <a class="active" href="edit.php">View/Edit Material </a>
        <a href="logout.php">LogOut</a>
    </div>
    <div class="content">
         <h3>Edit Material</h3>
                <style>
                    /* Define your CSS styles here */
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f2f2f2;
                        margin: 0;
                        padding: 0;
                        padding-top: 70px; 
                    }

                    h1 {
                        color: #333;
                    }

                    form {
                        max-width: 500px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #fff;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }

                    label {
                        display: block;
                        margin-bottom: 10px;
                        font-weight: bold;
                    }

                    textarea {
                        width: 90%;
                        height: 150px;
                        padding: 10px;
                        margin-bottom: 10px;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        resize: none;
                    }

                    input[type="submit"] {
                        background-color: #333;
                        color: #fff;
                        padding: 10px 20px;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                    }

                    input[type="submit"]:hover {
                        background-color: #555;
                    }
                </style>
                <form action="update_material.php" method="POST">
                    <input type="hidden" name="table" value="<?php echo $table; ?>">
                    <input type="hidden" name="column" value="<?php echo $column; ?>">
                    <?php
                    echo "<label for='$table'>" . formatTableName($table) . "</label>";
                    echo "<label for='$column'>" . formatColumnName($column) . ":</label>";
                    echo "<textarea name='$column' rows='4' cols='50'>" . htmlspecialchars($row[$column]) . "</textarea><br>";
                    ?>

                    <input type="submit" value="Update">
                </form>
    </div>
                 <script>
let unsavedChanges = false;
let formSubmitted = false;

// Listen for changes in form fields
const formInputs = document.querySelectorAll('input, select, textarea');
formInputs.forEach(function(input) {
    input.addEventListener('input', function() {
        unsavedChanges = true;
    });
});

// Handle the beforeunload event to show a confirmation dialog
window.addEventListener('beforeunload', function (event) {
    if (unsavedChanges && !formSubmitted) {
        event.preventDefault();
        event.returnValue = 'You have unsaved changes. Are you sure you want to leave this page?';
    }
});

// Add an event listener to the "Update" button to set formSubmitted to true
const updateButton = document.querySelector('input[type="submit"]');
updateButton.addEventListener('click', function() {
    formSubmitted = true;
});

// You can also provide a confirmation dialog when a user explicitly tries to leave the page
window.addEventListener('unload', function (event) {
    if (unsavedChanges && !formSubmitted) {
        return 'You have unsaved changes. Are you sure you want to leave this page?';
    }
});
</script>

            </body>
            </html>
            <?php
        } else {
            echo "Row not found.";
        }
    } else {
        echo "Invalid table or column.";
    }
} else {
    echo "Invalid request.";
}
?>