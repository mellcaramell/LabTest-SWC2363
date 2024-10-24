<?php
// Database connection variables
$servername = "localhost";
$username = "root";  // Use the appropriate username for your setup
$password = "";      // Use the appropriate password for your setup
$dbname = "sales commission calculation";

// Create connection to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $month = $_POST['month'];
    $amount = $_POST['amount'];

    // Validate that sales amount is a number and is positive
    if (is_numeric($amount) && $amount > 0) {
        // Calculate commission based on sales amount
        if ($amount >= 1 && $amount <= 2000) {
            $commission = $amount * 0.03;
        } elseif ($amount >= 2001 && $amount <= 5000) {
            $commission = $amount * 0.04;
        } elseif ($amount >= 5001 && $amount <= 7000) {
            $commission = $amount * 0.07;
        } else {
            $commission = $amount * 0.10;
        }

        // Insert the data into the database
        $sql = "INSERT INTO sales_commission (name, month, sales_amount, commission)
                VALUES ('$name', '$month', $amount, $commission)";

        if ($conn->query($sql) === TRUE) {
            echo "Record saved successfully!<br>";
            echo "<h2>Sales Commission</h2>";
            echo "Name: " . htmlspecialchars($name) . "<br>";
            echo "Month: " . htmlspecialchars($month) . "<br>";
            echo "Sales Amount: RM " . number_format($amount, 2) . "<br>";
            echo "Sales Commission: RM " . number_format($commission, 2);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Please enter a valid sales amount.";
    }
}

// Close the database connection
$conn->close();
?>
