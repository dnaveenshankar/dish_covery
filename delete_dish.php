<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Check if dish ID is provided and is numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $dish_id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Dish</title>
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
            max-width: 600px;
            width: 100%;
            overflow: auto; /* Add overflow property for scrolling */
            max-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center" style="color: #f8c000;">Confirm Deletion</h2>
        <p class="text-center">Are you sure you want to delete this dish?</p>
        <div class="text-center">
            <a href="delete_dish.php?id=<?php echo $dish_id; ?>" class="btn btn-danger mr-2">Yes</a>
            <a href="view_dishes.php" class="btn btn-secondary">No</a>
        </div>
    </div>
</body>
</html>
<?php
} else {
    // Redirect to error page if no dish ID is provided
    header('Location: error.php');
    exit();
}
?>
