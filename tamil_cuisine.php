<?php
// Start session to retrieve username
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include 'db_connection.php';

// Retrieve dishes with cuisine "Tamil Cuisine"
$sql = "SELECT * FROM recipes WHERE cuisine = 'Tamil Cuisine'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tamil Cuisine - Dish' Covery</title>
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
            max-height: 100vh; /
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="my-4 text-center" style="color: #f8c000;">Tamil Cuisine</h2>

    <!-- Search Form -->
    <form action="" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search by dish name" name="search">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Dish Name</th>
            <th>Description</th>
            <th>Cooking Time (mins)</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['dishName']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['cookingTime']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><a href="view_dish.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View</a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="5" class="text-center">No dishes found.</td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
