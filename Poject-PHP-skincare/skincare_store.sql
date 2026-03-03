CREATE DATABASE skincare_store;
-- Eksporto të dhënat nga database e vjetër dhe importoji te skincare_store

CREATE DATABASE IF NOT EXISTS skincare_store CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE skincare_store;

-- Tabela e përdoruesve
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    role VARCHAR(20) NOT NULL DEFAULT 'user'
);

-- Tabela e produkteve skincare
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255)
);

-- Shembuj produktesh skincare
INSERT INTO products (name, description, price, image) VALUES
('Xhel Pastrues', 'Pastron butësisht lëkurën dhe largon papastërtitë.', 1200, 'images.jpg'),
('Krem Hidratues Ditor', 'Hidratim i lehtë për lëkurë të freskët gjatë gjithë ditës.', 1500, 'images.jpg'),
('Spray Mbrojtës SPF 50', 'Mbrojtje efektive nga rrezet e diellit, pa yndyrë.', 1800, 'images.jpg');