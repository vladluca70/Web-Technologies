<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['email'])) {
    echo "Eroare: Utilizatorul nu este autentificat.";
    exit();
}

$host = 'localhost';
$dbname = 'try';
$user = 'postgres';
$password = 'euro2024';

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();

    $myEmail = $_SESSION['email'];
    $query = "SELECT accepted_offers FROM companies WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $myEmail);

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); 

    if ($result && isset($result['accepted_offers'])) {
        $emails = explode(',', $result['accepted_offers']);
        
        echo '<form id="acceptedOffers" method="POST" action="http://localhost/ProjectTW/phpFiles/handle_accepted_offers.php">';
        echo '<h2>Accepted Offers</h2>';

        foreach ($emails as $email) {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                echo '<div class="user-info">';
                echo "Name: " . htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') . "<br>";
                echo "City: " . htmlspecialchars($user['city'], ENT_QUOTES, 'UTF-8') . "<br>";
                echo "Desired service: " . htmlspecialchars($user['desired_service'], ENT_QUOTES, 'UTF-8') . "<br>";
                echo "Project description: " . htmlspecialchars($user['project_description'], ENT_QUOTES, 'UTF-8') . "<br>";
                echo "Type of property: " . htmlspecialchars($user['type_of_property'], ENT_QUOTES, 'UTF-8') . "<br>";
                echo "Estimated price: " . htmlspecialchars($user['estimated_price'], ENT_QUOTES, 'UTF-8') . "<br>";
                echo "Email: " . htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') . "<br>";
                echo "Phone: " . htmlspecialchars($user['phone'], ENT_QUOTES, 'UTF-8') . "<br>";
                echo '</div>';
            } 
            else
            {
                echo '<div class="error-message">Nu s-a găsit nicio companie pentru emailul: ' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '</div>';
            }
        }
        echo '</form>';
    } else {
        echo '<div class="error-message">Nu s-a găsit nicio înregistrare care să îndeplinească criteriile specificate.</div>';
    }

} catch (PDOException $e) {
    echo '<div class="error-message">Eroare la conectarea la baza de date: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</div>';
}
?>
