<?php
// Start the session
session_start();

// Include the database connection file
include 'db_connection.php';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch admin user data from the database
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Set the username in the session
            $_SESSION['admin_username'] = $username;
            
            // Redirect to admin dashboard after successful login
            header('Location: admin_dashboard.php');
            exit();
        } else {
            echo '<script>alert("Invalid password. Please try again.");</script>';
        }
    } else {
        echo '<script>alert("Username not found. Please sign up as an admin.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Dish' Covery</title>
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
            <br><br>
            <h2 class="mb-4 text-center" style="color: #f8c000;">Admin Login</h2>
            <form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <p class="mt-3 already-a-user text-center">Don't have an account? <a href="admin_signup.php" style="color: #f8c000;">Sign Up as Admin</a></p>
            <p class="mt-3 already-a-user text-center"><a href="login.php" style="color: #f8c000;">User Login</a></p>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
