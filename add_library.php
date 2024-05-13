<?php
$successMessage = $errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if required fields are empty
    if (empty($_POST["firstName"]) || empty($_POST["lastName"]) || empty($_POST["symbolNo"])) {
        $errorMessage = "First Name, Last Name, and Symbol No are required fields.";
    } else {
        // Connect to your database (replace with your database credentials)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "project";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get form data
        $firstName = $_POST["firstName"];
        $middleName = $_POST["middleName"];
        $lastName = $_POST["lastName"];
        $symbolNo = $_POST["symbolNo"];
        $bookTaken = $_POST["bookTaken"];
        $returnedBook = $_POST["returnedBook"];
        $remainingBook = $_POST["remainingBook"];
        $remainingFee = $_POST["remainingFee"];
        $remarks = $_POST["remarks"];

        // Insert data into the database
        $sql = "INSERT INTO library (First_Name, Middle_Name, Last_Name, Symbol_No, Book_Taken, Returned_Book, Remaining_book, Remaining_fee, Remarks) 
                VALUES ('$firstName', '$middleName', '$lastName', '$symbolNo', '$bookTaken', '$returnedBook', '$remainingBook', '$remainingFee', '$remarks')";

        if ($conn->query($sql) === TRUE) {
            $successMessage = "Student added successfully.";
        } else {
            $errorMessage = "Error adding student: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    }
    
    // Redirect back to crud_library.php
    header("Location: crud_library.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Add Student</h1>
        <?php if (!empty($successMessage)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $successMessage; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <?php if (!empty($errorMessage)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $errorMessage; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <form method="POST" action="add_library.php">
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
                <label for="middleName">Middle Name:</label>
                <input type="text" class="form-control" id="middleName" name="middleName">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>
            <div class="form-group">
                <label for="symbolNo">Symbol No:</label>
                <input type="text" class="form-control" id="symbolNo" name="symbolNo" required>
            </div>
            <div class="form-group">
                <label for="bookTaken">Books Taken:</label>
                <input type="text" class="form-control" id="bookTaken" name="bookTaken">
            </div>
            <div class="form-group">
                <label for="returnedBook">Returned Books:</label>
                <input type="text" class="form-control" id="returnedBook" name="returnedBook">
            </div>
            <div class="form-group">
                <label for="remainingBook">Remaining Books:</label>
                <input type="text" class="form-control" id="remainingBook" name="remainingBook">
            </div>
            <div class="form-group">
                <label for="remainingFee">Remaining Fee:</label>
                <input type="text" class="form-control" id="remainingFee" name="remainingFee">
            </div>
            <div class="form-group">
                <label for="remarks">Remarks:</label>
                <input type="text" class="form-control" id="remarks" name="remarks">
            </div>
            <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
