<?php
// Initialize the session
session_start();

// Check if the user is logged in; if not, redirect to the login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

// Include config file
require_once "config.php";

// Initialize variables
$employees = [];

// Query to select all employees
$sql = "SELECT * FROM employees";

if($result = $conn->query($sql)){
    // Fetch all employees
    $employees = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error fetching employees: " . $conn->error;
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
        <a href="add_employee.php" class="btn btn-primary">Add Employee</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Profile Picture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($employees)): ?>
                    <?php foreach($employees as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["firstname"]); ?></td>
                            <td><?php echo htmlspecialchars($row["lastname"]); ?></td>
                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                            <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                            <td><?php echo htmlspecialchars($row["position"]); ?></td>
                            <td>
                                <?php if (!empty($row["profile_picture"])): ?>
                                    <img src="<?php echo htmlspecialchars($row["profile_picture"]); ?>" alt="Profile Picture" width="50">
                                <?php else: ?>
                                    No picture
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit_employee.php?id=<?php echo urlencode($row["id"]); ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_employee.php?id=<?php echo urlencode($row["id"]); ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No employees found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
