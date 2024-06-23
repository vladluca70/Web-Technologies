<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="http://localhost/try/cssFiles/modifyCompanyProfile.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="http://localhost/try/phpFiles/company.php">Profile</a></li>
                <li><a href="">Modify Profile</a></li>
                <li><a href="http://localhost/try/htmlFiles/offersForCompany.html">Offers</a></li>
                <li><a href="http://localhost/try/htmlFiles/acceptedOffersC.html">Accepted offers</a></li>
                <li><a href="http://localhost/try/phpFiles/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    
    <form id="modify" method="POST" action="http://localhost/try/phpFiles/modifyC.php">
        <h2>Modify Profile</h2>
        
        <label for="companyName">Company name</label>
        <input type="text" id="companyName" name="companyName" required>
        <br><br> 

        <label for="city">City</label>
        <input type="text" id="city" name="city" required>
        <br><br>
        
        <div class="about-us">
            <label for="aboutUs">About Us</label><br>
            <textarea id="aboutUs" name="aboutUs" rows="10" cols="20" required></textarea>
        </div>
        <br>

        <label for="phone">Phone</label>
        <input type="text" id="phone" pattern="\+?[0-9]{10,15}" name="phone" required>
        <br><br> 

        <button type="submit">Update profile</button>
    </form>
</body>
</html>
