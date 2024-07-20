<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$firstname = $lastname = $email = $phone = $position = "";
$profile_picture = "";
$firstname_err = $lastname_err = $email_err = $phone_err = $position_err = $profile_picture_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate inputs
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $position = trim($_POST["position"]);

    // Validate file upload
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
    } else{
        die("Error: " . $_FILES["profile_picture"]["error"]);
    }

    // Prepare an insert statement
    $sql = "INSERT INTO employees (firstname, lastname, email, phone, position, profile_picture) VALUES (?, ?, ?, ?, ?, ?)";

    if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssssss", $param_firstname, $param_lastname, $param_email, $param_phone, $param_position, $param_profile_picture);

        // Set parameters
        $param_firstname = $firstname;
        $param_lastname = $lastname;
        $param_email = $email;
        $param_phone = $phone;
        $param_position = $position;
        $param_profile_picture = $profile_picture;

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records created successfully. Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else{
            echo "Something went wrong. Please try again later.";
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
    <title>Add Employee</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="wrapper">
        <h2>Add Employee</h2>
        <p>Please fill this form to add an employee.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>
