<?php
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmDelete"])) {
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

    // Get Symbol No to delete
    $symbolNo = $_POST["symbolNo"];

    // Delete data from the database
    $sql = "DELETE FROM lab WHERE Symbol_No='$symbolNo'";

    if ($conn->query($sql) === TRUE) {
        header("Location: crud_lab.php"); // Redirect to the CRUD page after successful deletion
        exit();
    } else {
        $errorMessage = "Error deleting student: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} elseif (isset($_GET["Symbol_No"])) {
    // Retrieve Symbol No from the URL
    $symbolNo = $_GET["Symbol_No"];
} else {
    header("Location: crud_lab.php"); // Redirect to the CRUD page if Symbol No is not provided
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Delete Student</h1>
        <?php if (!empty($errorMessage)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $errorMessage; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <div class="alert alert-warning" role="alert">
            Are you sure you want to delete this student's record? This action cannot be undone.
        </div>
        <form method="POST" action="delete_lab.php">
            <input type="hidden" name="symbolNo" value="<?php echo $symbolNo; ?>">
            <button type="submit" name="confirmDelete" class="btn btn-danger">Confirm Delete</button>
            <a href="crud_lab.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
