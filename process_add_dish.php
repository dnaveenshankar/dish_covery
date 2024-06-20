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

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $dishName = $_POST['dishName'];
    $description = $_POST['description'];
    $cookingTime = $_POST['cookingTime'];
    $process = $_POST['process'];
    $cuisine = $_POST['cuisine'];
    $type = $_POST['type'];
    $username = $_SESSION['username'];

    // Set default image path
    $image_path = "default.png";

    // Handle file upload if an image is selected
    if ($_FILES["image"]["size"] > 0) {
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // if everything is ok, try to upload file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $image_path = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Check if ingredients are submitted
    if (isset($_POST['ingredients']) && !empty($_POST['ingredients'])) {
        $ingredients = $_POST['ingredients'];

        // Process ingredients
        $ingredientString = implode(", ", $ingredients);
    } else {
        $ingredientString = ""; // Set to empty string if no ingredients are provided
    }

    // Insert data into the recipes table
    $stmt = $conn->prepare("INSERT INTO recipes (username, dishName, description, cookingTime, process, cuisine, type, ingredients, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $username, $dishName, $description, $cookingTime, $process, $cuisine, $type, $ingredientString, $image_path);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the same page with a success parameter
        header('Location: add_dish.php?success=1');
        exit();
    } else {
        // Handle error
        echo "Error: " . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
