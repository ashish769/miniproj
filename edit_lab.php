<?php
$successMessage = $errorMessage = "";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

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
    $damagedequipment = $_POST["Damaged_Equipment"];
    $fineamount = $_POST["Fine_Amount"];
    $remarks = $_POST["remarks"];

    $symbolNo = $firstName = $middleName = $lastName = $damagedequipment=$fineamount = $remarks = "";
    // Update data in the database
    $sql = "UPDATE lab SET 
            First_Name='$firstName', 
            Middle_Name='$middleName', 
            Last_Name='$lastName', 
            Damaged_Equipment='$damagedequipment', 
            Fine_Amount='$fineamount', 
            Remarks='$remarks' 
            WHERE Symbol_No='$symbolNo'";

    if ($conn->query($sql) === true) {
        $successMessage = "Student information updated successfully.";
        // Redirect to crud_library.php
        header("Location: crud_lab.php");
        exit(); // Make sure to exit to prevent further execution
    } else {
        $errorMessage = "Error updating student information: " . $conn->error;
    }

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
    $sql = "SELECT * FROM lab WHERE Symbol_No='$symbolNo'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $firstName = $row["First_Name"];
        $middleName = $row["Middle_Name"];
        $lastName = $row["Last_Name"];
        $damagedequipment = $row["Damaged_Equipment"];
        $fineamount = $row["Fine_Amount"];
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
                <label for="symbolNo">Last Name:</label>
                <input type="text" class="form-control" id="symbolNo" name="symbolNo" value="<?php echo $symbolNo; ?>" required>
            </div>
            <div class="form-group">
                <label for="damagedequipment">Damage Equipment:</label>
                <input type="text" class="form-control" id="damagedequipment" name="damagedequipment" value="<?php echo $damagedequipment; ?>">
            </div>
            <div class="form-group">
                <label for="fineamount">Fine Amount:</label>
                <input type="text" class="form-control" id="fineamount" name="fineamount" value="<?php echo $fineamount; ?>">
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
