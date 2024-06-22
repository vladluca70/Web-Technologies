<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: http://localhost/try/phpFiles/login.php");
    exit();
}

// Detalii de conexiune la baza de date
$host = 'localhost';
$dbname = 'try';
$user = 'postgres';
$password = 'euro2024';

try {
    // Conectare la baza de date PostgreSQL
    $dsn = "pgsql:host=$host;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Preluăm detaliile utilizatorului
    $query = "SELECT * FROM companies WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $user_data = $result;
    } else {
        echo "Eroare la preluarea datelor utilizatorului.";
        exit();
    }

} catch (PDOException $e) {
    echo "Eroare la conectarea la baza de date: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
</head>
<body style="background-color: green;">

    <a href="http://localhost/try/htmlFiles/user.php">Profile</a>
    <a href="http://localhost/try/htmlFiles/modifyCompanyProfile.php">Modify Profile</a>
    <a href="http://localhost/try/htmlFiles/offersForCompany.html">Offers</a>
    <a href="http://localhost/try/htmlFiles/acceptedOffersC.html">Accepted offers</a>
    <a href="http://localhost/try/phpFiles/logout.php">Logout</a>
    <br> <br>

    <h2>Company name</h2>
    <?php echo $result['companyname'];
        ?>

    <h2>City</h2>
    <?php echo $result['city'];
        ?>

    <h2>About us</h2>
    <?php echo $result['about_us'];
        ?>

    <h2>Contact</h2>
        <?php echo $result['email'];
        ?>
        <?php echo $result['phone'];
        ?>
</body>
</html>
