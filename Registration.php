<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];

    $conn = new mysqli('localhost', 'root', '', 'web_assignment');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO users (username, password, email, full_name) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $email, $full_name);

    if ($stmt->execute()) {
        header("Location: index.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

