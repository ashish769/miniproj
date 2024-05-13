<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Status</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Check Status for library</div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="symbolNo">Symbol No:</label>
                                <input type="text" class="form-control" id="symbolNo" name="symbolNo" placeholder="Enter Symbol No">
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name:</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name">
                            </div>
                            <button type="submit" class="btn btn-primary" name="check-status-button">Check Status</button>
                            <a href="payment_library.php" class="btn btn-primary">Go to Payment</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Check if the form was submitted
    if (isset($_POST["check-status-button"])) {
        // Include your database connection code here
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "project";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $symbolNo = $_POST["symbolNo"];
        $lastName = $_POST["lastName"];

        // SQL query to fetch data from the 'account' table based on Symbol No and Last Name
        $sql = "SELECT * FROM library WHERE Symbol_No = '$symbolNo' AND Last_Name = '$lastName'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display success message
            echo '<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <strong>Success!</strong> Data found and displayed below.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';

            // Display data in a table
            echo '<table class="table mt-3">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Symbol No</th>
                            <th>Book taken</th>
                            <th>Returned book</th>
                            <th>Remaining Book</th>
                            <th>Remaining Fee</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row["First_Name"] . '</td>
                        <td>' . $row["Middle_Name"] . '</td>
                        <td>' . $row["Last_Name"] . '</td>
                        <td>' . $row["Symbol_No"] . '</td>
                        <td>' . $row["Book_Taken"] . '</td>
                        <td>' . $row["Returned_Book"] . '</td>
                        <td>' . $row["Remaining_book"] . '</td>
                        <td>' . $row["Remaining_fee"] . '</td>
                        <td>' . $row["Remarks"] . '</td>
                      </tr>';
            }

            echo '</tbody></table>';
        } else {
            // Display error message
            echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <strong>Error!</strong> Data not found. Please try again.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
        }

        // Close the database connection
        $conn->close();
    }
    ?>

    <!-- Bootstrap JS and jQuery  -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
