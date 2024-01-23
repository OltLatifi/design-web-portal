<?php 

include "connection.php";

$create_user_table = "
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    role VARCHAR(255) NOT NULL,
    password VARCHAR(511) NOT NULL
)";

$create_article_table = "
CREATE TABLE article (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_id INT,
    FOREIGN KEY (author_id) REFERENCES user(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    published_at TIMESTAMP,
    status BOOLEAN NOT NULL
)";

$create_about_us_table = "
CREATE TABLE about_us (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT
);
";

$db->query($create_user_table);
$db->query($create_article_table);
$db->query($create_about_us_table);

$db->close();
?>