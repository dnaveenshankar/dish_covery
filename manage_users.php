<?php
// Include the database connection file
include 'db_connection.php';

// Retrieve username from the URL
session_start();
if (!isset($_SESSION['username']) && isset($_GET['username'])) {
    $_SESSION['username'] = $_GET['username'];
} elseif (!isset($_SESSION['username'])) {
    // Redirect to login if username is not set
    header('Location: admin_login.php');
    exit();
}

// Retrieve username from session
$username = $_SESSION['username'];

// Query to fetch all users
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
            max-width: 800px;
            width: 100%;
            overflow: auto; /* Add overflow property for scrolling */
            max-height: 100vh; /* Set maximum height to 80% of viewport height */
        }

        .table-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Manage Users</h2>

    <div class="table-container">
        <table class="table table-striped users">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['username']}</td>";
                echo "<td><a href='delete_user.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <a href="admin_dashboard.php?username=<?php echo $username; ?>" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
