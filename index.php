<?php
session_start();
$pageTitle = 'Главная страница';
include 'header.php';
?>

<div class="hero">
    <h1>Добро пожаловать на наш сайт!</h1>
    <p>Здесь вы можете зарегистрироваться и получить доступ ко всем возможностям</p>
    
    <?php if(isset($_SESSION['user_id'])): ?>
        <div class="welcome">
            <h2>Привет, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p>Вы успешно вошли в систему.</p>
            <a href="logout.php" class="btn btn-primary">Выйти</a>
        </div>
    <?php else: ?>
        <div class="auth-buttons">
            <a href="login.php" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i> Войти
            </a>
            <a href="register.php" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Зарегистрироваться
            </a>
        </div>
    <?php endif; ?>
</div>

<div class="features">
    <div class="feature">
        <i class="fas fa-shield-alt fa-3x"></i>
        <h3>Безопасность</h3>
        <p>Надежное хранение ваших данных</p>
    </div>
    <div class="feature">
        <i class="fas fa-bolt fa-3x"></i>
        <h3>Быстро</h3>
        <p>Мгновенная регистрация и вход</p>
    </div>
    <div class="feature">
        <i class="fas fa-mobile-alt fa-3x"></i>
        <h3>Доступно</h3>
        <p>Адаптивный дизайн для всех устройств</p>
    </div>
</div>

<?php include 'footer.php'; ?>