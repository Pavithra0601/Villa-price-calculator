<?php 
require_once('db_connection.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Property Price Calculator</title>
    
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.2/dist/js/bootstrap.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




    <link rel="stylesheet" href="styles.css">
   </head>
<body>
    <div class="bg-image">
    <header>
        <div class="header-content">
            <img src="image/spe.png" class="logo"/>
           </div>
         <p class="display-5 header-text blinking-text " style="font-family: cursive;color:#370637">
                    <br>Know the price of your Dream villa !!
                </p>
        <!--<a href="login.php" class="header-link">SPE Login</a>-->
    </header>
    
    <main class=" mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="main-container ">
                    <form action="calculate.php" method="POST">
                        <div class="mb-3 form-group">
                            <label for="location" class="form-label">Project Location:</label>
                            <select name="location" id="location" onchange="proj()" class="form-select" required>
                                <option value="">--Select Location--</option>
                            <?php 
                            $sql="select distinct location from construction_details where status=1";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();
                              if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                            ?>
                              <option value="<?php echo $row['location'];?>"><?php echo $row['location']; } } ?></option>
                                
                            </select> 
                        </div>
                        
                        <div class="mb-3 form-group">
                            <label for="project" class="form-label">Project Name:</label>
                            <select name="project" id="project" onchange="updateArea(); updateBupArea();"  readonly class="form-select" required>
                            </select>
                        </div>

                        <div class="mb-3 form-group">
                            <label for="villa_type" class="form-label ">Villa Type:</label>
                            <select name="villa_type" id="villa_type" class="form-select foc" required>
                                <option value="">Select Villa Type</option>
                                <option value="1BHK">1BHK</option>
                                <option value="2BHK">2BHK</option>
                                <option value="3BHK">3BHK</option>
                            </select>
                        </div>

                        <div class="mb-3 form-group">
                            <label for="plot_area" class="form-label">Plot Area:</label>
                            <select name="plot_area" id="plot_area" class="form-select" required>
                                <!--<option value="">Select Plot Area</option>-->
                            </select>
                        </div>

                        <div class="mb-3 form-group">
                            <label for="bup_area" class="form-label">Builtup Area:</label>
                            <select name="bup_area" id="bup_area" class="form-select" required>
                                <!--<option value="">Select Builtup Area</option>-->
                            </select>
                        </div>

                        <div class="mb-3 form-group">
                            <label for="construction_type" class="form-label">Construction Type:</label>
                            <select name="construction_type" id="construction_type" class="form-select" required>
                                <option value="">Select Construction Type</option>
                                <option value="Economical Villa">Economical Villa</option>
                                <option value="Essential Villa">Essential Villa</option>
                                <option value="Superior Villa">Superior Villa</option>
                                <!--<option value="Customized Villa">Customized Villa</option>-->
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="calculate" class="btn btn-primary">Calculate Cost</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

<!--    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            &copy; 2023 Your Company. All Rights Reserved.
        </div>
    </footer>-->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
    <script>
//        document.addEventListener("DOMContentLoaded", function() {
//    // Add the 'active' class to trigger the slide-in animation after the page loads
//    document.querySelector('.main-container').classList.add('active');
//});
//
//        
//        function proj() {
//            var location = document.getElementById("location").value;
//            if (location == "voyalanallur") {
//                var project = "SPE LUXUS";
//                document.getElementById('project').value = project;
//                // Update plot area options based on project
//                updatePlotAreaOptions(project);
//                document.getElementById('villa_type').focus();
//            } else if (location == "parivakkam") {
//                var project = "SPE METROCITY";
//                document.getElementById('project').value = project;
//                // Update plot area options based on project
//                updatePlotAreaOptions(project);
//            }
//        }
//
//        function updatePlotAreaOptions(project) {
//            var plotAreaSelect = document.getElementById("plot_area");
//            var builtupAreaSelect = document.getElementById("bup_area");
//            // Clear existing options
//            plotAreaSelect.innerHTML = "";
//
//            // Populate options based on project
//            if (project === "SPE LUXUS") {
//                plotAreaSelect.add(new Option("Select Plot Area", ""));
//                plotAreaSelect.add(new Option("516 Sq.ft", "516"));
//                plotAreaSelect.add(new Option("667 Sq.ft", "667"));
//                plotAreaSelect.add(new Option("600 Sq.ft", "600"));
//
//                builtupAreaSelect.add(new Option("Select Builtup Area", ""));
//                builtupAreaSelect.add(new Option("470 Sq.ft", "470"));
//                builtupAreaSelect.add(new Option("560 Sq.ft", "560"));
//                builtupAreaSelect.add(new Option("780 Sq.ft", "780"));
//
//            } else if (project === "SPE METROCITY") {
//                plotAreaSelect.add(new Option("Select Plot Area", ""));
//                plotAreaSelect.add(new Option("560 Sq.ft", "560"));
//                plotAreaSelect.add(new Option("600 Sq.ft", "600"));
//                plotAreaSelect.add(new Option("775 Sq.ft", "775"));
//
//                builtupAreaSelect.add(new Option("Select Builtup Area", ""));
//                builtupAreaSelect.add(new Option("636 Sq.ft", "636"));
//                builtupAreaSelect.add(new Option("762 Sq.ft", "762"));
//                builtupAreaSelect.add(new Option("905 Sq.ft", "905"));
//            }
//        }
//    </script>
    
    </div>
   <script>
    // Function to update project title based on selected location
    function proj() {
        var location = document.getElementById('location').value;
        $.ajax({
            url: 'process_form.php',
            type: 'POST',
            data: { location: location, action: 'get_project_title' },
            success: function (response) {
                $('#project').html(response);
            }
        });
    }

   function updateArea() {
       console.log('updateArea function called');
    var project_title = document.getElementById('project').value;
    var location = document.getElementById('location').value;
    $.ajax({
        url: 'process_form.php',
        type: 'POST',
        data: { location: location, project_title: project_title, action: 'get_area' },
        success: function (response) {
            $('#plot_area').html(response);
        }
    });
}

function updateBupArea() {
    console.log('updateBupArea function called');
     var project_title = document.getElementById('project').value;
    var location = document.getElementById('location').value; 
    $.ajax({
        url: 'process_form.php',
        type: 'POST',
        data: { location: location, project_title: project_title, action: 'get_bup_area' },
        success: function (response) {
            $('#bup_area').html(response);
        }
    });
}

</script>


</body>
</html>
