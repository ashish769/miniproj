<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get data from the form
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : "";
    $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : "";
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : "";
    $symbolNo = isset($_POST['symbolNo']) ? $_POST['symbolNo'] : "";
    $registrationNo = isset($_POST['registrationNo']) ? $_POST['registrationNo'] : "";
    $faculty = isset($_POST['faculty']) ? $_POST['faculty'] : "";
    $phoneNo = isset($_POST['phoneNo']) ? $_POST['phoneNo'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";

    // Check if Symbol No already exists
    $symbolNoCheck = "SELECT * FROM registration WHERE symbol_no = '$symbolNo'";
    $result = $conn->query($symbolNoCheck);

    if ($result->num_rows > 0) {
        echo '<div style="color: red;">Symbol No is already registered.</div>';
    } else {
        // SQL query to insert data into the 'registration' table
        $sql1 = "INSERT INTO registration (first_name, middle_name, last_name, symbol_no, registration_no, faculty, phone_no, password) 
                VALUES ('$firstName', '$middleName', '$lastName', '$symbolNo', '$registrationNo', '$faculty', '$phoneNo', '$password')";
        $sql2="INSERT INTO account (First_Name, Middle_Name, Last_Name, Symbol_No) VALUES ('$firstName', '$middleName', '$lastName', '$symbolNo')";
        if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
            // Success message
            echo '<div style="color: green;">Registration successful!</div>';
            echo '<script>window.location.href = "login.php";</script>'; // Redirect to login.php after displaying success message
            exit();
        } else {
            // Error message
            echo '<div style="color: red;">Error: ' . $conn->error . '</div>';
        }
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for labels and header */
        .custom-label {
            color: #3498db;
            font-family: 'Arial', sans-serif;
        }

        .card-header {
            background-color: #3498db;
            color: #fff;
            font-family: 'Arial', sans-serif;
        }

        /* Custom error message style */
        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Signup
                </div>
                <div class="card-body">
                    <!-- Form -->
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="custom-label">
                        <div class="mb-3">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" required>
                        </div>
                        <div class="mb-3">
                            <label for="middleName">Middle Name</label>
                            <input type="text" class="form-control" id="middleName" name="middleName">
                        </div>
                        <div class="mb-3">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" required>
                        </div>
                        <div class="mb-3">
                            <label for="symbolNo">Symbol No</label>
                            <input type="text" class="form-control" id="symbolNo" name="symbolNo" required>
                        </div>
                        <div class="mb-3">
                            <label for="registrationNo">Registration No</label>
                            <input type="text" class="form-control" id="registrationNo" name="registrationNo">
                        </div>
                        <div class="mb-3">
                            <label for="faculty" class="custom-label">Faculty</label>
                            <select class="form-control" id="faculty" name="faculty">
                                <option value="IT">IT</option>
                                <option value="CMP">CMP</option>
                                <option value="CIVIL">CIVIL</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNo">Phone No</label>
                            <input type="text" class="form-control" id="phoneNo" name="phoneNo" required>
                        </div>
                        <div class="mb-3">
                            <label for="password">Password (8 characters, including uppercase, number, and symbol)</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                   required>
                        </div>
                        <div id="passwordError" class="error-message"></div>
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // JavaScript code for password matching validation
    document.getElementById("signup-form").addEventListener("submit", function (e) {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;
        const passwordError = document.getElementById("passwordError");

        if (password !== confirmPassword) {
            passwordError.textContent = "Passwords do not match.";
            passwordError.style.color = "red";
            e.preventDefault(); // Prevent form submission
        } else {
            passwordError.textContent = ""; // Clear
        }
    });
</script>
</body>
</html>