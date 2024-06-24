<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['email'])) {
    header("Location: http://localhost/ProjectTW/phpFiles/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    if (isset($_POST['usernames']) && is_array($_POST['usernames'])) 
    {
        try 
        {
            $db = Database::getInstance();
            $pdo = $db->getConnection();    

            $usernames = $_POST['usernames'];
            $placeholders = implode(',', array_fill(0, count($usernames), '?'));
            $sql = "UPDATE users SET received_offers = CASE 
                        WHEN received_offers IS NULL OR received_offers = '' THEN ?
                        WHEN position(? in received_offers) > 0 THEN received_offers
                        ELSE received_offers || ',' || ?
                    END 
                    WHERE username IN ($placeholders)";


            $stmt = $pdo->prepare($sql);
            
            $email = $_SESSION['email'];

            $params = array_merge([$email, $email, $email], $usernames);

            if ($stmt->execute($params)) 
            {
                echo "Users have been updated successfully.";
            } 
            else 
            {
                echo "Error updating users.";
            }
            $stmt->closeCursor();
            $pdo = null;

        } 
        catch (PDOException $e) 
        {
            echo "Error: " . $e->getMessage();
        }
    } 
    else 
    {
        echo "No users were selected.";
    }
} 
else 
{
    echo "Invalid request method.";
}
?>


