<?php
session_start();
include 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error = 'Введите email и пароль';
    } else {
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit();
        } else {
            $error = 'Неверный email или пароль';
        }
    }
}
?>
<?php include 'header.php'; ?>

<div class="container">
    <h2><i class="fas fa-sign-in-alt"></i> Вход в <?php echo SITE_NAME; ?></h2>
    
    <?php if($error): ?>
        <div class="error"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email:</label>
            <input type="email" id="email" name="email" placeholder="Ваш email" required>
        </div>
        
        <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Пароль:</label>
            <input type="password" id="password" name="password" placeholder="Ваш пароль" required>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-sign-in-alt"></i> Войти
        </button>
    </form>
    
    <div class="links">
        <p><a href="register.php"><i class="fas fa-user-plus"></i> Нет аккаунта? Зарегистрируйтесь</a></p>
        <p><a href="#"><i class="fas fa-key"></i> Забыли пароль?</a></p>
    </div>
</div>

<?php include 'footer.php'; ?>
