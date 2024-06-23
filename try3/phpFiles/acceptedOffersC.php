<?php
session_start();
require_once 'database.php';

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
    $db = Database::getInstance();
    $pdo = $db->getConnection();

    $myEmail = $_SESSION['email'];
    $query = "SELECT accepted_offers FROM companies WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $myEmail);

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the single row as associative array

    if ($result && isset($result['accepted_offers'])) {
        $emails = explode(',', $result['accepted_offers']);
        
        echo '<form id="acceptedOffers" method="POST" action="http://localhost/try/phpFiles/handle_accepted_offers.php">';
        echo '<h2>Accepted Offers</h2>';

        foreach ($emails as $email) {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                echo '<div class="user-info">';
                echo "Name: " . $user['username'] . "<br>";
                echo "City: " . $user['city'] . "<br>";
                echo "Desired service: " . $user['desired_service'] . "<br>";
                echo "Project description: " . $user['project_description'] . "<br>";
                echo "Type of property: " . $user['type_of_property'] . "<br>";
                echo "Estimated price: " . $user['estimated_price'] . "<br>";
                echo "Email: " . $user['email'] . "<br>";
                echo "Phone: " . $user['phone'] . "<br>";
                echo '</div>';
            } else {
                echo '<div class="error-message">Nu s-a găsit nicio companie pentru emailul: ' . $email . '</div>';
            }
        }
        echo '</form>';
    } else {
        echo '<div class="error-message">Nu s-a găsit nicio înregistrare care să îndeplinească criteriile specificate.</div>';
    }

} catch (PDOException $e) {
    echo '<div class="error-message">Eroare la conectarea la baza de date: ' . $e->getMessage() . '</div>';
}
?>
