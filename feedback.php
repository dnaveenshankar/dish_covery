<?php
// Database connection configuration
include 'db_connection.php';
session_start();

// Check if the username is set in the session
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // If the username is not set, handle the situation accordingly
    $username = "Guest"; // Or display an error message
}
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all fields are filled
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if all fields are filled
        if (!empty($_POST['username']) && !empty($_POST['rating']) && !empty($_POST['comment'])) {
            // Prepare and bind SQL statement to insert data into the database
            $stmt = $conn->prepare("INSERT INTO feedback (username, rating, comment) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $username, $rating, $comment);
    
            // Set parameters and execute the statement
            $username = $_POST['username'];
            $rating = $_POST['rating'];
            $comment = $_POST['comment'];
            $stmt->execute();
    
            // Close statement
            $stmt->close();
    
            // Redirect to dashboard.php after successful submission
            echo '<script>alert("Feedback submitted");</script>';
            echo '<script>window.location.href = "dashboard.php";</script>';
            exit();
        } else {
            // If fields are not filled, display an error message
            echo "Please fill in all fields.";
        }
    }
}

// Close database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Page</title>
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
            overflow: auto;
            max-height: 100vh;
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

        .rating {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .rating input[type="radio"] {
            display: none;
        }

        .rating label {
            font-size: 30px;
            cursor: pointer;
            transition: transform 0.3s ease;
            padding: 5px;
            margin: 0 5px;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
        }

        .rating label:hover {
            background-color: #0056b3;
        }

        .rating input[type="radio"]:checked + label {
            transform: scale(1.2);
            background-color: #0056b3;
        }

        textarea, input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .feedback-item {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .feedback-item p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="dashboard-title">
        <h2>Welcome to the Feedback Page</h2>
        <p>Please provide your feedback below:</p>
    </div>
    <form id="feedbackForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="username">Your Name:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" readonly>
        
        <label for="ratings">Ratings:</label>
        <div class="rating">
            <input type="radio" id="emoji1" name="rating" value="1">
            <label for="emoji1">😡</label>

            <input type="radio" id="emoji2" name="rating" value="2">
            <label for="emoji2">😕</label>

            <input type="radio" id="emoji3" name="rating" value="3">
            <label for="emoji3">😐</label>

            <input type="radio" id="emoji4" name="rating" value="4">
            <label for="emoji4">😊</label>

            <input type="radio" id="emoji5" name="rating" value="5">
            <label for="emoji5">😍</label>
        </div>
        
        <label for="comment">Comments:</label>
        <textarea id="comment" name="comment" placeholder="Enter your comment"></textarea>
        
        <button type="submit">Submit</button>
    </form>
    <div id="feedbackList">
        <?php
        // Display feedback from the database here if needed
        ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const feedbackForm = document.getElementById('feedbackForm');

        feedbackForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const username = document.getElementById('username').value;
            const rating = document.querySelector('input[name="rating"]:checked');
            const comment = document.getElementById('comment').value;

            if (username && rating && comment) {
                // Submit the form
                this.submit();
            } else {
                alert('Please fill in all fields.');
            }
        });
    });
</script>
</body>
</html>
