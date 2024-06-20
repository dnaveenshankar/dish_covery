<?php
session_start(); // Start the session

// Include your database connection file
include 'db_connection.php';

// Check if ingredients are provided
if(isset($_POST['ingredients']) && !empty($_POST['ingredients'])) {
    // Sanitize and process the ingredients input
    $ingredients = explode(",", $_POST['ingredients']);
    $ingredients = array_map('trim', $ingredients);

    // Prepare the SQL query to fetch relevant dishes
    $query = "SELECT * FROM recipes WHERE ";
    foreach($ingredients as $ingredient) {
        $query .= "ingredients LIKE '%$ingredient%' OR ";
    }
    $query = rtrim($query, "OR ");

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if any dishes are found
    if(mysqli_num_rows($result) > 0) {
        // Display suggested dishes
        while($row = mysqli_fetch_assoc($result)) {
            // Calculate match percentage
            $match_percentage = calculateMatchPercentage($ingredients, explode(",", $row['ingredients']));
            
            // Output HTML for suggested dish
            echo "<div class='card'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>".$row['dishName']."</h5>";
            echo "<p class='card-text'>".$row['description']."</p>";
            echo "<p class='card-text'>Match Percentage: ".$match_percentage."%</p>";
            // Redirect to view_dish.php with dish ID and username
            echo "<a href='view_dish.php?id=".$row['id']."&username=".$_SESSION['username']."' class='btn btn-primary'>View</a>";
            echo "</div></div>";
        }
    } else {
        // No dishes found
        echo "No dishes found with the provided ingredients.";
    }
} else {
    // No ingredients provided
    echo "Please provide ingredients to search for dishes.";
}

// Function to calculate match percentage
function calculateMatchPercentage($user_ingredients, $recipe_ingredients) {
    $matching_count = count(array_intersect($user_ingredients, $recipe_ingredients));
    $total_ingredients = count($user_ingredients);
    return round(($matching_count / $total_ingredients) * 100, 2);
}
?>
