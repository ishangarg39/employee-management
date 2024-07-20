<?php
// Include config file
require_once "config.php";

// Define the username and password
$username = 'admin';
$password = 'password'; // Change this to your desired password

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert the new user into the database
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";

if($stmt = $conn->prepare($sql)){
    $stmt->bind_param("ss", $username, $hashed_password);

    if($stmt->execute()){
        echo "User created successfully.";
    } else{
        echo "Error: Could not execute the query: " . $stmt->error;
    }

    $stmt->close();
} else{
    echo "Error: Could not prepare the query: " . $conn->error;
}

// Close the connection
$conn->close();
?>
