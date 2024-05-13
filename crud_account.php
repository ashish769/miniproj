<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-between mb-3">
            <h1>Student Management for Account</h1>
            <a href="add_account.php" class="btn btn-primary">Add New Student</a>
        </div>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Symbol No</th>
                    <th>Total fee to pay</th>
                    <th>last payment amount</th>
                    <th>Remaining Fee</th>
                    <th>character certificate charge</th>
                    <th>Remarks</th>
                    <th>Payment Slip</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
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

                // Fetch data from the database
                $sql = "SELECT * FROM account"; 
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['First_Name']}</td>";
                        echo "<td>{$row['Middle_Name']}</td>";
                        echo "<td>{$row['Last_Name']}</td>";
                        echo "<td>{$row['Symbol_No']}</td>";
                        echo "<td>{$row['Total_Fee_To_Pay']}</td>";  
                        echo "<td>{$row['Last_Payment_Amount']}</td>";
                        echo "<td>{$row['Remaining_fee']}</td>";  
                        echo "<td>{$row['char_certifi_charge']}</td>";  
                        echo "<td>{$row['Remarks']}</td>";
                        echo "<td>";

                        
                        

                       // Display the image from the images folder
                        $imageFolder = 'images/'; // Change this to your images folder path
                        $paymentSlipFileName = $row['payment_slip'];
                        $paymentSlipImagePath = $imageFolder . $paymentSlipFileName;
                        echo "<img src='{$paymentSlipImagePath}' alt='Payment Slip' width='200' height='200'>";

                        echo "</td>";
                        echo "<td>";
                        echo "<a href='edit_account.php?Symbol_No={$row['Symbol_No']}' class='btn btn-warning'>Edit</a>";
                        
                        // Add a button to trigger the delete confirmation dialog
                        echo "<button class='btn btn-danger mr-2' onclick='confirmDelete({$row['Symbol_No']})'>Delete</button>";
                        
                        // Add a hyperlink to remove the photo
                        echo "<a href='remove_photo_account.php' class='btn btn-secondary' onclick='removePhoto({$row['Symbol_No']})'>Remove Photo</a>";
                        
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No data available.</td></tr>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    function removePhoto(symbolNo) {
        if (confirm("Are you sure you want to remove the payment slip photo?")) {
            // Send an AJAX request to a PHP script to remove the photo
            $.ajax({
                url: "remove_photo_account.php",
                type: "POST",
                data: { Symbol_NO: symbolNo },
                success: function (response) {
                    if (response === "success") {
                        // Reload the page to reflect the changes
                        location.reload();
                    } else {
                        alert("Failed to remove the photo.");
                    }
                },
                error: function () {
                    alert("Error occurred while removing the photo.");
                }
            });
        }
    }
    
    function confirmDelete(symbolNo) {
        if (confirm("Are you sure you want to delete this student's record? This action cannot be undone.")) {
            // Redirect to the delete page with Symbol_No
            window.location.href = `delete_account.php?Symbol_No=${symbolNo}`;
        }
    }
    </script>
</body>
</html>
