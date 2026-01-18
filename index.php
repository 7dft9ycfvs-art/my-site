<?php
// index.php
session_start();
include 'config.php';
?>
<?php include 'header.php'; ?>

<div class="hero">
    <h1>Добро пожаловать на <?php echo SITE_NAME; ?>!</h1>
    <p>Современный тестовый сайт с регистрацией пользователей</p>
    
    <?php if(isset($_SESSION['user_id'])): ?>
        <div class="welcome">
            <h2>Вы успешно вошли в систему!</h2>
            <p>Используйте меню для навигации</p>
            <a href="logout.php" class="btn">Выйти из системы</a>
        </div>
    <?php else: ?>
        <div class="actions">
            <a href="register.php" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Зарегистрироваться
            </a>
            <a href="login.php" class="btn btn-secondary">
                <i class="fas fa-sign-in-alt"></i> Войти в систему
            </a>
        </div>
        
        <div class="features">
            <div class="feature">
                <i class="fas fa-bolt"></i>
                <h3>Быстро</h3>
                <p>Мгновенная регистрация</p>
            </div>
            <div class="feature">
                <i class="fas fa-shield-alt"></i>
                <h3>Безопасно</h3>
                <p>Защита паролей</p>
            </div>
            <div class="feature">
                <i class="fas fa-mobile-alt"></i>
                <h3>Адаптивно</h3>
                <p>Для всех устройств</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
