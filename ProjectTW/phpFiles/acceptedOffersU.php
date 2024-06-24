<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['email'])) {
    echo "<div class='error-message'>Eroare: Utilizatorul nu este autentificat.</div>";
    exit();
}

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();

    $sql = "SELECT STRING_AGG(received_offers, ',') AS concatenated_emails FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['concatenated_emails'] !== null) {
        $concatenated_emails = $result['concatenated_emails'];
        $emails_array = explode(',', $concatenated_emails);

        echo '<form id="receivedOffersU" method="POST" action="http://localhost/ProjectTW/phpFiles/receivedOffersU2.php">';
        echo '<h2>Oferte acceptate</h2>';

        foreach ($emails_array as $email) {
            $sql_companies = "SELECT * FROM companies WHERE email = :email";
            $stmt_companies = $pdo->prepare($sql_companies);
            $stmt_companies->bindParam(':email', $email);
            $stmt_companies->execute();
            $companies = $stmt_companies->fetchAll(PDO::FETCH_ASSOC);

            foreach ($companies as $company) {
                echo '<div class="company-info">';
                echo '<h3>' . htmlspecialchars($company['companyname'], ENT_QUOTES, 'UTF-8') . '</h3>';
                echo '<p><strong>City:</strong> ' . htmlspecialchars($company['city'], ENT_QUOTES, 'UTF-8') . '</p>';
                echo '<p><strong>About us:</strong> ' . htmlspecialchars($company['about_us'], ENT_QUOTES, 'UTF-8') . '</p>';
                echo '<p><strong>Email:</strong> ' . htmlspecialchars($company['email'], ENT_QUOTES, 'UTF-8') . '</p>';
                echo '<p><strong>Phone:</strong> ' . htmlspecialchars($company['phone'], ENT_QUOTES, 'UTF-8') . '</p>';
                echo '</div>';
            }
        }
        
        echo '</form>';
    } else {
        echo "<div class='error-message'>Nu s-au găsit adrese de email în baza de date.</div>";
    }

    $stmt->closeCursor();
    $pdo = null;

} catch (PDOException $e) 
{
    echo "<div class='error-message'>Eroare la conectarea la baza de date: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</div>";
}
?>
