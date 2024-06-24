<?php
session_start();
require_once 'database.php';

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();

     $email = $_POST['email'];
     $plain_password = $_POST['password'];
     $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
     $response = $_POST['response'];

     if($response=="option1")
        $responseValue=1;
    else
        $responseValue=2;

    if($responseValue==1)
        $query = "SELECT * FROM users WHERE email = :email";
    else
        $query = "SELECT * FROM companies WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);

    $stmt->execute();

   $user = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($user)
   {
      //user deja existent
      header("Location: http://localhost/ProjectTW/htmlFiles/signupAlreadyExists.html"); 
      exit();
   } 
  else 
  {
      if($responseValue==1)
        {
            $query_insert= "INSERT INTO users (email, password, option_value) VALUES (:email, :password, :response)";
            $stmt_insert = $pdo->prepare($query_insert);
            $stmt_insert->bindParam(':email', $email);
            $stmt_insert->bindParam(':password', $hashed_password);
            $stmt_insert->bindParam(':response', $responseValue);
            if ($stmt_insert->execute()) 
            {
                $_SESSION['email'] = $email;
                $_SESSION['response'] = $responseValue;
                header("Location: http://localhost/ProjectTW/htmlFiles/user.php"); 
                exit();
            } 
            else
                echo "Eroare la înregistrarea utilizatorului.";
        }
        else
        {
            $query_insert = "INSERT INTO companies (email, password, option_value) VALUES (:email, :password, :response)";
            $stmt_insert = $pdo->prepare($query_insert);
            $stmt_insert->bindParam(':email', $email);
            $stmt_insert->bindParam(':password', $hashed_password);
            $stmt_insert->bindParam(':response', $responseValue);
            if ($stmt_insert->execute()) {
                echo "Compania a fost înregistrat cu succes.";

                $_SESSION['email'] = $email;
                $_SESSION['response'] = $responseValue;
                 header("Location: http://localhost/ProjectTW/phpFiles/company.php");
                 exit();
            } 
            else
                echo "Eroare la înregistrarea utilizatorului.";
        }
  }


} catch (PDOException $e) 
{
    echo "Eroare la conectarea la baza de date: " . $e->getMessage();
}
?>
