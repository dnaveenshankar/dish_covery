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

// Retrieve all feedback from the database
$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);

// Check if there is feedback available
if ($result->num_rows > 0) {
    // Feedback data is available, display it in a table
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Feedback List</title>
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

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            th {
                background-color: #f2f2f2;
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
        </style>
    </head>
    <body>
    <div class="container">
        <h2>Feedback List</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Rating</th>
                <th>Comment</th>
            </tr>
            <?php
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["username"]."</td><td>".$row["rating"]."</td><td>".$row["comment"]."</td></tr>";
            }
            ?>
        </table>
        <br>
        <button onclick="goBack()">Go Back</button>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </div>
    </body>
    </html>
    <?php
} else {
    echo "No feedback available.";
}

// Close database connection
$conn->close();
?>
