<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo "eroare modify";
    exit();
}

// Detalii de conexiune la baza de date
$host = 'localhost';
$dbname = 'try';
$user = 'postgres';
$password = 'euro2024';

try {
    // Conectare la baza de date PostgreSQL
    $dsn = "pgsql:host=$host;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Preluăm detaliile utilizatorului
    $desiredService=$_POST['desiredService'];
    $projectDescription=$_POST['projectDescription'];
    $estimatedPrice=$_POST['estimatedPrice'];
    $typeOfProperty=$_POST['typeOfProperty'];
    //$email=$_POST['email'];

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
        echo "Modificare efectuată cu succes pentru utilizatorul cu adresa de email: " . $_SESSION['email'];
    } 
    else 
    {
        echo "Nu s-a efectuat nicio modificare. Verificați datele introduse sau încercați din nou mai târziu.";
    }

} catch (PDOException $e) {
    echo "Eroare la conectarea la baza de date: " . $e->getMessage();
}

?>


