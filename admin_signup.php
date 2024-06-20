<?php
// Start the session
session_start();

// Include the database connection file
include 'db_connection.php';

// Handle secret code verification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $secretCode = $_POST['secretCode'];
    if ($secretCode !== '2252') {
        echo '<script>alert("Invalid secret code. Access denied."); window.location.href = "admin_login.php";</script>';
        exit(); // Exit if the secret code is invalid
    } else {
        // Secret code is correct, proceed to signup form
        $_SESSION['secretCodeVerified'] = true;
    }
}

// Handle signup form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['secretCodeVerified'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if all fields are filled
    if (empty($name) || empty($username) || empty($password)) {
        echo '<script>alert("All fields are required.");</script>';
    } else {
        // Check if the username already exists
        $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<script>alert("Username already exists. Please choose a different username.");</script>';
        } else {
            // Insert user data into the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO admin_users (name, username, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sss", $name, $username, $hashedPassword);

            if ($stmt->execute()) {
                // Set the username in the session
                $_SESSION['admin_username'] = $username;
                // Redirect to admin dashboard
                header('Location: admin_dashboard.php');
                exit();
            } else {
                echo '<script>alert("Signup failed. Please try again later.");</script>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #ffbd59;
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .login-form {
            margin-top: 20px;
        }

        .form-group label {
            color: #000;
            text-align: left;
        }

        .center-vertically {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }

        .already-a-user {
            color: #000;
        }

        video {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <video autoplay muted loop>
                <source src="img_vds\logo.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="col-md-6 center-vertically">
            <hr class="my-4">
            <h2 class="mb-4 text-center" style="color: #f8c000;">Admin Signup</h2>
            <form class="login-form" method="post" id="signupForm" action="admin_signup.php">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <input type="hidden" id="secretCode" name="secretCode">
                <button type="button" class="btn btn-primary" onclick="openSecretCodeModal()">Signup</button>
            </form>
            <p class="mt-3 already-a-user text-center">Already have an account? <a href="admin_login.php" style="color: #f8c000;">Login</a></p>
        </div>
    </div>
</div>

<!-- Modal for secret code input -->
<div class="modal fade" id="secretCodeModal" tabindex="-1" role="dialog" aria-labelledby="secretCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="secretCodeModalLabel">Enter Secret Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="password" class="form-control" id="secretCodeInput" placeholder="Enter secret code">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="checkSecretCode()">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function openSecretCodeModal() {
        $('#secretCodeModal').modal('show');
    }

    function checkSecretCode() {
        var secretCode = document.getElementById('secretCodeInput').value;
        if (secretCode === '2252') {
            // Set the value of the secret code field
            document.getElementById("secretCode").value = secretCode;
            // Submit the form
            document.getElementById("signupForm").submit();
        } else {
            alert("Invalid secret code. Please try again.");
        }
    }
</script>

</body>
</html>
