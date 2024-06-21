<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Verificăm dacă s-au trimis datele din formular
    if (isset($_POST['usernames']) && is_array($_POST['usernames'])) 
    {
        $selectedUsernames = $_POST['usernames'];

        echo '<h2>Selected Users</h2>';

        foreach ($selectedUsernames as $username) 
        {
            echo "Selected username: " . htmlspecialchars($username) . "<br>";
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
