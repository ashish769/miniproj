<?php
$successMessage = $errorMessage = "";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Initialize variables
$symbolNo = $firstName = $middleName = $lastName = $totalfeetopay = $lastpaymentamount  = $remainingFee=$charactercertificatefee = $remarks = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $symbolNo = $_POST["symbolNo"];
    $firstName = $_POST["firstName"];
    $middleName = $_POST["middleName"];
    $lastName = $_POST["lastName"];
    $totalfeetopay = $_POST["totalfeetopay"];
    $lastpaymentamount = $_POST["lastpaymentamount"];
    $remainingfee = $_POST["remainingfee"];
    $charactercertificatefee=$_POST["charactercertificatecharge"];
    $remarks = $_POST["remarks"];

    // Update data in the database
    $sql = "UPDATE account SET 
            First_Name='$firstName', 
            Middle_Name='$middleName', 
            Last_Name='$lastName', 
            Book_Taken='$bookTaken', 
            Returned_Book='$returnedBook', 
            Remaining_book='$remainingBook', 
            Remaining_fee='$remainingFee',
            char_Certifi_charge='$charactercertificatecharge',
            Remarks='$remarks' 
            WHERE Symbol_No='$symbolNo'";

    if ($conn->query($sql) === true) {
        $successMessage = "Student information updated successfully.";
        // Redirect to crud_library.php
        header("Location: crud_account.php");
        exit(); // Make sure to exit to prevent further execution
    } else {
        $errorMessage = "Error updating student information: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}

if (isset($_GET["Symbol_No"])) {
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $symbolNo = $_GET["Symbol_No"];

    // Retrieve data for the given Symbol No
    $sql = "SELECT * FROM account WHERE Symbol_No='$symbolNo'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $firstName = $row["First_Name"];
        $middleName = $row["Middle_Name"];
        $lastName = $row["Last_Name"];
        $totalfeetopay = $row["Total_Fee_To_Pay"];
        $remainingFee = $row["Remaining_fee"];
        $charactercertificatefee = $row["char_certifi_charge"];
        $remarks = $row["Remarks"];
    } else {
        $errorMessage = "Student with Symbol No '$symbolNo' not found.";
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
    <title>Edit Student</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Student</h1>
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
        <form method="POST" action="edit_lab.php">
            <input type="hidden" name="symbolNo" value="<?php echo $symbolNo; ?>">
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required>
            </div>
            <div class="form-group">
                <label for="middleName">Middle Name:</label>
                <input type="text" class="form-control" id="middleName" name="middleName" value="<?php echo $middleName; ?>">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $lastName; ?>" required>
            </div>
            <div class="form-group">
                <label for="symbolNo">Symbol_No:</label>
                <input type="text" class="form-control" id="symbolNo" name="symbolNo" value="<?php echo $symbolNo; ?>" required>
            </div>
            <div class="form-group">
                <label for="totalfeetopay">Total fee to pay:</label>
                <input type="text" class="form-control" id="totalfeetopay" name="totalfeetopay" value="<?php echo $totalfeetopay; ?>">
            </div>
            <div class="form-group">
                <label for="lastpaymentamount">last payment amount:</label>
                <input type="text" class="form-control" id="lastpaymentamount" name="lastpaymentamount" value="<?php echo $lastpaymentamount; ?>">
            </div>

            <div class="form-group">
                <label for="remainingFee">Remaining Fee:</label>
                <input type="text" class="form-control" id="remainingFee" name="remainingFee" value="<?php echo $remainingFee; ?>">
            </div>
            <div class="form-group">
                <label for="charactercertificatefee">character certificate fee:</label>
                <input type="text" class="form-control" id="charactercertificatefee" name="charactercertificatefee" value="<?php echo $charactercertificatefee; ?>">
            </div>
            <div class="form-group">
                <label for="remarks">Remarks:</label>
                <input type="text" class="form-control" id="remarks" name="remarks" value="<?php echo $remarks; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Student</button>
        </form>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
