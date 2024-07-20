<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$firstname = $lastname = $email = $phone = $position = "";
$profile_picture = "";
$firstname_err = $lastname_err = $email_err = $phone_err = $position_err = $profile_picture_err = "";

// Get employee id from URL
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate inputs
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $position = trim($_POST["position"]);

    // Check if profile picture is updated
    if(isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0){
        $allowed = array("jpg" => "image/jpeg", "jpeg" => "image/jpeg", "png" => "image/png", "gif" => "image/gif");
        $filename = $_FILES["profile_picture"]["name"];
        $filetype = $_FILES["profile_picture"]["type"];
        $filesize = $_FILES["profile_picture"]["size"];

        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) {
            die("Error: Please select a valid file format.");
        }

        // Verify file size - 5MB maximum
        if($filesize > 5 * 1024 * 1024) {
            die("Error: File size is larger than the allowed limit.");
        }

        // Verify MIME type
        if(in_array($filetype, $allowed)){
            // Check if file already exists
            if(file_exists("uploads/" . $filename)){
                echo $filename . " already exists.";
            } else{
                // Move the file to the upload directory
                move_uploaded_file($_FILES["profile_picture"]["tmp_name"], "uploads/" . $filename);
                $profile_picture = "uploads/" . $filename;
            } 
        } else{
            die("Error: There was a problem uploading your file. Please try again."); 
        }
    }

    // Prepare an update statement
    $sql = "UPDATE employees SET firstname=?, lastname=?, email=?, phone=?, position=?, profile_picture=? WHERE id=?";

    if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssssssi", $param_firstname, $param_lastname, $param_email, $param_phone, $param_position, $param_profile_picture, $param_id);

        // Set parameters
        $param_firstname = $firstname;
        $param_lastname = $lastname;
        $param_email = $email;
        $param_phone = $phone;
        $param_position = $position;
        $param_profile_picture = $profile_picture;
        $param_id = $id;

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records updated successfully. Redirect to dashboard
            header("location: dashboard.php");
            exit();
        } else{
            echo "Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();

    // Close connection
    $conn->close();
} else {
    // Prepare a select statement
    $sql = "SELECT * FROM employees WHERE id = ?";
    if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);

        // Set parameters
        $param_id = $id;

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();
            if($result->num_rows == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);

                // Retrieve individual field value
                $firstname = $row["firstname"];
                $lastname = $row["lastname"];
                $email = $row["email"];
                $phone = $row["phone"];
                $position = $row["position"];
                $profile_picture = $row["profile_picture"];
            } else{
                // URL doesn't contain valid id. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    
    // Close statement
    $stmt->close();
    
    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="wrapper">
        <h2>Edit Employee</h2>
        <p>Please edit the input values and submit to update the employee record.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                <label>First Name</label>
                <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                <span class="help-block"><?php echo $firstname_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                <label>Last Name</label>
                <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                <span class="help-block"><?php echo $lastname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                <span class="help-block"><?php echo $phone_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($position_err)) ? 'has-error' : ''; ?>">
                <label>Position</label>
                <input type="text" name="position" class="form-control" value="<?php echo $position; ?>">
                <span class="help-block"><?php echo $position_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($profile_picture_err)) ? 'has-error' : ''; ?>">
                <label>Profile Picture</label>
                <input type="file" name="profile_picture" class="form-control">
                <span class="help-block"><?php echo $profile_picture_err; ?></span>
                <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" width="100">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>
