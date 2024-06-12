<?php
include('db.php');
session_start();
//fetchaj username
$stmt = $conn->prepare("SELECT username FROM users WHERE id = :user_id");
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch();
//dohvati sve article iz baze
$stmt = $conn->prepare("SELECT * FROM news ORDER BY created_at DESC");
$stmt->execute();
$news = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Newsletter</title>
    <style>
        <?php include 'styles.css'; ?>
    </style>
</head>
<body>
    <h1>Latest News</h1>
    <a href="login.php">Login</a> | <a href="register.php">Register</a> | <a href = "dashboard.php">Add article</a>
    <p>Logged in as: 
    <?php 
    	error_reporting(E_ERROR | E_PARSE);
    	echo htmlspecialchars($user['username']);
	?></p>
    <?php foreach ($news as $item): ?>
    	<div class="news-article">
    		<div>
		        <h2 class="news-heading"><?php echo htmlspecialchars($item['title']); ?></h2>
		        <p class="news-content"><?php echo nl2br(htmlspecialchars($item['content'])); ?></p>
		        <small class="news-date">Published on <?php echo $item['created_at']; ?></small>
    		</div>
    	</div>
    <?php endforeach; ?>
</body>
</html>