<?php
// index.php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой сайт</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php"><i class="fas fa-rocket"></i> МойСайт</a>
            </div>
            <ul>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php"><i class="fas fa-user"></i> Профиль</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Выйти</a></li>
                <?php else: ?>
                    <li><a href="index.php"><i class="fas fa-home"></i> Главная</a></li>
                    <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Вход</a></li>
                    <li><a href="register.php"><i class="fas fa-user-plus"></i> Регистрация</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="hero">
            <h1>Добро пожаловать!</h1>
            <p>Современный сайт на PHP</p>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="welcome">
                    <h2>Вы вошли в систему!</h2>
                    <a href="logout.php" class="btn">Выйти</a>
                </div>
            <?php else: ?>
                <div class="actions">
                    <a href="register.php" class="btn btn-primary">Начать</a>
                    <a href="login.php" class="btn btn-secondary">Войти</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Мой сайт</p>
    </footer>
</body>
</html>