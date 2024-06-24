<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['email'])) {
    echo "eroare modify";
    exit();
}

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();

    $myName=$_POST['companyName'];
    $city=$_POST['city'];
    $aboutUs=$_POST['aboutUs'];
    $phone=$_POST['phone'];

    $query = "UPDATE companies SET companyname = :myName, city = :city,about_us = :aboutUs, phone = :phone WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':myName', $myName);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':aboutUs', $aboutUs);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) 
    {
        header("Location: http://localhost/ProjectTW/htmlFiles/modifyCmessage.html"); 
        exit();
    } 
    else 
    {
        echo "Nu s-a efectuat nicio modificare. Verificați datele introduse sau încercați din nou mai târziu.";
    }

} catch (PDOException $e) {
    echo "Eroare la conectarea la baza de date: " . $e->getMessage();
}

?>


