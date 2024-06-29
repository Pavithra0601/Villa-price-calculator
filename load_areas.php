<?php
if (isset($_POST['project_title'])) {
    $projectTitle = $_POST['project_title'];
    
    require_once('db_connection.php');
    
    $plotAreas = array();
    $builtUpAreas = array();
    
    $sql = "SELECT DISTINCT plot_area, built_up_area FROM projects WHERE project_title = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $projectTitle);
    $stmt->execute();
    $stmt->bind_result($plotArea, $builtUpArea);

    while ($stmt->fetch()) {
        $plotAreas[] = $plotArea;
        $builtUpAreas[] = $builtUpArea;
    }
    
    echo json_encode(['plot_areas' => $plotAreas, 'built_up_areas' => $builtUpAreas]);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
