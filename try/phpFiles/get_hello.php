<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo "Eroare: Utilizatorul nu este autentificat.";
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

    $query = "SELECT username, email FROM users WHERE desired_service IS NOT NULL";
    $stmt = $pdo->prepare($query);

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows as associative arrays

    $rowCount = count($results); // Numărul de rânduri returnate

    if ($rowCount > 0) {        
        foreach ($results as $row) {
            echo "Name: " . $row['username'] . "<br>";
            echo "Email: " . $row['email'] . "<br>";
        }
        

    } else {
        echo "Nu s-a găsit nicio înregistrare care să îndeplinească criteriile specificate.";
    }

} catch (PDOException $e) {
    echo "Eroare la conectarea la baza de date: " . $e->getMessage();
}
?>


