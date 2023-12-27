<?php

include "connection.php";

$users = [
    [
        "first_name" => "Olt",
        "last_name" => "Latifi",
        "email" => "oltlatifi2003@gmail.com",
        "role" => "ADMIN",
        "password" => "1234"
    ],
    [
        "first_name" => "Jon",
        "last_name" => "Fazliu",
        "email" => "jonfazliu@gmail.com",
        "role" => "ADMIN",
        "password" => "1234"
    ],
    [
        "first_name" => "Staff",
        "last_name" => "Member",
        "email" => "staff@gmail.com",
        "role" => "STAFF",
        "password" => "1234"
    ],
    [
        "first_name" => "User",
        "last_name" => ";)",
        "email" => "user@gmail.com",
        "role" => "USER",
        "password" => "1234"
    ],
];

$user_sql = "INSERT INTO user (first_name, last_name, email, role, password) VALUES (?, ?, ?, ?, ?)";
foreach ($users as $user) {
    $params = [
        $user["first_name"],
        $user["last_name"],
        $user["email"],
        $user["role"],
        $user["password"]
    ];

    $stmt = $db->getConn()->prepare($user_sql);
    $stmt->bind_param("sssss", ...$params);
    $stmt->execute();
    $stmt->close();
}

$articles = [
    [
        "author_id" => 3, // change based on the user
        "title" => "Article 1",
        "image" => "image1.jpg",
        "content" => "Content of Article 1",
        "status" => true,
    ],
    [
        "author_id" => 3, // change based on the user
        "title" => "Article 2",
        "image" => "image2.jpg",
        "content" => "Content of Article 2",
        "status" => true,
    ],
];

$article_sql = "
    INSERT INTO article (author_id, title, image, content, published_at, status)
    VALUES (?, ?, ?, ?, ?, ?)
";

foreach ($articles as $articleData) {
    $published_at = date('Y-m-d H:i:s');
    $params = [
        $articleData["author_id"],
        $articleData["title"],
        $articleData["image"],
        $articleData["content"],
        $published_at,
        $articleData["status"],
    ];

    $stmt = $db->getConn()->prepare($article_sql);
    $stmt->bind_param("issssi", ...$params);
    $stmt->execute();
    $stmt->close();
}

$db->close();

?>

