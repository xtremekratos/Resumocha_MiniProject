<?php
// Include config file
require_once "config.php";
$email="";
$name="";
$phone="";
$sex="";
$dob="";
$resume ="";
$dp = "";
$resume_mode ="";
$dp_mode = "";
$img_src="";
$resume_src="";
if(isset($_GET["email"])){
    $email = $_GET["email"]; 
}
else{
    header("Location:init.php");
    exit();
}
$sql = "select * from users WHERE email=?";
 
if($stmt = $mysqli->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("s", $_GET['email']);
          
    // Attempt to execute the prepared statement
    if($stmt->execute()){
        $result = $stmt->get_result();
        
        if($result->num_rows == 1){
            /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $name =$row["name"];
            $phone =$row["phone"];
            $sex =$row["sex"];
            $dob =$row["dob"];
            $resume =$row["resume"]."";
            $dp =$row["dp"]."";
            if($resume==""){
                $resume_mode="Add Resume";
            }
            else{
                $resume_mode="Update Resume";
            }
            if($dp==""){
                $dp_mode="Add Profile Pic";
            }
            else{
                $dp_mode="Update Profile Pic";
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Your Details</h2>
                        <a href="create.php" class="btn btn-success pull-right"> <?php echo $resume_mode ?></a>
                        <a href="create.php" class="btn btn-success pull-right" style="margin-right: 15px;"> <?php echo $dp_mode ?></a>
                    <?php
                    // Include config file
                    require_once "config.php";
                    if($dp_mode=="Add Profile Pic"){
                        $img_src="img/default.jpg";
                    }
                    else{
                    // Attempt select query execution
                    $sql = "select * from images WHERE email=?";
 
                    if($stmt = $mysqli->prepare($sql)){
                        // Bind variables to the prepared statement as parameters
                        $stmt->bind_param("s", $_GET['email']);
                              
                        // Attempt to execute the prepared statement
                        if($stmt->execute()){
                            $result = $stmt->get_result();
                            
                            if($result->num_rows == 1){
                                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                                $row = $result->fetch_array(MYSQLI_ASSOC);
                                
                                // Retrieve individual field value
                                $img_src = $row["image_path"];
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>ERROR:Multiple records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
                
                    // Close connection
                    mysqli_close($link);}}

                    if($resume_mode=="Add Resume"){
                        echo "";
                    }
                    else{
                    // Attempt select query execution
                    $sql = "select * from resumes WHERE email=?";
 
                    if($stmt = $mysqli->prepare($sql)){
                        // Bind variables to the prepared statement as parameters
                        $stmt->bind_param("s", $_GET['email']);
                              
                        // Attempt to execute the prepared statement
                        if($stmt->execute()){
                            $result = $stmt->get_result();
                            
                            if($result->num_rows == 1){
                                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                                $row = $result->fetch_array(MYSQLI_ASSOC);
                                
                                // Retrieve individual field value
                                $resume_src = $row["link"];
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>ERROR:Multiple records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
                
                    // Close connection
                    mysqli_close($link);}}
                    ?>
                
                </div>
            </div>
            <div class="row"><div class="col-md-4">
            <img src=<?php echo $img_src?> width="200px"></div>
                <div class="col-md-8">
                <h2><b><?php echo $name?></b></h2><br>
                <h5><?php echo "Email : ".$email?></h5>
                <h5><?php echo "Phone : ".$phone?></h5>
                <h5><?php echo "DOB   : ".$dob?></h5>
                <h5><?php echo "Gender: ".$sex?></h5>
                </div>
                </div>

                <div class="row">
                <br>
                <div class="col-md-12">
                <?php if(($resume_mode=="Add Resume")){
                        echo ' <a href="create.php" class="btn btn-danger disabled btn-block btn-lg" >Resume not Uploaded</a><br>';
                        }
                        else{
                            echo '<a href="'.$resume_src.'" class="btn btn-info  btn-block btn-lg" >Veiw Resume</a><br>';
                        }?>
                </div>
                </div> 
                <div class="row">
                <div class="col-md-12">
                <?php if(($resume_mode=="Add Resume")||($dp_mode=="Add Profile Pic")){
                        echo '<div class= "alert alert-danger">
                        You havent completed your profile!</div>';
                        }
                        else{
                            echo '<div class= "alert alert-success">
                            Your Profile is Complete.</div>';
                        }?>
                </div>
                </div> 
        </div>
    </div>
</body>
</html>