<?php
session_start();
// Detaliile de conexiune la baza de date
$host = 'localhost'; 
$dbname = 'try';
$user = 'postgres';
$password = 'euro2024';

try {
    // Conectare la baza de date PostgreSQL
    $dsn = "pgsql:host=$host;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Preluarea datelor din formular (decomentează și folosește dacă este necesar)
     $email = $_POST['email'];
     $plain_password = $_POST['password'];
     $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
     $response = $_POST['response'];

     if($response=="option1")
        $responseValue=1;
    else
        $responseValue=2;

    // Selectarea datelor din baza de date folosind declarații pregătite
    if($responseValue==1)
        $query = "SELECT * FROM users WHERE email = :email";
    else
        $query = "SELECT * FROM companies WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    #$stmt->bindParam(':password', $hashed_password);

    // Executarea interogării
    $stmt->execute();

   $user = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($user)
   {
      // Utilizatorul există, verificăm parola
      echo "utilizator deja existent";
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
                header("Location: http://localhost/try/htmlFiles/user.php"); 
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
                // Redirecționare către pagina user.html după inserare reușită
                $_SESSION['email'] = $email;
                $_SESSION['response'] = $responseValue;
                 header("Location: http://localhost/try/htmlFiles/company.php");
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


<?php
    $_SESSION = array();
    session_destroy();
?>