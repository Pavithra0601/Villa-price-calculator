<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript">
        function showPopup() {
            alert("Data updated successfully.");
        }
    </script>
</head>
<body>
<?php
require_once("db_connection.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $project_title = $_POST["project_title"];
    $plot_rate = $_POST["plot_rate"];
    $area_1bhk = $_POST["area_1bhk"];
    $area_2bhk = $_POST["area_2bhk"];
    $area_3bhk = $_POST["area_3bhk"];
    $reg_cost = $_POST["regc"];
    $other_cost = $_POST["oc"];
    $bup_1bhk = $_POST["bup1bhk"];
    $bup_2bhk = $_POST["bup2bhk"];
    $bup_3bhk = $_POST["bup3bhk"];
    $eco_const_mat = $_POST["eco_const_mat"];
    $eco_kitchen = $_POST["eco_kitchen"];
    $eco_plumbing = $_POST["eco_plumbing"];
    $eco_door_win = $_POST["eco_door_win"];
    $eco_paint = $_POST["eco_paint"];
    $eco_tiles = $_POST["eco_tiles"];
    $eco_elec = $_POST["eco_elec"];
    $eco_misc = $_POST["eco_misc"];
    $ess_const_mat = $_POST["ess_const_mat"];
    $ess_kitchen = $_POST["ess_kitchen"];
    $ess_plumbing = $_POST["ess_plumbing"];
    $ess_door_win = $_POST["ess_door_win"];
    $ess_paint = $_POST["ess_paint"];
    $ess_tiles = $_POST["ess_tiles"];
    $ess_elec = $_POST["ess_elec"];
    $ess_misc = $_POST["ess_misc"];
    $sup_const_mat = $_POST["sup_const_mat"];
    $sup_kitchen = $_POST["sup_kitchen"];
    $sup_plumbing = $_POST["sup_plumbing"];
    $sup_door_win = $_POST["sup_door_win"];
    $sup_paint = $_POST["sup_paint"];
    $sup_tiles = $_POST["sup_tiles"];
    $sup_elec = $_POST["sup_elec"];
    $sup_misc = $_POST["sup_misc"];
    $eco_sq_ft = $_POST["ecovila"];
    $ess_sq_ft = $_POST["essvila"];
    $sup_sq_ft = $_POST["supvila"];
    $status=$_POST["status"];
    $location=$_POST["location"];


    // SQL query to insert data into the table
    $sql = "INSERT INTO construction_details (project_title, plot_rate, area_1bhk, area_2bhk, area_3bhk, reg_cost, other_cost, 
        bup_1bhk, bup_2bhk, bup_3bhk, eco_const_mat, eco_kitchen, eco_plumbing, eco_door_win, eco_paint, eco_tiles, eco_elec,
        eco_misc, ess_const_mat, ess_kitchen, ess_plumbing, ess_door_win, ess_paint, ess_tiles, ess_elec, ess_misc, 
        sup_const_mat, sup_kitchen, sup_plumbing, sup_door_win, sup_paint, sup_tiles, sup_elec, sup_misc,eco_sq_ft,ess_sq_ft,sup_sq_ft,status,location)
        VALUES ('$project_title', $plot_rate, $area_1bhk, $area_2bhk, $area_3bhk, $reg_cost, $other_cost, $bup_1bhk, $bup_2bhk, $bup_3bhk, "
        . "$eco_const_mat, $eco_kitchen, $eco_plumbing, $eco_door_win, $eco_paint, $eco_tiles, $eco_elec, $eco_misc, $ess_const_mat,"
        . "$ess_kitchen, $ess_plumbing, $ess_door_win, $ess_paint, $ess_tiles, $ess_elec, $ess_misc, $sup_const_mat, $sup_kitchen, "
        . "$sup_plumbing, $sup_door_win, $sup_paint, $sup_tiles, $sup_elec, $sup_misc,$eco_sq_ft,$ess_sq_ft,$sup_sq_ft,$status,'$location')";

if ($conn->query($sql) === TRUE) {
   echo '<script type="text/javascript">
                        showPopup();
                        window.location.href = "admin_dash.php"; // Replace with the desired admin home page URL
                  </script>';
            exit; 
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
}
?>
</body>
</html>
