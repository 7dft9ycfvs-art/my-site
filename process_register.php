<?php
// process_register.php - обработка регистрации со стартовой страницы
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Простая валидация
    if (empty($username) || empty($email) || empty($password)) {
        header('Location: index.php?error=empty_fields');
        exit();
    }
    
    if (strlen($password) < 6) {
        header('Location: index.php?error=short_password');
        exit();
    }
    
    // Проверка email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.php?error=invalid_email');
        exit();
    }
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);
        
        // Автоматический вход после регистрации
        $userId = $pdo->lastInsertId();
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        
        // Редирект на панель управления
        header('Location: dashboard.php');
        exit();
        
    } catch(PDOException $e) {
        if (strpos($e->getMessage(), 'UNIQUE') !== false) {
            header('Location: index.php?error=user_exists');
        } else {
            header('Location: index.php?error=database_error');
        }
        exit();
    }
} else {
    // Если не POST запрос - на главную
    header('Location: index.php');
    exit();
}
?>
