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

    // Construim interogarea SQL pentru PostgreSQL cu STRING_AGG
    $sql = "SELECT STRING_AGG(received_offers, ',') AS concatenated_emails FROM users WHERE email = :email";


    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $_SESSION['email']);

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the first row as associative array

    if ($result['concatenated_emails'] !== null) 
    {
        $concatenated_emails = $result['concatenated_emails'];
        $emails_array = explode(',', $concatenated_emails);

        echo '<form id="receivedOffersU" method="POST" action="http://localhost/try/phpFiles/receivedOffersU2.php">';
            echo '<h2>Offers</h2>';

            foreach ($emails_array as $email) 
            {
                // Query pentru a afișa informațiile din tabela companies pentru fiecare email
                $sql_companies = "SELECT * FROM companies WHERE email = :email";
                $stmt_companies = $pdo->prepare($sql_companies);
                $stmt_companies->bindParam(':email', $email);
                $stmt_companies->execute();
                $companies = $stmt_companies->fetchAll(PDO::FETCH_ASSOC);

                foreach ($companies as $company) 
                {
                    echo "Name: " .$company['companyname'] . "<br>";
                    echo "City: " .$company['city'] . "<br>";
                    echo "About us: " .$company['about_us'] . "<br>";
                    echo "Email: " .$company['email'] . "<br>";
                    echo "Phone: " .$company['phone'] . "<br>";

                    echo '<label for="' . $company['email'] . '">' . $company['email'] . '</label>';
                    echo '<input type="checkbox" id="' . $company['email'] . '" name="usernames[]" value="' . $company['email'] . '">';
                    echo '<br><br>';
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
