<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['email'])) {
    header("Location: http://localhost/try/phpFiles/login.php");
    exit();
}

try {
    // Conectare la baza de date PostgreSQL
    $db = Database::getInstance();
    $pdo = $db->getConnection();

    // Preluăm detaliile utilizatorului
    $query = "SELECT * FROM users WHERE email = :email";
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
    <link rel="stylesheet" href="http://localhost/try/cssFiles/user.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="">Profile</a></li>
                <li><a href="http://localhost/try/htmlFiles/modifyUserProfile.php">Modify Profile</a></li>
                <li><a href="http://localhost/try/htmlFiles/findServiceUser.html">Find a service</a></li>
                <li><a href="http://localhost/try/htmlFiles/receivedOffersU.html">Received offers</a></li>
                <li><a href="http://localhost/try/htmlFiles/acceptedOffersU.html">Accepted offers</a></li>
                <li><a href="http://localhost/try/phpFiles/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="user-info">
    <div class="user-data">
        <h2>User name</h2>
        <p class="username"><span class="value"><?php echo $result['username']; ?></span></p>
    </div>

    <div class="user-data">
        <h2>City</h2>
        <p class="city"><span class="value"><?php echo $result['city']; ?></span></p>
    </div>

    <div class="user-data">
        <h2>Contact</h2>
        <p class="contact"><span class="value"><?php echo $result['email']; ?></span></p>
    </div>
</section>
</body>
</html>


