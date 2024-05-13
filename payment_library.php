<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $symbolNo = $_POST["symbolNo"];
    $lastName = $_POST["lastName"];

    // Check if data exists and update the payment_slip column
    $sql = "SELECT * FROM library  WHERE Symbol_No = '$symbolNo' AND Last_Name = '$lastName'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Data found, proceed to upload the file and update payment_slip column
        $targetDirectory = "images/"; // Directory where you want to store the uploaded files
        $targetFile = $targetDirectory . basename($_FILES["paymentFile"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file is an image
        $check = getimagesize($_FILES["paymentFile"]["tmp_name"]);
        if ($check === false) {
            echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <strong>Error!</strong> File is not an image.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <strong>Error!</strong> Sorry, the file already exists.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            $uploadOk = 0;
        }

        // Check file size (1MB limit)
        if ($_FILES["paymentFile"]["size"] > 1000000) {
            echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <strong>Error!</strong> Sorry, your file is too large.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            $uploadOk = 0;
        }

        // Allow certain file formats (you can modify this for your supported formats)
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <strong>Error!</strong> Sorry, only JPG, JPEG, and PNG files are allowed.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <strong>Error!</strong> Sorry, your file was not uploaded.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
        } else {
            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["paymentFile"]["tmp_name"], $targetFile)) {
                // File uploaded successfully, update the payment_slip column with the file name
                $file_name = basename($_FILES["paymentFile"]["name"]);
                $sql_update = "UPDATE library SET payment_slip = '$file_name' WHERE Symbol_No = '$symbolNo' AND Last_Name = '$lastName'";

                if ($conn->query($sql_update) === TRUE) {
                    echo '<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <strong>Success!</strong> Data found and payment slip updated.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <strong>Error!</strong> Unable to update payment slip.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
                }
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <strong>Error!</strong> Sorry, there was an error uploading your file.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
            }
        }
    } else {
        // Data not found
        echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>Error!</strong> Data not match. Please try again.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Payment Form for library</div>
                    <div class="card-body">
                        <form method="POST" action="payment_library.php" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="symbolNo">Symbol No:</label>
                                <input type="text" class="form-control" id="symbolNo" name="symbolNo" placeholder="Enter Symbol No" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name:</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name" required>
                            </div>
                             <div class="form-group">
                                <label for="paymentFile"></label>
                                <input type="file" class="form-control-file" id="paymentFile" name="paymentFile" accept=".jpg, .jpeg, .png" required>
                                <small class="form-text text-muted">Accepted formats: JPG, JPEG, PNG. Max file size: 1MB.</small>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit Payment</button>
                            <a href="welcome.html" class="btn btn-primary">Go to Home</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mb-4">
        <img src="dummy_qr_code.png" alt="Dummy QR Code" style="width: 200px; height: 200px;">
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
