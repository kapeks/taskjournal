-- Создание базы данных
CREATE DATABASE IF NOT EXISTS to_do_list;
USE to_do_list;

-- Создание таблицы users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_email_verified TINYINT(1) NOT NULL DEFAULT 0,
    verification_token VARCHAR(64) DEFAULT NULL
      CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
    password_reset_code VARCHAR(64) DEFAULT NULL
      CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
);
-- Создание таблицы tasks
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    text TEXT NOT NULL,
    completed TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,                          
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

