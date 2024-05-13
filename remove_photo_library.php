<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Symbol_NO"])) {
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

    // Get Symbol No to delete photo
    $symbolNo = $_POST["Symbol_NO"];

    // Remove the photo by setting it to an empty value (assuming your photo column is named 'payment_slip')
    $sql = "UPDATE library SET payment_slip = '' WHERE Symbol_No = '$symbolNo'";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request";
}
header("Location: crud_library.php");
    exit;
?> 
