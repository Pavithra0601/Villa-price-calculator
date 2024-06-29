<?php
require_once('db_connection.php');

if (isset($_POST['location'])) {
    $location = $_POST['location'];

   if (isset($_POST['action']) && $_POST['action'] === 'get_project_title') {
    // Fetch project titles
    $sql = "SELECT DISTINCT project_title FROM construction_details WHERE location = ?"; // Use a placeholder
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $location); // Bind one parameter
    $stmt->execute();
    $result = $stmt->get_result();

    $options = '<option value="">--Select Project Title--</option>';
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['project_title'] . "'>" . $row['project_title'] . "</option>";
    }

    echo $options;
}

    } 
    
    if (isset($_POST['project_title'])) {
        $project_title = $_POST['project_title'];

        if (isset($_POST['action']) && $_POST['action'] === 'get_area') {
            error_log('get_area action received'); // Log the action
            // Fetch area (1BHK, 2BHK, 3BHK) options
            $sql = "SELECT area_1bhk, area_2bhk, area_3bhk FROM construction_details WHERE location = ? AND project_title = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $location, $project_title);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $options = '<option value="">--Select Area--</option>';
            if (!empty($row['area_1bhk'])) {
                $options .= "<option value=". $row['area_1bhk'] .">" . $row['area_1bhk'] . " Sq.ft.</option>";
            }
            if (!empty($row['area_2bhk'])) {
                $options .= "<option value=". $row['area_2bhk'] .">" . $row['area_2bhk'] . " Sq.ft.</option>";
            }
            if (!empty($row['area_3bhk'])) {
                $options .= "<option value=". $row['area_3bhk'] . ">" . $row['area_3bhk'] . " Sq.ft.</option>";
            }

            echo $options;
        } 
        
        if (isset($_POST['action']) && $_POST['action'] === 'get_bup_area') {
            // Fetch built-up area (1BHK, 2BHK, 3BHK) options
            $sql = "SELECT bup_1bhk, bup_2bhk, bup_3bhk FROM construction_details WHERE location = ? AND project_title = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $location, $project_title);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $options = '<option value="">--Select Built-Up Area--</option>';
            if (!empty($row['bup_1bhk'])) {
                $options .= "<option value=". $row['bup_1bhk'] . ">" . $row['bup_1bhk'] . " Sq.ft.</option>";
            }
            if (!empty($row['bup_2bhk'])) {
                $options .= "<option value=" . $row['bup_2bhk'] . ">" . $row['bup_2bhk'] . " Sq.ft.</option>";
            }
            if (!empty($row['bup_3bhk'])) {
                $options .= "<option value=" . $row['bup_3bhk'] . ">" . $row['bup_3bhk'] . " Sq.ft.</option>";
            }

            echo $options;
        }
    }

?>
