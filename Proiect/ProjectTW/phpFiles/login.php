<?php
session_start();
require_once 'database.php';

if (isset($_SESSION['email'])) {
    if ($_SESSION['response'] == 1) {
        header("Location: http://localhost/ProjectTW/phpFiles/user.php");
    } else {
        header("Location: http://localhost/ProjectTW/phpFiles/company.php");
    }
    exit();
}

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();
    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $plain_password = $_POST['password'];
        $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
        $response = $_POST['response'];

        if ($response == 'option1') 
            $responseValue = 1;
        else 
            $responseValue = 2;

           
        if ($responseValue == 1) {
            $query = "SELECT * FROM users WHERE email = :email";
        } else {
            $query = "SELECT * FROM companies WHERE email = :email";
        }
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);


        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $res_password = $result['password'];
            if (password_verify($plain_password, $res_password)) 
            {
                $_SESSION['email'] = $email;
                $_SESSION['response'] = $response;
                if ($responseValue == 1) 
                    header("Location: http://localhost/ProjectTW/phpFiles/user.php");
                else 
                    header("Location: http://localhost/ProjectTW/phpFiles/company.php");
                exit();
            } 
            else 
            {
                //parola incorecta
                header("Location: http://localhost/ProjectTW/htmlFiles/incorectCredentials.html");
            }
        } else 
        {
            header("Location: http://localhost/ProjectTW/htmlFiles/incorectCredentials.html");
        }
    }

} catch (PDOException $e) {
    echo "Eroare la conectarea la baza de date: " . $e->getMessage();
}

?>



