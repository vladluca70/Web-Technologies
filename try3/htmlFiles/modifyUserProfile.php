<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Profile</title>
    <link rel="stylesheet" href="http://localhost/try/cssFiles/modifyUserProfile.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="http://localhost/try/phpFiles/user.php">Profile</a></li>
                <li><a href="">Modify Profile</a></li>
                <li><a href="http://localhost/try/htmlFiles/findServiceUser.html">Find a service</a></li>
                <li><a href="http://localhost/try/htmlFiles/receivedOffersU.html">Received offers</a></li>
                <li><a href="http://localhost/try/htmlFiles/acceptedOffersU.html">Accepted offers</a></li>
                <li><a href="http://localhost/try/phpFiles/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="modify-profile">
        <form id="modify" method="POST" action="http://localhost/try/phpFiles/modifyU.php">
            <h2>Modify Profile</h2>
            
            <label for="myName">My name</label>
            <input type="text" id="myName" name="myName" required>
            <br><br> 

            <label for="city">City</label>
            <input type="text" id="city" name="city" required>
            <br><br>

            <label for="phone">Phone</label>
            <input type="text" id="phone" pattern="\+?[0-9]{10,15}" name="phone" required>
            <br><br> 

            <button type="submit">Update profile</button>
        </form>
    </section>
</body>
</html>



