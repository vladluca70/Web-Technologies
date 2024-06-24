<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['email'])) {
    header("Location: http://localhost/ProjectTW/phpFiles/login.php");
    exit();
}

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();

    $query = "SELECT * FROM companies WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $user_data = $result;
    } else {
        echo "Eroare la preluarea datelor utilizatorului.";
        exit();
    }

} catch (PDOException $e) {
    echo "Eroare la conectarea la baza de date: " . $e->getMessage();
}

include 'companyProfile.php';
?>


