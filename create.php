<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$matric = $name = $class = $age = "";
$matric_err = $name_err = $class_err = $age_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_matric = trim($_POST["matric_no"]);
    if(empty($input_matric)){
        $name_err = "Please enter a matric.";
    } else{
        $matric = $input_matric;
    }
    
    // Validate address
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter an name.";     
    } else{
        $name = $input_name;
    }
    
    // Validate salary
    $input_class = trim($_POST["class"]);
    if(empty($input_class)){
        $class_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_class)){
        $class_err = "Please enter your class.";
    } else{
        $class = $input_class;
    }

    $input_age = trim($_POST["age"]);
    if(empty($input_age)){
        $age_err = "Please enter an age.";     
    } else{
        $age= $input_age;
    }
    
    // Check input errors before inserting in database
    if(empty($matric_err) && empty($name_err) && empty($class_err)&& empty($age_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO kawan (matric, name, class,age) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_matric, $param_name, $param_class, $param_age);
            
            // Set parameters
            $param_matric = $matric;
            $param_name = $name;
            $param_class = $class;
            $param_age = $age;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add new friend record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <div class="form-group">
                            <label>No Matric</label>
                            <input type="text" name="mtric" class="form-control <?php echo (!empty($matric_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $matric; ?>">
                            <span class="invalid-feedback"><?php echo $matric_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Class</label>
                            <textarea name="class" class="form-control <?php echo (!empty($class_err)) ? 'is-invalid' : ''; ?>"><?php echo $class; ?></textarea>
                            <span class="invalid-feedback"><?php echo $class_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Age</label>
                            <input type="text" name="age" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
                            <span class="invalid-feedback"><?php echo $age_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>