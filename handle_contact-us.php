<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "git";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$subject = $_POST['subject'];
$message = $_POST['message'];

$sql = "INSERT INTO contact_us (subject,message)
VALUES ( '$subject','$message' )";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>