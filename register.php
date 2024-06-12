<?php
include('db.php');
session_start();
//ak smo vec ulogirani redirect
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
//salji usera novog
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // provjeri sifre
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // ak vec postoji user sa tim imenom
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $error = "Username already exists!";
        } else {
            // hashaj sifru
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();

            $success = "Account created successfully! You can now <a href='login.php'>login</a>.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="validate.js"></script>
</head>
<body>
    <h1>Register</h1>
    <form method="POST" onsubmit="return validateRegister()">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <button type="submit">Register</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <?php if (isset($success)) echo "<p>$success</p>"; ?>
</body>
</html>