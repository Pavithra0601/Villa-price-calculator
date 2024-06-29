<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Price Calculator - Results</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans&display=swap">

   <link rel="stylesheet" type="text/css" href="output.css">
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js "></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

</head>
<body>
    <div class="bg-image">
    <header>
        <div class="header-content">
             <a href="index.php"><img src="image/spe.png" class="logo"/></a>
           </div>
        <p class="display-10 header-text blinking-text " style="font-family: cursive">
                  Price of your Villa based on your selection
                </p>
        <!--<a href="login.php" class="header-link">SPE Login</a>-->
    </header>

    <div class="container" id="print">
    <div class="hidden-on-webpage">
        <img src="image/spe.png" class="logo"/>
        <p class="display-10 header-text blinking-text " style="font-family: cursive">
                  Price of your Villa based on your selection
                </p>
    </div>
    
        
        <h2 class="text-center"></h2>

       <?php
       require_once("db_connection.php");
function convertToINR($number) {
    // Define Indian numbering system separators
    $separator = ',';
    $decimal_separator = '.';
    
    $formatted_number = number_format($number, 0, $decimal_separator, '');
    
    // Split the number into integer and decimal parts
    $parts = explode($decimal_separator, $formatted_number);
    $integer_part = $parts[0];
    $decimal_part = isset($parts[1]) ? $decimal_separator . $parts[1] : '';
    
    // Convert to Indian numbering system
    $indian_format = '';
    
    // Handle crore (10,00,00,000)
    if (strlen($integer_part) > 7) {
        $crore = substr($integer_part, 0, -7);
        $indian_format .= $crore ."" . $separator;
        $integer_part = substr($integer_part, -7);
    }
    
    // Handle lakh (1,00,00,000)
    if (strlen($integer_part) > 5) {
        $lakh = substr($integer_part, 0, -5);
        $indian_format .= $lakh . '' . $separator;
        $integer_part = substr($integer_part, -5);
    }

    // Handle thousand (1,000)
    if (strlen($integer_part) > 3) {
        $thousand = substr($integer_part, 0, -3);
        $indian_format .= $thousand . '' . $separator;
        $integer_part = substr($integer_part, -3);
    }

    // Remaining part (hundreds)
    $indian_format .= $integer_part;

    // Combine the formatted parts
    $formatted_integer_part = rtrim($indian_format, $separator);

    return 'Rs. ' . $formatted_integer_part . $decimal_part;


}

        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $location = $_POST["location"];
            $project = strtolower($_POST["project"]);
            $villa_type = $_POST["villa_type"];
            $plot_area = $_POST["plot_area"];
            $bup_area = $_POST["bup_area"];
            $construction_type = $_POST["construction_type"];
       
     if($construction_type=="Economical Villa"){
          $sql1="SELECT plot_rate,reg_cost,other_cost,eco_const_mat,eco_kitchen,eco_plumbing,eco_door_win,eco_paint,"
                     . "eco_tiles,eco_elec,eco_misc,eco_sq_ft  FROM `construction_details` WHERE project_title='$project'";

            $stmt = $conn->prepare($sql1);
            $stmt = $conn->prepare($sql1);

            $stmt->execute();
            $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $plot_cost= $row['plot_rate'] * $plot_area;
                $reg_cost=$plot_cost * $row['reg_cost']/100;
                $other_ch=$row['other_cost'];               
                $total_plot_cost=$plot_cost + $reg_cost + $other_ch;
                $tot_construction_cost=$bup_area * $row['eco_sq_ft'];
                $approval=$bup_area*200;
                $gst=$tot_construction_cost * 18/100;
                $construction_charge=$tot_construction_cost* 2/100;
                $total_villa_cost= $total_plot_cost + $tot_construction_cost + $approval + $gst + $construction_charge;

                 echo '
                     <div class="table-responsive mt-4 page-break">

                <table class="table table-bordered">
                    <tbody>
                     <tr>
                     <td colspan="2" style="text-align:center; color:#370637;">
                     <b><h2>'. strtoupper($project).' </b></h2></td>
                   
                     </tr>
                     <tr>
                     <td><b>Plot Rate  </td>
                     <td><b>'.convertToINR($row['plot_rate']).'</td>
                      </tr>
                      <tr>
                      <td>Selected Plot Area </td>
                      <td>'.$plot_area.' Sq.ft</td>
                      </tr>
                      <tr>
                      <td>Plot Cost </td>
                      <td>'.convertToINR($plot_cost).'</td>
                      </tr>
                      <tr>
                      <td>Registration Cost </td>
                      <td>'.convertToINR($reg_cost).'</td>
                      </tr>
                      <tr>
                      <td>Other Charges</td>
                      <td>'.convertToINR($other_ch).'</td>
                      </tr>
                      <tr>
                      <td style="background-color:#370637;color:white;" ><b>Total Plot Cost </td>
                      <td style="background-color:#370637;color:white;"><b>'.convertToINR($total_plot_cost).'</td>
                      </tr>
                      <tr >
                      <td colspan="2" style="text-align:center;color:#370637"><b>Construction Cost Details<b></td>
                      </tr>
                      <tr>
                      <td>Selected Builtup Area </td>
                      <td>'.$bup_area.' Sq.ft</td>
                      </tr>
                      <tr>
                      <td>Villa Construction Type </td>
                      <td>'.$construction_type.'</td>
                      </tr>
                      <tr>
                      <td><b> Construction Cost </td>
                      <td>'.convertToINR($row['eco_sq_ft']).' Per Sq.ft</td>
                      </tr>
                      <tr>
                      <td style="background-color:#370637; color:white;"> <b>Total Construction Cost </td>
                      <td style="background-color:#370637; color:white;"><b>'.convertToINR($tot_construction_cost).'</td>
                      </tr>
                      <tr>
                      <td> Approval,EB & Other Charges </td>
                      <td>'.convertToINR($bup_area * 150 ).'</td>
                      </tr>
                      <tr>
                      <td> GST(18%) </td>
                      <td>'.convertToINR($gst).'</td>
                      </tr>
                      <tr>
                      <td> Construction Agreement Charges </td>
                      <td>'.convertToINR($tot_construction_cost * 2/100 ).'</td>
                      </tr>
                      <tr>
                      <td style="background-color:#370637; color:white; text-align:center"><b>Total Villa Cost  </td>
                      <td style="background-color:#370637; color:white;"><b>'.convertToINR($total_villa_cost).'</td>
                      </tr>
                    </tbody>
                </table>
            </div><div class="hidden-on-webpage"><br><br><br><br><br><br><br></div>';

                  echo '
                      <div class="table-responsive mt-4">
                
                <table class="table table-bordered">
                  <tbody>
                  <tr>
                    <td colspan="3" style="background-color:#370637; color:white; text-align:center"> 
                    <b>Construction Cost Break-up Details</b></td>
                    </tr>
                     <tr>
                     <td style="text-align:center"><b>S.No</b> </td>
                     <td style="text-align:center"><b>Description</b></td>
                     <td style="text-align:center"><b>Cost Per Sq.ft</b></td>
                     </tr>

                    <tr>
                    <td style="text-align:center">1.</td>
                    <td>Construction Material</td>
                    <td style="text-align:center">'.convertToINR($row['eco_const_mat']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">2.</td>
                    <td>Kitchen</td>
                    <td style="text-align:center">'.convertToINR($row['eco_kitchen']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">3.</td>
                    <td>Plumbing</td>
                    <td style="text-align:center">'.convertToINR($row['eco_plumbing']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">4.</td>
                    <td>Door & Window</td>
                    <td style="text-align:center">'.convertToINR($row['eco_door_win']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">5.</td>
                    <td>Paint</td>
                    <td style="text-align:center">'.convertToINR($row['eco_paint']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">6.</td>
                    <td>Tiles</td>
                    <td style="text-align:center">'.convertToINR($row['eco_tiles']).'</td>
                    </tr>

                   

                    <tr>
                    <td style="text-align:center">7.</td>
                    <td>Electrical</td>
                    <td style="text-align:center">'.convertToINR($row['eco_elec']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">8.</td>
                    <td>Miscellaneous</td>
                    <td style="text-align:center">'.convertToINR($row['eco_misc']).'</td>
                    </tr>


                  </tbody>
                </table>
            </div><div class="hidden-on-webpage">
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </div>';


            }
             $sql2="SELECT * FROM eco_cons_material";

            $stmt1 = $conn->prepare($sql2);
            $stmt1 = $conn->prepare($sql2);

            $stmt1->execute();
            $result1 = $stmt1->get_result();

        if ($result1->num_rows > 0) {
            while ($row1 = $result1->fetch_assoc()) {
                echo '
                    <div class="table-responsive mt-4">
              
                <table class="table table-bordered">
                  <tbody>
                  <tr>
                    <td colspan="3" style="background-color:#370637; color:white; text-align:center"> 
                    <b>Construction Material Details</b></td>
                    </tr>
                     <tr><b>
                     <td style="text-align:center"><b>S.No </td>
                     <td style="text-align:center"><b>Description</td>
                     <td style="text-align:center"><b>Material / Brand Used</td></b>
                     </tr>

                    <tr>
                    <td style="text-align:center">1.</td>
                    <td style="text-align:center">Construction Material</td>
                    <td >'.$row1['material'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">2.</td>
                    <td style="text-align:center">Kitchen Material</td>
                    <td>'.$row1['kitchen'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">3.</td>
                    <td style="text-align:center">Plumbing Material</td>
                    <td>'.$row1['plumbing'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">4.</td>
                    <td style="text-align:center">Door & Window Material</td>
                    <td>'.$row1['door_window'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">5.</td>
                    <td style="text-align:center">Paint </td>
                    <td>'.$row1['paints'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">6.</td>
                    <td style="text-align:center">Tiles</td>
                    <td>'.$row1['tiles'].'</td>
                    </tr>

                
                    <tr>
                    <td style="text-align:center">7.</td>
                    <td style="text-align:center">Electrical</td>
                    <td>'.$row1['electrical'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">8.</td>
                    <td style="text-align:center">Miscellaneous</td>
                    <td>'.$row1['misc'].'</td>
                    </tr>


                  </tbody>
                </table>
            </div> ';
                
                
                
            }
            
            }
        } else {
            echo "No results found for the selected project.";
        }

        $stmt->close();
        
        
    }
        
    else if($construction_type=="Essential Villa"){
          $sql1="SELECT plot_rate,reg_cost,other_cost,ess_const_mat,ess_kitchen,ess_plumbing,ess_door_win,ess_paint,"
                     . "ess_tiles,ess_elec,ess_misc,ess_sq_ft  FROM `construction_details` WHERE project_title='$project'";

            $stmt = $conn->prepare($sql1);
            $stmt = $conn->prepare($sql1);

            $stmt->execute();
            $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $plot_cost= $row['plot_rate'] * $plot_area;
                $reg_cost=$plot_cost * $row['reg_cost']/100;
                $other_ch=$row['other_cost'];               
                $total_plot_cost=$plot_cost + $reg_cost + $other_ch;
                $tot_construction_cost=$bup_area * $row['ess_sq_ft'];
                $approval=$bup_area*150;
                $gst=$tot_construction_cost * 18/100;
                $construction_charge=$tot_construction_cost* 2/100;
                $total_villa_cost= $total_plot_cost + $tot_construction_cost + $approval + $gst + $construction_charge;

                  echo '
                      <div class="table-responsive mt-4">

                <table class="table table-bordered">
                    <tbody>
                     <tr>
                     <td colspan="2" style="text-align:center; color:#370637;">
                     <b><h2>'. strtoupper($project).' </b></h2></td>
                   
                     </tr>
                     <tr>
                     <td><b>Plot Rate  </td>
                     <td><b>'.convertToINR($row['plot_rate']).'</td>
                      </tr>
                      <tr>
                      <td>Selected Plot Area </td>
                      <td>'.$plot_area.' Sq.ft</td>
                      </tr>
                      <tr>
                      <td>Plot Cost </td>
                      <td>'.convertToINR($plot_cost).'</td>
                      </tr>
                      <tr>
                      <td>Registration Cost </td>
                      <td>'.convertToINR($reg_cost).'</td>
                      </tr>
                      <tr>
                      <td>Other Charges</td>
                      <td>'.convertToINR($other_ch).'</td>
                      </tr>
                      <tr>
                      <td style="background-color:#370637; color:white;"><b>Total Plot Cost </td>
                      <td style="background-color:#370637; color:white;"><b>'.convertToINR($total_plot_cost).'</td>
                      </tr>
                      <tr >
                      <td colspan="2" style="text-align:center;color:#370637"><b>Construction Cost Details<b></td>
                      </tr>
                      <tr>
                      <td>Selected Builtup Area </td>
                      <td>'.$bup_area.' Sq.ft</td>
                      </tr>
                      <tr>
                      <td>Villa Construction Type </td>
                      <td>'.$construction_type.'</td>
                      </tr>
                      <tr>
                      <td><b> Construction Cost </td>
                      <td>'.convertToINR($row['ess_sq_ft']).' Per Sq.ft</td>
                      </tr>
                      <tr>
                      <td style="background-color:#370637; color:white;"> <b>Total Construction Cost </td>
                      <td style="background-color:#370637; color:white;"><b>'.convertToINR($tot_construction_cost).'</td>
                      </tr>
                      <tr>
                      <td> Approval,EB & Other Charges </td>
                      <td>'.convertToINR($bup_area * 150 ).'</td>
                      </tr>
                      <tr>
                      <td> GST(18%) </td>
                      <td>'.convertToINR($gst).'</td>
                      </tr>
                      <tr>
                      <td> Construction Agreement Charges </td>
                      <td>'.convertToINR($tot_construction_cost * 2/100 ).'</td>
                      </tr>
                      <tr>
                      <td style="background-color:#370637; color:white; text-align:center"><b>Total Villa Cost  </td>
                      <td style="background-color:#370637; color:white;"><b>'.convertToINR($total_villa_cost).'</td>
                      </tr>
                    </tbody>
                </table>
            </div><div class="hidden-on-webpage"><br><br><br><br><br><br><br></div>';

                  echo '
                      <div class="table-responsive mt-4">
                
                <table class="table table-bordered">
                  <tbody>
                  <tr>
                    <td colspan="3" style="background-color:#370637; color:white; text-align:center"> 
                    <b>Construction Cost Break-up Details</b></td>
                    </tr>
                     <tr>
                     <td style="text-align:center"><b>S.No</b> </td>
                     <td style="text-align:center"><b>Description</b></td>
                     <td style="text-align:center"><b>Cost Per Sq.ft</b></td>
                     </tr>

                    <tr>
                    <td style="text-align:center">1.</td>
                    <td>Construction Material</td>
                    <td style="text-align:center">'.convertToINR($row['ess_const_mat']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">2.</td>
                    <td>Kitchen</td>
                    <td style="text-align:center">'.convertToINR($row['ess_kitchen']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">3.</td>
                    <td>Plumbing</td>
                    <td style="text-align:center">'.convertToINR($row['ess_plumbing']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">4.</td>
                    <td>Door & Window</td>
                    <td style="text-align:center">'.convertToINR($row['ess_door_win']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">5.</td>
                    <td>Paint</td>
                    <td style="text-align:center">'.convertToINR($row['ess_paint']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">6.</td>
                    <td>Tiles</td>
                    <td style="text-align:center">'.convertToINR($row['ess_tiles']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">7.</td>
                    <td>Electrical</td>
                    <td style="text-align:center">'.convertToINR($row['ess_elec']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">8.</td>
                    <td>Miscellaneous</td>
                    <td style="text-align:center">'.convertToINR($row['ess_misc']).'</td>
                    </tr>


                  </tbody>
                </table>
            </div><div class="hidden-on-webpage">
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </div>';


            }
             $sql2="SELECT * FROM essential_cons_material";

            $stmt1 = $conn->prepare($sql2);
            $stmt1 = $conn->prepare($sql2);

            $stmt1->execute();
            $result1 = $stmt1->get_result();

        if ($result1->num_rows > 0) {
            while ($row1 = $result1->fetch_assoc()) {
                echo '
                    <div class="table-responsive mt-4">
              
                <table class="table table-bordered">
                  <tbody>
                  <tr>
                    <td colspan="3" style="background-color:#370637; color:white;text-align:center"> 
                    <b>Construction Material Details</b></td>
                    </tr>
                     <tr><b>
                     <td style="text-align:center"><b>S.No </td>
                     <td style="text-align:center"><b>Description</td>
                     <td style="text-align:center"><b>Material / Brand</td></b>
                     </tr>

                    <tr>
                    <td style="text-align:center">1.</td>
                    <td style="text-align:center">Construction Material</td>
                    <td >'.$row1['material'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">2.</td>
                    <td style="text-align:center">Kitchen Material</td>
                    <td>'.$row1['kitchen'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">3.</td>
                    <td style="text-align:center">Plumbing Material</td>
                    <td>'.$row1['plumbing'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">4.</td>
                    <td style="text-align:center">Door & Window Material</td>
                    <td>'.$row1['door_window'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">5.</td>
                    <td style="text-align:center">Paint</td>
                    <td>'.$row1['paints'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">6.</td>
                    <td style="text-align:center">Tiles</td>
                    <td>'.$row1['tiles'].'</td>
                    </tr>

                
                    <tr>
                    <td style="text-align:center">7.</td>
                    <td style="text-align:center">Electrical</td>
                    <td>'.$row1['electrical'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">8.</td>
                    <td style="text-align:center">Miscellaneous</td>
                    <td>'.$row1['misc'].'</td>
                    </tr>


                  </tbody>
                </table>
            </div>';
                
                
                
            }
            
            }
        } else {
            echo "No results found for the selected project.";
        }

        $stmt->close();
        
        
    }
    
     else if($construction_type=="Superior Villa"){
          $sql1="SELECT plot_rate,reg_cost,other_cost,sup_const_mat,sup_kitchen,sup_plumbing,sup_door_win,sup_paint,"
                     . "sup_tiles,sup_elec,sup_misc,sup_sq_ft  FROM `construction_details` WHERE project_title='$project'";

            $stmt = $conn->prepare($sql1);
            $stmt = $conn->prepare($sql1);

            $stmt->execute();
            $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $plot_cost= $row['plot_rate'] * $plot_area;
                $reg_cost=$plot_cost * $row['reg_cost']/100;
                $other_ch=$row['other_cost'];               
                $total_plot_cost=$plot_cost + $reg_cost + $other_ch;
                $tot_construction_cost=$bup_area * $row['sup_sq_ft'];
                $approval=$bup_area*150;
                $gst=$tot_construction_cost * 18/100;
                $construction_charge=$tot_construction_cost* 2/100;
                $total_villa_cost= $total_plot_cost + $tot_construction_cost + $approval + $gst + $construction_charge;

                echo '
                    <div class="table-responsive mt-4">

                <table class="table table-bordered">
                    <tbody>
                     <tr>
                     <td colspan="2" style="text-align:center; color:#370637;">
                     <b><h2>'. strtoupper($project).' </b></h2></td>
                   
                     </tr>
                     <tr>
                     <td><b>Plot Rate  </td>
                     <td><b>'.convertToINR($row['plot_rate']).'</td>
                      </tr>
                      <tr>
                      <td>Selected Plot Area </td>
                      <td>'.$plot_area.' Sq.ft</td>
                      </tr>
                      <tr>
                      <td>Plot Cost </td>
                      <td>'.convertToINR($plot_cost).'</td>
                      </tr>
                      <tr>
                      <td>Registration Cost </td>
                      <td>'.convertToINR($reg_cost).'</td>
                      </tr>
                      <tr>
                      <td>Other Charges</td>
                      <td>'.convertToINR($other_ch).'</td>
                      </tr>
                      <tr>
                      <td style="background-color:#370637; color:white;"><b>Total Plot Cost </td>
                      <td style="background-color:#370637; color:white;"><b>'.convertToINR($total_plot_cost).'</td>
                      </tr>
                      <tr >
                      <td colspan="2" style="text-align:center;color:#370637"><b>Construction Cost Details<b></td>
                      </tr>
                      <tr>
                      <td>Selected Builtup Area </td>
                      <td>'.$bup_area.' Sq.ft</td>
                      </tr>
                      <tr>
                      <td>Villa Construction Type </td>
                      <td>'.$construction_type.'</td>
                      </tr>
                      <tr>
                      <td><b> Construction Cost </td>
                      <td>'.convertToINR($row['sup_sq_ft']).' Per Sq.ft</td>
                      </tr>
                      <tr>
                      <td style="background-color:#370637; color:white;"> <b>Total Construction Cost </td>
                      <td style="background-color:#370637; color:white;"><b>'.convertToINR($tot_construction_cost).'</td>
                      </tr>
                      <tr>
                      <td> Approval,EB & Other Charges </td>
                      <td>'.convertToINR($bup_area * 150 ).'</td>
                      </tr>
                      <tr>
                      <td> GST(18%) </td>
                      <td>'.convertToINR($gst).'</td>
                      </tr>
                      <tr>
                      <td> Construction Agreement Charges </td>
                      <td>'.convertToINR($tot_construction_cost * 2/100 ).'</td>
                      </tr>
                      <tr>
                      <td style="background-color:#370637; color:white;text-align:center"><b>Total Villa Cost  </td>
                      <td style="background-color:#370637; color:white;"><b>'.convertToINR($total_villa_cost).'</td>
                      </tr>
                    </tbody>
                </table>
            </div><div class="hidden-on-webpage"><br><br><br><br><br><br><br></div>';

                  echo '
                      <div class="table-responsive mt-4">
                
                <table class="table table-bordered">
                  <tbody>
                  <tr>
                    <td colspan="3" style="background-color:#370637; color:white;;text-align:center"> 
                    <b>Construction Cost Break-up Details</b></td>
                    </tr>
                     <tr>
                     <td style="text-align:center"><b>S.No</b> </td>
                     <td style="text-align:center"><b>Description</b></td>
                     <td style="text-align:center"><b>Cost Per Sq.ft</b></td>
                     </tr>

                    <tr>
                    <td style="text-align:center">1.</td>
                    <td>Construction Material</td>
                    <td style="text-align:center">'.convertToINR($row['sup_const_mat']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">2.</td>
                    <td>Kitchen</td>
                    <td style="text-align:center">'.convertToINR($row['sup_kitchen']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">3.</td>
                    <td>Plumbing</td>
                    <td style="text-align:center">'.convertToINR($row['sup_plumbing']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">4.</td>
                    <td>Door & Window</td>
                    <td style="text-align:center">'.convertToINR($row['sup_door_win']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">5.</td>
                    <td>Paint</td>
                    <td style="text-align:center">'.convertToINR($row['sup_paint']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">6.</td>
                    <td>Tiles</td>
                    <td style="text-align:center">'.convertToINR($row['sup_tiles']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">6.</td>
                    <td>Tiles</td>
                    <td style="text-align:center">'.convertToINR($row['sup_tiles']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">7.</td>
                    <td>Electrical</td>
                    <td style="text-align:center">'.convertToINR($row['sup_elec']).'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">8.</td>
                    <td>Miscellaneous</td>
                    <td style="text-align:center">'.convertToINR($row['sup_misc']).'</td>
                    </tr>


                  </tbody>
                </table>
            </div><div class="hidden-on-webpage">
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </div>';


            }
             $sql2="SELECT * FROM superior_cons_material";

            $stmt1 = $conn->prepare($sql2);
           

            $stmt1->execute();
            $result1 = $stmt1->get_result();

        if ($result1->num_rows > 0) {
            while ($row1 = $result1->fetch_assoc()) {
                echo '
                    <div class="table-responsive mt-4">
              
                <table class="table table-bordered">
                  <tbody>
                  <tr>
                    <td colspan="3" style="background-color:#370637; color:white; text-align:center"> 
                    <b>Construction Material Details</b></td>
                    </tr>
                     <tr><b>
                     <td style="text-align:center"><b>S.No </td>
                     <td style="text-align:center"><b>Description</td>
                     <td style="text-align:center"><b>Material / Brand</td></b>
                     </tr>

                    <tr>
                    <td style="text-align:center">1.</td>
                    <td style="text-align:center">Construction Material</td>
                    <td >'.$row1['material'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">2.</td>
                    <td style="text-align:center">Kitchen</td>
                    <td>'.$row1['kitchen'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">3.</td>
                    <td style="text-align:center">Plumbing</td>
                    <td>'.$row1['plumbing'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">4.</td>
                    <td style="text-align:center">Door & Window</td>
                    <td>'.$row1['door_window'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">5.</td>
                    <td style="text-align:center">Paint</td>
                    <td>'.$row1['paints'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">6.</td>
                    <td style="text-align:center">Tiles</td>
                    <td>'.$row1['tiles'].'</td>
                    </tr>

                
                    <tr>
                    <td style="text-align:center">7.</td>
                    <td style="text-align:center">Electrical</td>
                    <td>'.$row1['electrical'].'</td>
                    </tr>

                    <tr>
                    <td style="text-align:center">8.</td>
                    <td style="text-align:center">Miscellaneous</td>
                    <td>'.$row1['misc'].'</td>
                    </tr>


                  </tbody>
                </table>
            </div>';
                
                
                
                
                
            }
            
            }
        } else {
            echo "No results found for the selected project.";
        }

        $stmt->close();
        
        
    }
    
    

    $conn->close();
} else {
    echo "<p>No data submitted.</p>";
}
        ?>
    </div>
<div class="text-center mt-4 d-flex justify-content-center">
    <a class="btn btn-back mr-2" style="background-color:#370637; color: white; " href="index.php">Back to Calculator</a>
    <button type="button" class="btn btn-back mr-2" style="background-color:#370637; color: white; " id="download-pdf" onclick="print()">Download PDF</button>
</div>



   

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
window.jsPDF = window.jspdf.jsPDF;

var font = "Noto Sans";


var docPDF = new jsPDF();

docPDF.setFont(font);

function addTextWithRupeeSymbol(text, x, y) {
    docPDF.text(text, x, y);
}

function print() {
  var docPDF = new jsPDF();

  // Set the font for the PDF
  var font = "Noto Sans";
  docPDF.setFont(font);

  // Modify the CSS properties of hidden elements to make them visible
  var hiddenElements = document.querySelectorAll('.hidden-on-webpage');
  hiddenElements.forEach(function (element) {
    element.style.display = 'block'; // Change this to 'visibility: visible;' if needed
  });

  // Add the HTML content to the PDF with page breaks
  docPDF.html(document.querySelector("#print"), {
    callback: function () {
      // Generate the PDF content and initiate the download
      docPDF.save('SPE_VILLA_PRICE.pdf');
      
      // Reset the CSS properties to hide the elements on the webpage again
      hiddenElements.forEach(function (element) {
        element.style.display = 'none'; // Change this to 'visibility: hidden;' if needed
      });
    },
    x: 15,
    y: 15,
    width: 170,
    windowWidth: 650,
    pagesplit: true,
    pagebreak: '.page-break'
  });
}


        </script>
</body>
</html>
