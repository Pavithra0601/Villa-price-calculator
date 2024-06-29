<?php
require_once("db_connection.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['table']) && isset($_POST['column'])) {
    $table = $_POST['table'];
    $column = $_POST['column'];

    // Check if the provided table and column are valid
    $validTables = ['eco_cons_material', 'essential_cons_material', 'superior_cons_material'];
    $validColumns = ['material', 'kitchen', 'plumbing', 'door_window', 'paints', 'tiles', 'electrical', 'misc'];

    if (in_array($table, $validTables) && in_array($column, $validColumns)) {
        // Get the updated value from the form
        $updatedValue = $_POST[$column];

        // Update the data in the database
        $sql = "UPDATE $table SET $column = ? WHERE $column IS NOT NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $updatedValue);

        if ($stmt->execute()) {
            // Data updated successfully
            header("Location: edit.php");
        } else {
            echo "Error updating data: " . $conn->error;
        }
    } else {
        echo "Invalid table or column.";
    }
} else {
    echo "Invalid request.";
}
?>
