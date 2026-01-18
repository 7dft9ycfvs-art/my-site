<?php
// index.php - Стартовая страница
session_start();
include 'config.php';

// Если пользователь уже вошел - редирект на профиль
if(isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$registration_success = isset($_GET['registered']) ? true : false;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rohlya-test-site - Тестовый сайт с регистрацией</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            width: 100%;
            gap: 4rem;
        }
        
        .hero-text {
            flex: 1;
            color: white;
            animation: fadeInLeft 1s ease;
        }
        
        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .hero-text p {
            font-size: 1.3rem;
            opacity: 0.9;
            margin-bottom: 2.5rem;
            max-width: 600px;
        }
        
        .hero-features {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.1rem;
        }
        
        .feature-item i {
            color: #4ade80;
            font-size: 1.3rem;
        }
        
        .registration-box {
            flex: 0 0 400px;
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: fadeInRight 1s ease;
        }
        
        .registration-box h2 {
            color: #1f2937;
            margin-bottom: 2rem;
            text-align: center;
            font-size: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4b5563;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-register {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-top: 1rem;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
        }
        
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .success-message {
            background: #d1fae5;
            color: #065f46;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
            border-left: 4px solid #10b981;
        }
        
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .stats {
            display: flex;
            gap: 3rem;
            margin-top: 2rem;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            display: block;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        @media (max-width: 1024px) {
            .hero-content {
                flex-direction: column;
                gap: 3rem;
            }
            
            .registration-box {
                width: 100%;
                max-width: 500px;
            }
            
            .hero-text h1 {
                font-size: 2.8rem;
            }
        }
        
        @media (max-width: 768px) {
            .hero-text h1 {
                font-size: 2.2rem;
            }
            
            .registration-box {
                padding: 2rem;
            }
            
            .stats {
                flex-direction: column;
                gap: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="hero-content">
            <div class="hero-text">
                <h1>rohlya-test-site</h1>
                <p>Современная платформа для тестирования и разработки. Регистрируйтесь сейчас и получите доступ ко всем возможностям!</p>
                
                <div class="hero-features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Быстрая регистрация за 30 секунд</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Безопасное хранение данных</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-bolt"></i>
                        <span>Мгновенный доступ после регистрации</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Полная адаптивность для всех устройств</span>
                    </div>
                </div>
                
                <div class="stats">
                    <div class="stat-item">
                        <span class="stat-number">100+</span>
                        <span class="stat-label">Пользователей</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Работа сайта</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">99.9%</span>
                        <span class="stat-label">Доступность</span>
                    </div>
                </div>
            </div>
            
            <div class="registration-box">
                <h2><i class="fas fa-user-plus"></i> Создать аккаунт</h2>
                
                <?php if($registration_success): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> Регистрация успешна! Теперь вы можете войти.
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="process_register.php">
                    <div class="form-group">
                        <label for="username"><i class="fas fa-user"></i> Имя пользователя</label>
                        <input type="text" id="username" name="username" placeholder="Введите ваше имя" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email адрес</label>
                        <input type="email" id="email" name="email" placeholder="example@email.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> Пароль</label>
                        <input type="password" id="password" name="password" placeholder="Не менее 6 символов" required>
                    </div>
                    
                    <button type="submit" class="btn-register">
                        <i class="fas fa-rocket"></i> Начать бесплатно
                    </button>
                </form>
                
                <div class="login-link">
                    <p>Уже есть аккаунт? <a href="login.php"><i class="fas fa-sign-in-alt"></i> Войти в систему</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
