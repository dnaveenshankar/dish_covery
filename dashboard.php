<?php
// Retrieve username from the session
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
$username = $_SESSION['username'];

// Logout handling
if (isset($_GET['logout'])) {
    // Destroy the session
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Dish' Covery</title>
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

        .dashboard-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .dashboard-title h2 {
            color: #f8c000;
            margin-bottom: 10px;
        }

        .dashboard-title p {
            color: #000;
            margin: 0;
        }

        .dashboard-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
            justify-content: center;
        }

        .dashboard-button {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
        }

        .dashboard-button:hover {
            transform: translateY(-5px);
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.2);
        }

        .dashboard-button img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .logo-container {
            width: 150px; /* Adjust the size of the container as needed */
            height: 150px;
            overflow: hidden;
            border-radius: 50%; /* Makes the container circular */
            margin: 0 auto; /* Centers the container horizontally */
        }

        .logo-img {
            width: 100%;
            height: auto;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="dashboard-title">
        <div class="logo-container">
            <img src="img_vds\logo.png" alt="Logo" class="logo-img">
        </div>
        <h2>Dish' Covery</h2>
        <p>Dive. Discover. Dish</p>
    </div>

    <h3 class="text-center mb-4">Welcome, <?php echo $username; ?>!</h3>
    <div class="dashboard-buttons">
        <a href="dishcovery.php?username=<?php echo $username; ?>" class="dashboard-button">
            <img src="img_vds\dishcovery.png" alt="Dish' Covery">
        </a>
        <a href="sweets.php?username=<?php echo $username; ?>" class="dashboard-button">
            <img src="img_vds\sweets.png" alt="Sweets">
        </a>
        <a href="tamil_cuisine.php?username=<?php echo $username; ?>" class="dashboard-button">
            <img src="img_vds\tamil_cuisine.png" alt="Tamil Cuisine">
        </a>
        <a href="punjabi_cuisine.php?username=<?php echo $username; ?>" class="dashboard-button">
            <img src="img_vds\punjabi_cuisine.png" alt="Punjabi Cuisine">
        </a>
        <a href="kerala_cuisine.php?username=<?php echo $username; ?>" class="dashboard-button">
            <img src="img_vds\kerala_cuisine.png" alt="Kerala Cuisine">
        </a>
        <a href="north_indian_cuisine.php?username=<?php echo $username; ?>" class="dashboard-button">
            <img src="img_vds\north_indian_cuisine.png" alt="North Indian Cuisine">
        </a>
        <a href="south_indian_cuisine.php?username=<?php echo $username; ?>" class="dashboard-button">
            <img src="img_vds\south_indian_cuisine.png" alt="South Indian Cuisine">
        </a>
        <a href="other_cuisines.php?username=<?php echo $username; ?>" class="dashboard-button">
            <img src="img_vds\other_cuisines.png" alt="Other Cuisines">
        </a>
        <a href="add_dish.php?username=<?php echo $username; ?>" class="dashboard-button">
            <img src="img_vds\add_dish.png" alt="Add your Dish">
        </a>

    </div>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <br>
            <a href="logout.php" class="btn btn-danger">Logout</a>
            <a href="feedback.php?username=<?php echo $username; ?>" class="btn btn-info ml-2">Give Feedback</a>

        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
