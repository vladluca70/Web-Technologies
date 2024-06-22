<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: http://localhost/try/phpFiles/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificăm dacă s-au trimis datele din formular
    if (isset($_POST['usernames']) && is_array($_POST['usernames'])) {
        // Detaliile de conectare la baza de date
        $host = 'localhost';
        $dbname = 'try';
        $user = 'postgres';
        $password = 'euro2024';

        try {
            // Creăm o conexiune PDO
            $dsn = "pgsql:host=$host;dbname=$dbname";
            $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

            $accepted_emails = implode(',', $_POST['usernames']);

            // Actualizăm coloana accepted_offers pentru utilizatorul curent
            $update_sql1 = "
                UPDATE users 
                SET accepted_offers = 
                    CASE 
                        WHEN accepted_offers IS NULL OR accepted_offers = '' THEN :accepted_emails 
                        ELSE accepted_offers || ',' || :accepted_emails 
                    END 
                WHERE email = :email";
            
            $stmt_update1 = $pdo->prepare($update_sql1);
            $stmt_update1->bindParam(':accepted_emails', $accepted_emails);
            $stmt_update1->bindParam(':email', $_SESSION['email']);
            $stmt_update1->execute();

            // Construim interogarea pentru a actualiza valorile în companies
            $placeholders = [];
            $myEmail = $_SESSION['email'];
            foreach ($_POST['usernames'] as $index => $email) {
                $placeholders[] = ':email' . $index;
            }

            $sql = "
                UPDATE companies 
                SET accepted_offers = 
                    CASE 
                        WHEN accepted_offers IS NULL OR accepted_offers = '' THEN :myEmail 
                        ELSE accepted_offers || ',' || :myEmail 
                    END 
                WHERE email IN (" . implode(',', $placeholders) . ")";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':myEmail', $myEmail);
            foreach ($_POST['usernames'] as $index => $email) {
                $stmt->bindParam(':email' . $index, $email);
            }

            $stmt->execute();

            // Executăm interogarea
            if ($stmt_update1 && $stmt) {
                echo "Users have been updated successfully.";
            } else {
                echo "Error updating users.";
            }

            $stmt_update1->closeCursor();
            $pdo = null;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "No users were selected.";
    }
} else {
    echo "Invalid request method.";
}

?>
