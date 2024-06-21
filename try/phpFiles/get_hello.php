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

    $query = "SELECT * FROM users WHERE desired_service IS NOT NULL";
    $stmt = $pdo->prepare($query);

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows as associative arrays

    $rowCount = count($results); // Numărul de rânduri returnate

    if ($rowCount > 0) 
    {

        echo '<form id="findServiceUser" method="POST" action="http://localhost/try/phpFiles/get_hello2.php">';
        echo '<h2>Offers</h2>';

        foreach ($results as $row) 
        {
            echo "Name: " .$row['username'] . "<br>";
            echo "City: " .$row['city'] . "<br>";
            echo "Desired price: " .$row['desired_service'] . "<br>";
            echo "Project description: " .$row['project_description'] . "<br>";
            echo "Type of property: " .$row['type_of_property'] . "<br>";
            echo "Estimated price: " .$row['estimated_price'] . "<br>";
            echo "Email: " .$row['email'] . "<br>";
            echo "Phone: " .$row['phone'] . "<br>";


            echo '<label for="' . $row['username'] . '">' . $row['username'] . '</label>';
            echo '<input type="checkbox" id="' . $row['username'] . '" name="usernames[]" value="' . $row['username'] . '">';
            echo '<br><br>';


        }

        echo '<button type="submit">Send request</button>';
        echo '</form>';
    } 
    else 
    {
        echo "Nu s-a găsit nicio înregistrare care să îndeplinească criteriile specificate.";
    }

} catch (PDOException $e) {
    echo "Eroare la conectarea la baza de date: " . $e->getMessage();
}
?>
