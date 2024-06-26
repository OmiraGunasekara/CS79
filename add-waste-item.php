<?php

session_start();

require __DIR__ . '/app/dbConnection.php';

if (!isset($_SESSION["email"])) {
    http_response_code(403);
    header('Location: loginPage.html');
    exit;
}

$price = 0;

$email = $_SESSION["email"];

$stmt = $pdo->prepare("SELECT id FROM sellers WHERE email = :email");
$stmt->execute(['email' => $email]);
$seller_id = $stmt->fetchColumn();

if (!$seller_id) {
    die("Error: Seller not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $weight = filter_input(INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
    $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL);

    $sql = "INSERT INTO waste (name, weight, price, image, category, seller_id, is_donation) VALUES (:name, :weight, :price, :image, :category, :seller_id, :is_donation)";

    $stmt = $pdo->prepare($sql);

    $donationStatus = false;

    if (
        $stmt->execute([
            ':name' => $name,
            ':weight' => $weight,
            ':price' => $price,
            ':image' => $image,
            ':category' => $category,
            ':seller_id' => $seller_id,
            ':is_donation' => $donationStatus,
        ])
    ) {
        header("location: seller-home-page-waste.php");
    } else {
        echo "Error: Could not add item.";
    }
} else {
    http_response_code(405);
    echo "Error: Invalid request method.";
}
