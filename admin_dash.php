<?php 
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!doctype html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="dashboard.css">
    <style>
         table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Add blinking animation */
        @keyframes blinking-text {
            0%, 100% { color: #fff; }
            50% { color: #000; }
        }
    </style>
</head>
<body>
<header>
    <div class="header-content">
        <img src="image/spe.png" class="logo"/>
        <p class="header-text blinking-text" style="font-family: cursive; font-size:30px">
            Admin Dashboard
        </p>
    </div>
</header>
<div class="sidebar">
    <a class="active" href="admin_dash.php">Home</a>
    <a href="admin_form.php">Add Project Details</a>
    <a href="edit.php">View/Edit Material</a>
    <a href="logout.php">LogOut</a>
</div>
<div class="content">
    <h3>Current Project Details</h3>
    <input type="text" id="search-input" placeholder="Search by Title, Location, or Status">
    <table>
        <tr>
            <td><b>Action</b></td>
            <td><b>Project Title</b></td>
            <td><b>Project Location</b></td>
            <td><b>Plot Rate</b></td>
            <td><b>Economical Cost /Sq.ft</b></td>
            <td><b>Essential Cost /Sq.ft</b></td>
            <td><b>Superior Cost /Sq.ft</b></td>
            <td><b>Project Status</b></td>
        </tr>
    <?php 
    require_once("db_connection.php");
    
     $sql1="SELECT * from construction_details order by status";
            $stmt = $conn->prepare($sql1);
            $stmt->execute();
            $result = $stmt->get_result();
              if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $status=$row['status'];
    
    ?>
   
        <tr>
            <td><b><a href="edit_data.php?project_title=<?php echo urlencode($row['project_title']); ?>">Edit</a></b></td>
            <td><b><?php echo strtoupper($row['project_title']);?></b></td>
            <td><?php echo $row['location'];?></td>
            <td>₹  <?php echo $row['plot_rate'];?></td>
            <td>₹  <?php echo $row['eco_sq_ft'];?></td>
            <td>₹  <?php echo $row['ess_sq_ft'];?></td>
            <td>₹  <?php echo $row['sup_sq_ft']; ?></td>
            <td><?php 
            if($status==1){
                echo "<span style='color:darkgreen'><b>Active</b></span>";
                }
                else{
                    echo "<span style='color:red'><b>InActive</b></span>";
            }
            ?></td><?php } ?>
            
        </tr>
    </table> 
    
    
    
    </div>
<script>
    // Get the search input field and the table body
    const searchInput = document.getElementById('search-input');
    const table = document.querySelector('table');
    const rows = table.querySelectorAll('tr');

    // Add input event listener to the search input field
    searchInput.addEventListener('input', searchTable);

    function searchTable() {
        const query = searchInput.value.toLowerCase();

        // Loop through all rows in the table (start from index 1 to skip the header row)
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const title = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const location = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const status = row.querySelector('td:nth-child(8)').textContent.toLowerCase();

            // Check if the row matches the search query
            if (title.includes(query) || location.includes(query) || status.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
</script>
</body>
              <?php 
              }
              ?>