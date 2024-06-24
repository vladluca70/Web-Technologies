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

    $sql = "SELECT STRING_AGG(received_offers, ',') AS concatenated_emails FROM users WHERE email = :email";


    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $_SESSION['email']);

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['concatenated_emails'] !== null) 
    {
        $concatenated_emails = $result['concatenated_emails'];
        $emails_array = explode(',', $concatenated_emails);

        echo '<form id="receivedOffersU" method="POST" action="http://localhost/ProjectTW/phpFiles/receivedOffersU2.php">';
            echo '<h2>Offers</h2>';

            foreach ($emails_array as $email) 
            {
                $sql_companies = "SELECT * FROM companies WHERE email = :email";
                $stmt_companies = $pdo->prepare($sql_companies);
                $stmt_companies->bindParam(':email', $email);
                $stmt_companies->execute();
                $companies = $stmt_companies->fetchAll(PDO::FETCH_ASSOC);

                foreach ($companies as $company) 
                {
                    echo '<div class="company-info">';
                    echo "Name: " . htmlspecialchars($company['companyname'], ENT_QUOTES, 'UTF-8') . "<br>";
                    echo "City: " . htmlspecialchars($company['city'], ENT_QUOTES, 'UTF-8') . "<br>";
                    echo "About us: " . htmlspecialchars($company['about_us'], ENT_QUOTES, 'UTF-8') . "<br>";
                    echo "Email: " . htmlspecialchars($company['email'], ENT_QUOTES, 'UTF-8') . "<br>";
                    echo "Phone: " . htmlspecialchars($company['phone'], ENT_QUOTES, 'UTF-8') . "<br>";
    
                    echo '<label class="company-label" for="' . htmlspecialchars($company['email'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($company['email'], ENT_QUOTES, 'UTF-8') . '</label>';
                    echo '<input class="company-checkbox" type="checkbox" id="' . htmlspecialchars($company['email'], ENT_QUOTES, 'UTF-8') . '" name="usernames[]" value="' . htmlspecialchars($company['email'], ENT_QUOTES, 'UTF-8') . '">';
                    echo '</div>';
                }
            }

        echo '<button type="submit">Send request</button>';
        echo '</form>';
    } 
    else 
    {
        echo "Nu s-au găsit adrese de email în baza de date.";
    }

    $stmt->closeCursor();
    $pdo = null;

} catch (PDOException $e) {
    echo "Eroare la conectarea la baza de date: " . $e->getMessage();
}
?>


