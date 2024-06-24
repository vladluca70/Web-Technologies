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

    $desiredService=$_POST['desiredService'];
    $projectDescription=$_POST['projectDescription'];
    $estimatedPrice=$_POST['estimatedPrice'];
    $typeOfProperty=$_POST['typeOfProperty'];

    $query = "UPDATE users SET desired_service = :desiredService, project_description = :projectDescription, estimated_price = :estimatedPrice, type_of_property = :typeOfProperty WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':desiredService', $desiredService);
    $stmt->bindParam(':projectDescription', $projectDescription);
    $stmt->bindParam(':estimatedPrice', $estimatedPrice);
    $stmt->bindParam(':typeOfProperty', $typeOfProperty);
    $stmt->bindParam(':email', $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) 
    {
        header("Location: http://localhost/ProjectTW/htmlFiles/findServiceUserMessage.html"); 
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


