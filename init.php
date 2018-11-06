<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $pass ="";
$email_err = $pass_err = "";
$res_err="";
$type_of_alert="";
$mode="";
// Processing form data when form is submitted
if((isset($_POST["email"]))&&(isset($_POST["pass"])) && !empty($_POST["email"]) || !empty($_POST["pass"])){

    
    // Validate name
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter a email.";
    } elseif(!filter_var($input_email, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/")))){
        $email_err = "Please enter a valid email.";
    } else{
        $email = $input_email;
    }
    
    // Validate pass pass
    $input_pass = trim($_POST["pass"]);
    if(empty($input_pass)){
        $pass_err = "Please enter an pass.";     
    } else{
        $pass = $input_pass;
    }
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($pass_err)){

        $sql = "select * from login_data WHERE email=?";
 
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $_POST['email']);
            
            // Set parameters
            $param_name = $email;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $email = $row["email"];
                    $pass = $row["pass"];

                    if(($email==$input_email)&&($pass==$input_pass)){
                        $res_err =  "Logged In.";
                        $mode = $row["account_type"];

                        if ($mode=="recruiter"){
                            header("Location:all_users.php");
                            exit();
                        }
                    }
                    else {
                        $res_err =  "Email or Password is invalid";
                    }
                }else if($result->num_rows == 0){
                    $res_err =  "You havent registered! Or Email is invalid";}
                //header("location: index.php");
               // exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
} 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resumocha</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Login</h2>
                    </div>
                    <p>Please enter your credentials.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($pass_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" name="pass" class="form-control" value="">
                            <span class="help-block"><?php echo $pass_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Login">
                        <a href="index.php" class="btn btn-success">Register</a>
                        <div class="form-group <?php echo (!empty($res_err)) ? 'has-error' : ''; ?>">
                        <br>
                        <?php if($res_err=="Logged In."){
                        echo '<div class= "alert alert-success">
                        Logged In.</div>';
                        }
                        else if(($res_err=="Email or Password is invalid")){
                            echo '<div class= "alert alert-danger">
                            Email or Password is invalid.</div>';
                        }
                        else if(($res_err=="You havent registered! Or Email is invalid")){
                            echo '<div class= "alert alert-danger">
                            You havent registered! Or Email is invalid.</div>';
                        }
                        ?>
                    </form>
                </div>
                
            </div>        
        </div>
    </div>
</body>
</html>