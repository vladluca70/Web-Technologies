<?php
session_start();
require_once 'database.php';

// Verificăm dacă utilizatorul este deja autentificat și sesiunea este setată
if (isset($_SESSION['email'])) {
    if ($_SESSION['response'] == 1) {
        header("Location: http://localhost/try/phpFiles/user.php");
    } else {
        header("Location: http://localhost/try/phpFiles/company.php");
    }
    exit();
}

try {
    // Conectare la baza de date PostgreSQL
    $db = Database::getInstance();
    $pdo = $db->getConnection();
    
    // Preluarea datelor din formular (dacă este trimis)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $plain_password = $_POST['password'];
        $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
        $response = $_POST['response'];

        if ($response == 'option1') 
            $responseValue = 1;
        else 
            $responseValue = 2;

           
        // Selectarea datelor din baza de date folosind declarații pregătite
        if ($responseValue == 1) {
            $query = "SELECT * FROM users WHERE email = :email";
        } else {
            $query = "SELECT * FROM companies WHERE email = :email";
        }
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);

        // Executarea interogării
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Utilizatorul există, verificăm parola
            $res_password = $result['password'];
            if (password_verify($plain_password, $res_password)) 
            {
                // Parola este corectă, autentificare reușită
                $_SESSION['email'] = $email;
                $_SESSION['response'] = $response;
                if ($responseValue == 1) 
                    header("Location: http://localhost/try/phpFiles/user.php");
                else 
                    header("Location: http://localhost/try/phpFiles/company.php");
                exit();
            } else {
                // Parola nu este corectă
                echo "Parola introdusă nu este corectă.";
            }
        } else {
            // Utilizatorul nu există în baza de date
            echo "Nu există un cont asociat cu adresa de email introdusă.";
        }
    }

} catch (PDOException $e) {
    echo "Eroare la conectarea la baza de date: " . $e->getMessage();
}

?>



