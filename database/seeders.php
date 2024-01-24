<?php

include "connection.php";

$users = [
    [
        "first_name" => "Olt",
        "last_name" => "Latifi",
        "email" => "oltlatifi2003@gmail.com",
        "username" => "OltLatifi",
        "role" => "ADMIN",
        "password" => "1234"
    ],
    [
        "first_name" => "Jon",
        "last_name" => "Fazliu",
        "email" => "jonfazliu@gmail.com",
        "username" => "joni",
        "role" => "ADMIN",
        "password" => "1234"
    ],
    [
        "first_name" => "Staff",
        "last_name" => "Member",
        "email" => "staff@gmail.com",
        "username" => "staff",
        "role" => "STAFF",
        "password" => "1234"
    ],
    [
        "first_name" => "User",
        "last_name" => ";)",
        "email" => "user@gmail.com",
        "username" => "User1",
        "role" => "USER",
        "password" => "1234"
    ],
];

$user_sql = "INSERT INTO user (first_name, last_name, email, username, role, password) VALUES (?, ?, ?, ?, ?, ?)";
foreach ($users as $user) {
    $params = [
        $user["first_name"],
        $user["last_name"],
        $user["email"],
        $user["username"],
        $user["role"],
        password_hash($user["password"], PASSWORD_DEFAULT),
    ];

    $stmt = $db->getConn()->prepare($user_sql);
    $stmt->bind_param("ssssss", ...$params);
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

$aboutus_sql = "
    INSERT INTO about_us (content)
    VALUES ('About us content')
";

$stmt = $db->query($aboutus_sql)
$db->close();

?>

