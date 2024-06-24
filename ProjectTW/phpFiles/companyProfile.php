<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlaCO</title>
    <link rel="stylesheet" href="http://localhost/ProjectTW/cssFiles/company.css">
    <link rel="icon" href="http://localhost/ProjectTW/images/logo1.png" type="image/x-icon">
</head>
<body style="background-color: green;">
    <header>
        <nav>
            <ul>
                <li><a href="">Profile</a></li>
                <li><a href="http://localhost/ProjectTW/htmlFiles/modifyCompanyProfile.html">Modify Profile</a></li>
                <li><a href="http://localhost/ProjectTW/htmlFiles/offersForCompany.html">Offers</a> </li>
                <li><a href="http://localhost/ProjectTW/htmlFiles/acceptedOffersC.html">Accepted offers</a></li>
                <li><a href="http://localhost/ProjectTW/phpFiles/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="user-info">
    <h2>Company name</h2>
    <?php echo htmlspecialchars($result['companyname'], ENT_QUOTES, 'UTF-8'); ?>

    <h2>City</h2>
    <?php echo htmlspecialchars($result['city'], ENT_QUOTES, 'UTF-8'); ?>

    <h2>About us</h2>
    <?php echo htmlspecialchars($result['about_us'], ENT_QUOTES, 'UTF-8'); ?>

    <h2>Contact</h2>
    <?php echo htmlspecialchars($result['email'], ENT_QUOTES, 'UTF-8'); ?>
    <?php echo htmlspecialchars($result['phone'], ENT_QUOTES, 'UTF-8'); ?>
</section>

</body>
</html>


