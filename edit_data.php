<?php
   
    require_once("db_connection.php");
    session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>
<!doctype html>
<head>
    <title>
        Admin Dashboard
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin_form.css">
    <link rel="stylesheet" href="dashboard.css">

</head>
<body>
    <header>
        
        <div class="header-content">
            <img src="image/spe.png" class="logo"/>
                <p class=" header-text blinking-text " style="font-family: cursive;font-size: 30px">
                 Edit Project Details
                </p>
           </div>
    </header>
    <div class="sidebar">
        <a href="admin_dash.php">Home</a>
        <a href="admin_form.php">Add Project Details</a>
        <a class="active"  href="edit_data.php">Edit Project Details</a>
        <a  href="edit.php">View/Edit Materials</a>
        <a href="logout.php">LogOut</a>
        
    </div>
    <div class="content">
<?php 


if (!isset($project_title)) {
$project_title = $_GET['project_title'];
//    $pro=$_POST['project'];
  $sql="select * from construction_details where project_title='$project_title'";
            $stmt = $conn->prepare($sql);
           

            $stmt->execute();
            $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $project_title= $row['project_title'];
                
                
                ?>
                <div class="container mt-4">

        <br><form action="data_update.php" method="post">
        
        <div class="row">
            <div class="col-md-6">
                <!-- Left Card: Plot Cost Details -->
                <div class="form-card">
                    <h4>Plot Cost Details</h4>
                    <div class="table-container">
                        <table class="table table-bordered">
                            <tr>
                                <td>Project Title:</td>
                                <td><input type="text" class="form-control" value="<?php echo htmlspecialchars($row['project_title']); ?>" id="project_title" name="project_title" required=""></td>
                            </tr>
                            <tr>
                                <td>Plot Rate:</td>
                                <td><input type="text" class="form-control" value="<?php echo htmlspecialchars($row['plot_rate']); ?>" id="plot_rate" name="plot_rate" required=""></td>
                            </tr>
                            <tr>
                                <td>Plot Area(1BHK):</td>
                                <td><input type="text" class="form-control" value="<?php echo htmlspecialchars($row['area_1bhk']); ?>" id="1bhk" name="area_1bhk"required="" ></td>
                            </tr>
                            <tr>
                                <td>Plot Area(2BHK):</td>
                                <td><input type="text" class="form-control" id="2bhk" value="<?php echo htmlspecialchars($row['area_2bhk']); ?>" name="area_2bhk" required=""></td>
                            </tr>
                            <tr>
                                <td>Plot Area(3BHK):</td>
                                <td><input type="text" class="form-control" id="3bhk" value="<?php echo htmlspecialchars($row['area_3bhk']); ?>" name="area_3bhk"  required=""></td>
                            </tr>
                            <tr>
                                <td>Registration Cost(%):</td>
                                <td><input type="text" class="form-control" id="regc" value="<?php echo htmlspecialchars($row['reg_cost']); ?>" name="regc" required=""></td>
                            </tr>
                            <tr>
                                <td>Other Cost:</td>
                                <td><input type="text" class="form-control" id="oc" value="<?php echo htmlspecialchars($row['other_cost']); ?>" name="oc" required=""></td>
                            </tr>
                            </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Right Card: Construction Cost Details -->
                <div class="form-card">
                    <h4>Construction Details</h4>
                    <div class="table-container">
                        <table class="table table-bordered">
<!--                            <tr>
                                <th>Item</th>
                                <th>Value</th>
                            </tr>-->
                            <tr>
                                <td>Builtup Area-1BHK:</td>
                                <td><input type="text" class="form-control" id="bup1bhk" value="<?php echo htmlspecialchars($row['bup_1bhk']); ?>" name="bup1bhk" required=""></td>
                            </tr>
                             <tr>
                                <td>Builtup Area-2BHK:</td>
                                <td><input type="text" class="form-control" id="bup2bhk" value="<?php echo htmlspecialchars($row['bup_2bhk']); ?>"  name="bup2bhk" required=""></td>
                            </tr>
                             <tr>
                                <td>Builtup Area-3BHK:</td>
                                <td><input type="text" class="form-control" id="bup3bhk" value="<?php echo htmlspecialchars($row['bup_3bhk']); ?>"  name="bup3bhk" required=""></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center"><h5>Construction Cost Per Sq.Ft</h5></td>
                            </tr>
                            <tr>
                                <td>Economical Villa :</td>
                                <td><input type="text" class="form-control" id="ecovila" value="<?php echo htmlspecialchars($row['eco_sq_ft']); ?>"  name="ecovila" readonly></td>
                            </tr>
                            <tr>
                                <td>Essential Villa :</td>
                                <td><input type="text" class="form-control" id="essvila" value="<?php echo htmlspecialchars($row['ess_sq_ft']); ?>"  name="essvila" readonly></td>
                            </tr>
                            <tr>
                                <td >Superior Villa :</td>
                                <td><input type="text" class="form-control" id="supvila" value="<?php echo htmlspecialchars($row['sup_sq_ft']); ?>"  name="supvila" readonly></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            <br><br>
        <!-- Construction Cost Tables -->
        <div class="row mt-2">
    <div class="col-md-4">
        <div class="form-card">
            <h5>Economical Villa Construction Cost</h5>
            <div class="table-container">
                <table class="table table-bordered">
                   <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Description</th>
                                    <th>Cost/Sq.ft</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>Construction Material</td>
                                    <td><input type="text" id="eco_const_mat" value="<?php echo htmlspecialchars($row['eco_const_mat']); ?>" name="eco_const_mat" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Kitchen</td>
                                    <td><input type="text" id="eco_kitchen" value="<?php echo htmlspecialchars($row['eco_kitchen']); ?>" name="eco_kitchen" class="form-control" required="" ></td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Plumbing</td>
                                    <td><input type="text" id="eco_plumbing" value="<?php echo htmlspecialchars($row['eco_plumbing']); ?>" name="eco_plumbing" class="form-control" required="" ></td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>Door & Window</td>
                                    <td><input type="text" id="eco_door_win" value="<?php echo htmlspecialchars($row['eco_door_win']); ?>" name="eco_door_win" class="form-control"  required=""></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>Paint</td>
                                    <td><input type="text" id="eco_paint" value="<?php echo htmlspecialchars($row['eco_paint']); ?>" name="eco_paint" class="form-control" required="" ></td>
                                </tr>
                                <tr>
                                    <td>6.</td>
                                    <td>Tiles</td>
                                    <td><input type="text" id="eco_tiles" value="<?php echo htmlspecialchars($row['eco_tiles']); ?>" name="eco_tiles" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>7.</td>
                                    <td>Electrical</td>
                                    <td><input type="text" id="eco_elec" value="<?php echo htmlspecialchars($row['eco_elec']); ?>" name="eco_elec" class="form-control"  required=""></td>
                                </tr>
                                <tr>
                                    <td>8.</td>
                                    <td>Miscellaneous</td>
                                    <td><input type="text" id="eco_misc" value="<?php echo htmlspecialchars($row['eco_misc']); ?>" name="eco_misc" class="form-control"required="" ></td>
                                </tr>
                                 <tr>
                                    <td colspan="2" align="center">Total</td>
                                    <td><input type="text" class="form-control" id="ecovila1" value="<?php echo htmlspecialchars($row['eco_sq_ft']); ?>"  name="ecovila1" readonly></td>
                                </tr>
                                
                           
                            </tbody>
                </table>
            </div>
        </div>
    </div><br><br>
    <div class="col-md-4">
        <div class="form-card">
            <h5>Essential Villa Construction Cost</h5>
            <div class="table-container">
                <table class="table table-bordered">
                     <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Description</th>
                                    <th>Cost/Sq.ft</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>Construction Material</td>
                                    <td><input type="text" id="ess_const_mat" value="<?php echo htmlspecialchars($row['ess_const_mat']); ?>" name="ess_const_mat" class="form-control" required="" ></td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Kitchen</td>
                                    <td><input type="text" id="ess_kitchen" value="<?php echo htmlspecialchars($row['ess_kitchen']); ?>" name="ess_kitchen" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Plumbing</td>
                                    <td><input type="text" id="ess_plumbing" value="<?php echo htmlspecialchars($row['ess_plumbing']); ?>"  name="ess_plumbing" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>Door & Window</td>
                                    <td><input type="text" id="ess_door_win" value="<?php echo htmlspecialchars($row['ess_door_win']); ?>"  name="ess_door_win" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>Paint</td>
                                    <td><input type="text" id="ess_paint" value="<?php echo htmlspecialchars($row['ess_paint']); ?>"  name="ess_paint" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>6.</td>
                                    <td>Tiles</td>
                                    <td><input type="text" id="ess_tiles" value="<?php echo htmlspecialchars($row['ess_tiles']); ?>" name="ess_tiles" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>7.</td>
                                    <td>Electrical</td>
                                    <td><input type="text" id="ess_elec" value="<?php echo htmlspecialchars($row['ess_elec']); ?>"  name="ess_elec" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>8.</td>
                                    <td>Miscellaneous</td>
                                    <td><input type="text" id="ess_misc" value="<?php echo htmlspecialchars($row['ess_misc']); ?>"  name="ess_misc" class="form-control" required=""></td>
                                </tr>
                                 <tr>
                                    <td colspan="2" align="center">Total</td>
                                    <td><input type="text" class="form-control" id="essvila1"  value="<?php echo htmlspecialchars($row['ess_sq_ft']); ?>" name="essvila1" readonly></td>
                                </tr>
                                
                           
                            </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-card">
            <h5>Superior Villa Construction Cost</h5>
            <div class="table-container">
                <table class="table table-bordered">
                     <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Description</th>
                                    <th>Cost/Sq.ft</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>Construction Material</td>
                                    <td><input type="text" id="sup_const_mat"  value="<?php echo htmlspecialchars($row['sup_const_mat']); ?>" name="sup_const_mat" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Kitchen</td>
                                    <td><input type="text" id="sup_kitchen"  value="<?php echo htmlspecialchars($row['sup_kitchen']); ?>"   name="sup_kitchen" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Plumbing</td>
                                    <td><input type="text" id="sup_plumbing"  value="<?php echo htmlspecialchars($row['sup_plumbing']); ?>" name="sup_plumbing" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>Door & Window</td>
                                    <td><input type="text" id="sup_door_win"  value="<?php echo htmlspecialchars($row['sup_door_win']); ?>"   name="sup_door_win" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>Paint</td>
                                    <td><input type="text" id="sup_paint"  value="<?php echo htmlspecialchars($row['sup_paint']); ?>"   name="sup_paint" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>6.</td>
                                    <td>Tiles</td>
                                    <td><input type="text" id="sup_tiles"  value="<?php echo htmlspecialchars($row['sup_tiles']); ?>" name="sup_tiles" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>7.</td>
                                    <td>Electrical</td>
                                    <td><input type="text" id="sup_elec"  value="<?php echo htmlspecialchars($row['sup_elec']); ?>" name="sup_elec" class="form-control" required=""></td>
                                </tr>
                                <tr>
                                    <td>8.</td>
                                    <td>Miscellaneous</td>
                                    <td><input type="text" id="sup_misc"  value="<?php echo htmlspecialchars($row['sup_misc']); ?>" name="sup_misc" class="form-control" required=""></td>
                                </tr>
                                 <tr>
                                    <td colspan="2" align="center">Total</td>
                                    <td><input type="text" class="form-control" id="supvila1"  value="<?php echo htmlspecialchars($row['sup_sq_ft']); ?>" name="supvila1" readonly></td>
                                </tr>
                                
                           
                            </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br><br>
<div class="col-md-14">
        <div class="form-card">
             <div class="table-container">
                 <table class="table table-bordered">
                     <tr>
                         <td>Project Current Status :</td>
                         <td><select name="status" id="status" class="form-control">
                                 <?php $status=$row['status'];
                                 if($status=='1'){
                                     echo '<option value="1">Current Status : Active</option>';
                                 }
                                 if($status=='2'){
                                     echo '<option value="2">Current Status : InActive</option>';
                                 }
                                 ?>
                                <option value="1" >Active</option>
                                <option value="2">InActive</option>
                            </select>
                         </td>
                     </tr>
                     <tr>
                         <td>Project Location</td>
                         <td><input type="text" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" id="loaction" class="form-control" required=""></td>
                     </tr>
                     
                 </table>
            
        </div>
</div>
</div>
          <div class="row mt-4">
            <div class="col-md-6 d-flex justify-content-end">
                <button type="submit" id="submit" name="submit" class="btn btn-info btn-sm btn-size" >UPDATE</button>

            </div>
            <div class="col-md-6">
                
            </div>
          </div>
                    </div>
                </div>
            </div>
        </div></form>
    </div>
    </div>';
    ?>
        

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

            function calculateEcoVilaTotal() {
                // Get the input fields for Economic Villa
                var eco_const_mat = parseFloat(document.getElementById("eco_const_mat").value) || 0;
                var eco_kitchen = parseFloat(document.getElementById("eco_kitchen").value) || 0;
                var eco_plumbing = parseFloat(document.getElementById("eco_plumbing").value) || 0;
                var eco_door_win = parseFloat(document.getElementById("eco_door_win").value) || 0;
                var eco_paint = parseFloat(document.getElementById("eco_paint").value) || 0;
                var eco_tiles = parseFloat(document.getElementById("eco_tiles").value) || 0;
                var eco_elec = parseFloat(document.getElementById("eco_elec").value) || 0;
                var eco_misc = parseFloat(document.getElementById("eco_misc").value) || 0;

                // Calculate the total
                var totalEcoVila = eco_const_mat + eco_kitchen + eco_plumbing + eco_door_win + eco_paint + eco_tiles + eco_elec + eco_misc;

                // Display the total in the "ecovila" field
                document.getElementById("ecovila").value = totalEcoVila;
                document.getElementById("ecovila1").value = totalEcoVila;
            }
            var ecoInputs = document.querySelectorAll("#eco_const_mat, #eco_kitchen, #eco_plumbing, #eco_door_win, #eco_paint, #eco_tiles, #eco_elec, #eco_misc");

                ecoInputs.forEach(function (input) {
                    input.addEventListener("input", calculateEcoVilaTotal);
                });
                
                function calculateEssentialVillaTotal() {
        var ess_const_mat = parseFloat(document.getElementById("ess_const_mat").value) || 0;
        var ess_kitchen = parseFloat(document.getElementById("ess_kitchen").value) || 0;
        var ess_plumbing = parseFloat(document.getElementById("ess_plumbing").value) || 0;
        var ess_door_win = parseFloat(document.getElementById("ess_door_win").value) || 0;
        var ess_paint = parseFloat(document.getElementById("ess_paint").value) || 0;
        var ess_tiles = parseFloat(document.getElementById("ess_tiles").value) || 0;
        var ess_elec = parseFloat(document.getElementById("ess_elec").value) || 0;
        var ess_misc = parseFloat(document.getElementById("ess_misc").value) || 0;

        var essTotal = ess_const_mat + ess_kitchen + ess_plumbing + ess_door_win + ess_paint + ess_tiles + ess_elec + ess_misc;

        document.getElementById("essvila").value = essTotal;
         document.getElementById("essvila1").value = essTotal;
    }

    // Attach event listeners to Essential Villa input fields for automatic calculation
    var essInputs = document.querySelectorAll("#ess_const_mat, #ess_kitchen, #ess_plumbing, #ess_door_win, #ess_paint, #ess_tiles, #ess_elec, #ess_misc");

    essInputs.forEach(function (input) {
        input.addEventListener("input", function () {
            calculateEssentialVillaTotal();
        });
    });
    function calculateSuperiorVillaTotal() {
        var sup_const_mat = parseFloat(document.getElementById("sup_const_mat").value) || 0;
        var sup_kitchen = parseFloat(document.getElementById("sup_kitchen").value) || 0;
        var sup_plumbing = parseFloat(document.getElementById("sup_plumbing").value) || 0;
        var sup_door_win = parseFloat(document.getElementById("sup_door_win").value) || 0;
        var sup_paint = parseFloat(document.getElementById("sup_paint").value) || 0;
        var sup_tiles = parseFloat(document.getElementById("sup_tiles").value) || 0;
        var sup_elec = parseFloat(document.getElementById("sup_elec").value) || 0;
        var sup_misc = parseFloat(document.getElementById("sup_misc").value) || 0;

        var supTotal = sup_const_mat + sup_kitchen + sup_plumbing + sup_door_win + sup_paint + sup_tiles + sup_elec + sup_misc;

        document.getElementById("supvila").value = supTotal;
        document.getElementById("supvila1").value = supTotal;
    }

    // Attach event listeners to Superior Villa input fields for automatic calculation
    var supInputs = document.querySelectorAll("#sup_const_mat, #sup_kitchen, #sup_plumbing, #sup_door_win, #sup_paint, #sup_tiles, #sup_elec, #sup_misc");

    supInputs.forEach(function (input) {
        input.addEventListener("input", function () {
            calculateSuperiorVillaTotal();
        });
    });
              
                
          function resetForm() {
//            document.getElementById("project_title").value = "";
            document.getElementById("plot_rate").value = "";
            document.getElementById("area").value = "";
            document.getElementById("pc").value = "";
            document.getElementById("regc").value = "";
            document.getElementById("oc").value = "15000";
            document.getElementById("tpc").value = "";
            document.getElementById("bup").value = "";
            document.getElementById("ecovila").value = "";
            document.getElementById("essvila").value = "";
            document.getElementById("supvila").value = "";
            document.getElementById("ecovc").value = "";
            document.getElementById("ecogst").value = "";
            document.getElementById("cons_ch1").value = "";
            document.getElementById("appro1").value = "";
            document.getElementById("eco_tot").value = "";
            document.getElementById("essvc").value = "";
            document.getElementById("essgst").value = "";
            document.getElementById("cons_ch2").value = "";
            document.getElementById("appro2").value = "";
            document.getElementById("ess_tot").value = "";
            document.getElementById("supvc").value = "";
            document.getElementById("supgst").value = "";
            document.getElementById("cons_ch3").value = "";
            document.getElementById("appro3").value = "";
            document.getElementById("sup_tot").value = "";
        }
    </script>
 <!-- Add this JavaScript code within the <script> tag at the end of your HTML file -->

<script>
    let unsavedChanges = false;
    let formSubmitted = false;

    // Handle the beforeunload event to show a confirmation dialog
    window.addEventListener('beforeunload', function (event) {
        if (unsavedChanges && !formSubmitted) {
            event.preventDefault();
            event.returnValue = "You have unsaved changes. Are you sure you want to leave this page?";
        }
    });

    // Provide a confirmation dialog when a user explicitly tries to leave the page
    window.addEventListener('unload', function (event) {
        if (unsavedChanges && !formSubmitted) {
            return "You have unsaved changes. Are you sure you want to leave this page?";
        }
    });

    // Listen for changes in form fields
    const formInputs = document.querySelectorAll('input, select');
    formInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            unsavedChanges = true;
        });
    });

    // Add an event listener to the "Update" button to submit the form
    const updateButton = document.getElementById('submit'); // Change 'submit' to the actual ID of your update button
    updateButton.addEventListener('click', function() {
        formSubmitted = true;
    });

    // Prevent form submission when the Enter key is pressed
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter' && !formSubmitted) {
            event.preventDefault();
        }
    });
    </script>

</body>
</html>
<?php } } }?>