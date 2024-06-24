<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['email'])) {
    echo "Eroare: Utilizatorul nu este autentificat.";
    exit();
}

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();

    $query = "SELECT * FROM users WHERE desired_service IS NOT NULL";
    $stmt = $pdo->prepare($query);

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $rowCount = count($results); 

    if ($rowCount > 0) 
    {
        echo '<form id="findServiceUser" method="POST" action="http://localhost/ProjectTW/phpFiles/get_hello2.php">';
        echo '<h2>Offers</h2>';

        foreach ($results as $row) 
        {
            echo '<div class="user-info">';
            echo "Name: " . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . "<br>";
            echo "City: " . htmlspecialchars($row['city'], ENT_QUOTES, 'UTF-8') . "<br>";
            echo "Desired price: " . htmlspecialchars($row['desired_service'], ENT_QUOTES, 'UTF-8') . "<br>";
            echo "Project description: " . htmlspecialchars($row['project_description'], ENT_QUOTES, 'UTF-8') . "<br>";
            echo "Type of property: " . htmlspecialchars($row['type_of_property'], ENT_QUOTES, 'UTF-8') . "<br>";
            echo "Estimated price: " . htmlspecialchars($row['estimated_price'], ENT_QUOTES, 'UTF-8') . "<br>";
            echo "Email: " . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . "<br>";
            echo "Phone: " . htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8') . "<br>";

            echo '<label for="' . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . '</label>';
            echo '<input type="checkbox" id="' . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . '" name="usernames[]" value="' . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . '">';
            echo '</div>';
        }

        echo '<button type="submit">Send request</button>';
        echo '</form>';
    } 
    else 
    {
        echo "Nu s-a găsit nicio înregistrare care să îndeplinească criteriile specificate.";
    }

} 
catch (PDOException $e) 
{
    echo "Eroare la conectarea la baza de date: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
?>


