<?php
// dashboard.php - Личный кабинет
session_start();
include 'config.php';

// Проверка авторизации
if(!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Получаем данные пользователя
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет - rohlya-test-site</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .dashboard-header {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            text-align: center;
        }
        
        .welcome-title {
            font-size: 2.5rem;
            color: #1f2937;
            margin-bottom: 1rem;
        }
        
        .user-email {
            color: #6b7280;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .dashboard-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        
        .card-icon {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 1rem;
        }
        
        .card-title {
            font-size: 1.3rem;
            color: #1f2937;
            margin-bottom: 1rem;
        }
        
        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            margin-top: 2rem;
        }
        
        .user-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 2rem;
        }
        
        .stat-box {
            text-align: center;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 10px;
            min-width: 150px;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #667eea;
            display: block;
        }
        
        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="welcome-title">
                <i class="fas fa-user-circle"></i> Добро пожаловать, <?php echo htmlspecialchars($user['username']); ?>!
            </div>
            <div class="user-email">
                <?php echo htmlspecialchars($user['email']); ?>
            </div>
            <p>Вы успешно вошли в систему rohlya-test-site</p>
            
            <div class="user-stats">
                <div class="stat-box">
                    <span class="stat-value">1</span>
                    <span class="stat-label">Аккаунт</span>
                </div>
                <div class="stat-box">
                    <span class="stat-value"><?php echo date('d.m.Y', strtotime($user['created_at'])); ?></span>
                    <span class="stat-label">Дата регистрации</span>
                </div>
            </div>
            
            <a href="logout.php" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Выйти из системы
            </a>
        </div>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <h3 class="card-title">Редактировать профиль</h3>
                <p>Обновите ваши личные данные и настройки аккаунта</p>
            </div>
            
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="card-title">Безопасность</h3>
                <p>Измените пароль и настройте двухфакторную аутентификацию</p>
            </div>
            
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <h3 class="card-title">Настройки</h3>
                <p>Настройте уведомления и параметры системы под себя</p>
            </div>
            
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h3 class="card-title">Помощь</h3>
                <p>Нужна помощь? Обратитесь в нашу службу поддержки</p>
            </div>
        </div>
    </div>
</body>
</html>
