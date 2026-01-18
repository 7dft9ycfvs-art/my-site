<?php
include 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'Все поля обязательны для заполнения';
    } elseif ($password !== $confirm) {
        $error = 'Пароли не совпадают. Проверьте правильность ввода';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль должен содержать минимум 6 символов';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword]);
            $success = 'Регистрация успешно завершена! Теперь вы можете войти в систему.';
        } catch(PDOException $e) {
            $error = 'Ошибка: ' . (strpos($e->getMessage(), 'UNIQUE') ? 
                     'Пользователь с таким email или именем уже существует' : 
                     'Ошибка базы данных. Попробуйте позже.');
        }
    }
}
?>
<?php include 'header.php'; ?>

<div class="container">
    <h2><i class="fas fa-user-plus"></i> Регистрация на <?php echo SITE_NAME; ?></h2>
    
    <?php if($error): ?>
        <div class="error"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if($success): ?>
        <div class="success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label for="username"><i class="fas fa-user"></i> Имя пользователя:</label>
            <input type="text" id="username" name="username" placeholder="Введите ваше имя" required>
        </div>
        
        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email адрес:</label>
            <input type="email" id="email" name="email" placeholder="example@email.com" required>
        </div>
        
        <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Пароль:</label>
            <input type="password" id="password" name="password" placeholder="Не менее 6 символов" required>
        </div>
        
        <div class="form-group">
            <label for="confirm_password"><i class="fas fa-lock"></i> Подтвердите пароль:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Повторите пароль" required>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Создать аккаунт
        </button>
    </form>
    
    <div class="login-link">
        <p>Уже есть аккаунт? <a href="login.php"><i class="fas fa-sign-in-alt"></i> Войти в систему</a></p>
    </div>
</div>

<?php include 'footer.php'; ?>
