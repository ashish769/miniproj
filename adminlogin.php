<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Additional custom styles */

        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Admin Login</h2>
            <?php
            if (!empty($error_message)) {
                echo '<div class="alert alert-danger alert-dismissible">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo $error_message;
                echo '</div>';
            }
            if (!empty($success_message)) {
                echo '<div class="alert alert-success alert-dismissible">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo $success_message;
                echo '</div>';
            }
            ?>
            <form method="post">
                <div class="form-group">
                    <label for="department">Department:</label>
                    <select class="form-control" id="department" name="department" required>
                        <option value="lab">Lab</option>
                        <option value="account">Account</option>
                        <option value="exam">Exam</option>
                        <option value="HOD">HOD</option>
                        <option value="library">Library</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="adminid">Username:</label>
                    <input type="text" class="form-control" id="adminid" name="adminid" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>

    <!-- Add Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();

// Initialize error message
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Database connection parameters
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "project";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $department = isset($_POST['department']) ? $_POST['department'] : "";
    $username = isset($_POST['adminid']) ? $_POST['adminid'] : ""; // Changed the name attribute to match the form
    $password = isset($_POST['password']) ? $_POST['password'] : "";

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM admin WHERE adminid = ? AND password = ? AND department = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $department);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['username'] = $username;

        // Determine the redirect URL based on the department
        switch ($department) {
            case 'lab':
                header("Location: lab_welcome.html");
                break;
            case 'account':
                header("Location: account_welcome.html");
                break;
            case 'exam':
                header("Location: exam_welcome.html");
                break;
            case 'HOD':
                header("Location: hod_welcome.html");
                break;
            case 'library':
                header("Location: library_admin.php");
                break;
            
        }
        exit();
    } else {
        // Invalid credentials
        $error_message = "Invalid credentials. Please try again.";
    }

    $stmt->close();
    $conn->close();
}
?>
