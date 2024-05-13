<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Reset default browser styles */
        body, h1, ul, li, button, table, th, td {
            margin: 0;
            padding: 0;
        }

        /* Style the body background */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
        }

        /* Style the dashboard header */
        .dashboard-header {
            background-color: #007BFF; 
            color: #fff;
            padding: 20px;
        }

        .navbar {
            background-color: #FCE7C7; 
            list-style: none;
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }

        button {
            color: #fff; 
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button.accept-button {
            background-color: #FFD700; /* Yellow background color for Accept button */
        }

        button.decline-button {
            background-color: #FFD700; /* Yellow background color for Decline button */
        }

        button.validate-button {
            background-color: #4CAF50; /* Green background color for Validate button */
        }

        button.validate-button.clicked {
            background-color: #45a049; /* Darker green color for clicked Validate button */
        }

        button.accept-button.clicked {
            background-color: #4CAF50; /* Green background color for clicked Accept button */
        }

        button.decline-button.clicked {
            background-color: #FF6347; /* Red background color for clicked Decline button */
        }

        button.validate-button:hover {
            background-color: #45a049; /* Darker green color on hover for Validate button */
        }

        /* Style the table */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            text-align: left;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        #requests-button {
            background-color: #4CAF50; 
        }

        #requests-button:hover {
            background-color: #45a049; /* Darker green color on hover for Requests button */
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        <h1>Library Admin Dashboard</h1>
    </div>
    <ul class="navbar">
        <li>
            <button id="requests-button">Requests</button>
        </li>
    </ul>

    <!-- Table to display data from the database -->
    <table id="student-clearance-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Father/Mother Name</th>
                <th>Faculty</th>
                <th>PU Registration Number</th>
                <th>Symbolno</th>
                <th>Contact Number</th>
                <th>Email Address</th>
                <th>Reason for Leaving College</th>
                <th>Type of Document</th>
                <th>Batch/Program</th>
                <th>Validation</th> 
                <th>Remarks</th> 
                <th>Photo</th> 
            </tr>
        </thead>
        <tbody>
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

            // Query to fetch data from the database
            $sql = "SELECT * FROM clearance_form_data";
            $result = $conn->query($sql);

            // Check if there are any rows in the result
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["dob"] . "</td>";
                    echo "<td>" . $row["parentName"] . "</td>";
                    echo "<td>" . $row["faculty"] . "</td>";
                    echo "<td>" . $row["puRegNo"] . "</td>";
                    echo "<td>" . $row["examRollNo"] . "</td>"; 
                    echo "<td>" . $row["contactNo"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["leaveReason"] . "</td>";
                    echo "<td>" . $row["documentType"] . "</td>";
                    echo "<td>" . $row["batch"] . "</td>";
                    echo "<td><button class='validate-button' onclick='validateClicked(this)'>Validate</button></td>";
                    echo "<td><button class='accept-button' onclick='acceptClicked(this)'>Accept</button><button class='decline-button' onclick='declineClicked(this)'>Decline</button></td>";
                    echo "<td><img src='data:image/jpeg;base64," . $row["photo"] . "' width='100' height='100' alt='Student Photo'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='14'>No data available</td></tr>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </tbody>
    </table>

    <!-- JavaScript to toggle the table visibility -->
    <script>
        const requestsButton = document.getElementById("requests-button");
        const table = document.getElementById("student-clearance-table");

        requestsButton.addEventListener("click", () => {
            // Toggle the visibility of the table
            if (table.style.display === "none") {
                table.style.display = "table";
            } else {
                table.style.display = "none";
            }
        });

        // Function to handle Validate button click
        function validateClicked(button) {
            button.classList.add("clicked");
            setTimeout(() => {
                button.classList.remove("clicked");
            }, 500); // Remove the "clicked" class after 500 milliseconds (0.5 seconds)
        }

        // Function to handle Accept button click
        function acceptClicked(button) {
            button.classList.add("clicked");
        }

        // Function to handle Decline button click
        function declineClicked(button) {
            button.classList.add("clicked");
        }
    </script>
</body>
</html>
