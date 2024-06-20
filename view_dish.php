<?php
// Start session to retrieve username
session_start();

// Include database connection
include 'db_connection.php';

// Check if dish ID is provided in the URL
if (isset($_GET['id'])) {
    $dish_id = $_GET['id'];

    // Fetch dish details from the database
    $sql = "SELECT * FROM recipes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dish_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch dish details
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $dishName = $row['dishName'];
        $description = $row['description'];
        $ingredients = $row['ingredients'];
        $cookingTime = $row['cookingTime'];
        $process = $row['process'];
        $cuisine = $row['cuisine'];
        $type = $row['type'];
        $image_path = $row['image_path'];
        $created_by = $row['username'];
    } else {
        // Redirect to error page if dish ID is invalid
        header('Location: error.php');
        exit();
    }
} else {
    // Redirect to error page if no dish ID is provided
    header('Location: error.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $dishName; ?> - Dish' Covery</title>
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
        .dish-info {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 20px;
        }
        .dish-name {
            margin: 0;
            margin-left: 20px;
        }
        .dish-image {
            max-width: 200px;
            overflow: hidden;
        }
        .dish-image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .ingredients ul {
            list-style-type: disc;
            padding-left: 20px;
        }
        .footer {
            border-top: 1px solid #ccc;
            padding-top: 10px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="dish-info">
        <div class="dish-image">
            <img src="<?php echo $image_path; ?>" alt="<?php echo $dishName; ?>">
        </div>
        <h2 class="dish-name"><?php echo $dishName; ?></h2>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <p><strong>Description:</strong> <?php echo $description; ?></p>
            <div class="ingredients">
                <p><strong>Ingredients:</strong></p>
                <ul>
                    <?php
                    $ingredientList = explode(", ", $ingredients);
                    foreach ($ingredientList as $ingredient) {
                        echo "<li>$ingredient</li>";
                    }
                    ?>
                </ul>
            </div>
            <p><strong>Cooking Time (mins):</strong> <?php echo $cookingTime; ?></p>
            <p><strong>Process:</strong> <?php echo $process; ?></p>
            <p><strong>Cuisine:</strong> <?php echo $cuisine; ?></p>
            <p><strong>Type:</strong> <?php echo $type; ?></p>
            <p><strong>Created By:</strong> <?php echo $created_by; ?></p>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
    </div>
    <div class="footer">
        <p>Dish by Dish' Covery</p>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
