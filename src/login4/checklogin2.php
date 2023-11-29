<?php
// Database connection details
$servername = "192.168.5.133";
$usernamedb = "pkkwanvat";
$passworddb = "952634aa";
$dbname = "cart";

// Create a PDO connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $usernamedb, $passworddb);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Prepare a SQL statement using prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM ward_login WHERE wl_uname = :username AND wl_password = MD5(:password)");

        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        // Execute the statement
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a matching user was found
        if ($result) {
            echo json_encode("Success");
        } else {
			echo json_encode("Error");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Close the database connection
$conn = null;
?>
