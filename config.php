<?php
session_start();

// Автоматическое определение среды
if (getenv('RENDER') || getenv('APP_ENV') === 'production') {
    // Production на Render.com
    $use_sqlite = true;
    $databaseFile = '/var/www/html/data/database.db';
} else {
    // Локальная разработка
    $use_sqlite = true;
    $databaseFile = 'database.db';
}

// SQLite подключение
try {
    $pdo = new PDO("sqlite:$databaseFile");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("PRAGMA journal_mode=WAL");
    
    // Создаем таблицу если не существует
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        email TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    
} catch(PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

// Базовые настройки
define('SITE_NAME', 'Мой Сайт');
define('SITE_URL', isset($_SERVER['HTTPS']) ? 'https://' : 'http://' . $_SERVER['HTTP_HOST']);

// Функция для отладки
function debug($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}
