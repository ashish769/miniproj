<?php
session_start();

// Initialize error message
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $symbolNo = isset($_POST['symbolNo']) ? $_POST['symbolNo'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $registrationno = isset($_POST['registrationno']) ? $_POST['registrationno'] : "";

    $sql = "SELECT * FROM registration WHERE symbol_no = '$symbolNo' AND password = '$password' AND registration_no = '$registrationno'";

    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        // Successful login
        $_SESSION['symbolNo'] = $symbolNo;
        header("Location: welcome.html"); // Redirect to welcome page or dashboard
        exit();
    } else {
        // Invalid credentials
        $error_message = "Invalid credentials. Please try again.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            padding: 20px;
        }

        .login-box {
            max-width: 400px;
            margin: 0 auto;
        }

        h2 {
            color: #3498db;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .message {
            margin-top: 10px;
            padding: 10px;
            border-radius: 3px;
        }

        .success {
            background-color: #27ae60;
            color: #fff;
        }

        .error {
            background-color: #e74c3c;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="login-box">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <div class="input-container">
                <label for="symbolNo">Symbol No</label>
                <input type="text" id="symbolNo" name="symbolNo" required>
            </div>
            <div class="input-container">
                <label for="registrationno">Registration No</label>
                <input type="text" id="registrationno" name="registrationno" required>
            </div>
            <div class="input-container">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <?php if (!empty($error_message)) { ?>
            <div class="message error">
                <?php echo $error_message; ?>
            </div>
        <?php } ?>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>
</div>
</body>
</html>
