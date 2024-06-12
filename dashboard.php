<?php
include('db.php');
session_start();
//ak nije user loginan vrati ga na main page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
//fetchaj username iz baze
$stmt = $conn->prepare("SELECT username FROM users WHERE id = :user_id");
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch();
//salji novi article
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO news (title, content) VALUES (:title, :content)");
    //tu throwa neki random ass exception idk sta je 
    $sanitized_title = htmlspecialchars($title);
    $sanitized_content = htmlspecialchars($content);

    $stmt->bindParam(':title', $sanitized_title);
    $stmt->bindParam(':content', $sanitized_content);
    $stmt->execute();

    $message = "News sent successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="validate.js"></script>
</head>
<body>
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
    <h1>New article</h1>
     <p>Logged in as: <?php echo htmlspecialchars($user['username']); ?></p>
    <a href = "index.php"> Main page </a>
    <form method="POST" onsubmit="return validateNews()">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>
        <button type="submit">Send</button>
    </form>
    <!-- <?php if (isset($message)) echo "<p>$message</p>"; ?> -->
</body>
</html>