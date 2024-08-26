<?php
$servername = "localhost:49754"; // Change this if your server is different
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "register"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $password = $_POST['password'];

    // Check if the user exists
    $sql = "SELECT password FROM users WHERE name='$name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the stored password
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        // Verify the password
        if (password_verify($password, $storedPassword)) {
            // Start session and store the user's name
            session_start();
            $_SESSION['name'] = $name;

            // Redirect to Dashboard Home
            header("Location: home.html");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}

$conn->close();
?>
