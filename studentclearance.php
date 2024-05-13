<?php
// Database connection parameters
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'project'; // Replace with your database name

// Create a database connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize a variable to track success
$success = false;

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $dob = $_POST["dob"];
    $parentName = $_POST["parentName"];
    $faculty = $_POST["faculty"];
    $batch = $_POST["batch"];
    $puRegNo = $_POST["puRegNo"];
    $examRollNo = $_POST["examRollNo"];
    $contactNo = $_POST["contactNo"];
    $email = $_POST["email"];
    $leaveReason = $_POST["leaveReason"];
    $documentType = $_POST["documentType"];
    $Starting_Date = $_POST["Starting_Date"];
    $Ending_Date = $_POST["Ending_Date"];

    // Handle photo upload
    if (isset($_FILES["photo"])) {
        $photo = $_FILES["photo"];
        $photo_tmp_name = $photo["tmp_name"];

        // Read the image data
        $photo_data = file_get_contents($photo_tmp_name);

        // Encode the image data as a base64 string
        $photo_base64 = base64_encode($photo_data);

        // Insert form data into the database, including the base64 encoded photo
        $sql = "INSERT INTO clearance_form_data (name, dob, parentName, faculty, batch, puRegNo, examRollNo, contactNo, email, leaveReason, documentType, Starting_Date, Ending_Date, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssssss", $name, $dob, $parentName, $faculty, $batch, $puRegNo, $examRollNo, $contactNo, $email, $leaveReason, $documentType, $Starting_Date, $Ending_Date, $photo_base64);

        if ($stmt->execute()) {
            $success_message = "Form data inserted successfully.";
            $success = true;
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $error_message = "No photo uploaded.";
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Reset default browser styles */
        body,
        h2,
        form {
            margin: 0;
            padding: 0;
        }

        /* Style the body background */
        body {
            background-size: cover;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            /* Set a light background color */
        }

        /* Center the container */
        .container {
            width: 80%;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        /* Center the form title and add some color */
        h2 {
            text-align: center;
            color: #007BFF;
            /* Blue color */
            margin-top: 20px;
        }

        /* Style form groups */
        .form-group {
            margin-bottom: 15px;
        }

        /* Style labels with color */
        label {
            font-weight: bold;
            color: #333;
            /* Dark gray color */
        }

        /* Style input fields */
        input[type="text"],
        input[type="date"],
        input[type="tel"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
        }

        /* Style the select dropdown */
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: url('down-arrow.png') no-repeat right center;
            background-size: 20px;
        }

        /* Style the submit button with a colorful background */
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            /* Green color */
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
            /* Darker green color on hover */
        }

        /* Style the file upload information text */
        .file-upload-info {
            color: red; /* Set the text color to red */
            font-size: 14px; /* Adjust the font size as needed */
        }

        /* Add this style for the success message */
        .success-message {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            display: none;
        }

        /* Add this style for the confirmation dialog */
        .confirmation-dialog {
            background-color: rgba(255, 0, 0, 0.1);
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            display: none;
        }

        .confirmation-dialog p {
            color: red;
            font-weight: bold;
        }

        .confirmation-dialog button {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
    <title>STUDENT CLEARANCE FORM</title>
</head>

<body>
    <div class="container">
        <h2>STUDENT CLEARANCE FORM</h2>
        <h4>This form data are uneditable after you submit the data, so double-check the entered data before submitting.</h4>
        <form action="studentclearance.php" method="post" enctype="multipart/form-data" onsubmit="return confirmSubmission()">
            
        
        <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>


            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>
            </div>

           
           
           
            <div class="form-group">
                <label for="parentName">Father or Mother Name:</label>
                <input type="text" id="parentName" name="parentName" required>
            </div>

            <div class="form-group">
                <label for="faculty">Faculty:</label>
                <select id="faculty" name="faculty" required>
                    <option value="Civil">Civil Engineering </option>
                    <option value="Computer">Computer Engineering</option>
                    <option value="IT">IT Engineering</option>
                    <option value="Electronics">Electronics Engineering</option>
                </select>
            </div>


            <div class="form-group">
                <label for="batch">Batch/Program:</label>
                <input type="text" id="batch" name="batch" required>
            </div>


            <div class="form-group">
                <label for="puRegNo">PU Registration Number:</label>
                <input type="text" id="puRegNo" name="puRegNo" required>
            </div>


            <div class="form-group">
                <label for="examRollNo">examRollNo:</label>
                <input type="text" id="examRollNo" name="examRollNo" required>
            </div>


            <div class="form-group">
                <label for="contactNo">Contact Number:</label>
                <input type="tel" id="contactNo" name="contactNo" required>
            </div>


            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required placeholder="example@example.com">
            </div>


            <div class="form-group">
                <label for="leaveReason">Reason for Leaving College:</label>
                <select id="leaveReason" name="leaveReason" required>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>



            <div class="form-group">
            <label for="documentType">Type of Document:</label>
            <select id="documentType" name="documentType" required>
                <option value="" disabled selected>Select Document Type</option>
                <option value="Character Certificate">Character Certificate</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>
            </div>

            <div class="form-group">
                <label for="Starting_Date">Starting Date:</label>
                <input type="date" id="Starting_Date" name="Starting_Date" required>
            </div>

            <div class="form-group">
                <label for="Ending_Date">Ending Date:</label>
                <input type="date" id="Ending_Date" name="Ending_Date" required>
            </div>




            
        

            <div class="form-group">
                <label for="photo">Attach Passport-Size Photo:</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>
                <small class="file-upload-info">Accepted formats: JPG, JPEG, PNG (less than 1mb)</small>
            </div>

            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>

        <!-- Success message -->
        <div id="successMessage" class="success-message">
            <?php if ($success) {
                echo $success_message;
            } ?>
        </div>

        <!-- Confirmation dialog -->
        <div id="confirmationDialog" class="confirmation-dialog">
            <p>This is a sensitive entry. Do you want to continue?</p>
            <button onclick="submitFormAnyway()">Submit Anyway</button>
            <button onclick="cancelSubmission()">Go Back to the Form</button>
        </div>

        <script>
            var submissionConfirmed = false;

            // Function to display success message and prevent form resubmission
            function validateForm() {
                if (submissionConfirmed) {
                    document.getElementById('successMessage').style.display = 'block';
                    return false; // Prevent form submission
                }
                return true; // Allow form submission
            }

            // Function to show confirmation dialog
            function confirmSubmission() {
                var confirmationDialog = document.getElementById('confirmationDialog');
                confirmationDialog.style.display = 'block';
                return false; // Prevent form submission
            }

            // Function to submit the form anyway
            function submitFormAnyway() {
                submissionConfirmed = true;
                document.getElementById('confirmationDialog').style.display = 'none';
                document.getElementById('successMessage').style.display = 'block';
                document.querySelector('form').submit();
            }

            // Function to cancel submission and go back to the form
            function cancelSubmission() {
                document.getElementById('confirmationDialog').style.display = 'none';
            }
        </script>
    </div>
</body>

</html>
