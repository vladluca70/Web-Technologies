<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PlaCO</title>
        <link rel="stylesheet" href="http://localhost/ProjectTW/cssFiles/user.css">
        <link rel="icon" href="http://localhost/ProjectTW/images/logo1.png" type="image/x-icon">
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="">Profile</a></li>
                    <li><a href="http://localhost/ProjectTW/htmlFiles/modifyUserProfile.html">Modify Profile</a></li>
                    <li><a href="http://localhost/ProjectTW/htmlFiles/findServiceUser.html">Find a service</a></li>
                    <li><a href="http://localhost/ProjectTW/htmlFiles/receivedOffersU.html">Received offers</a></li>
                    <li><a href="http://localhost/ProjectTW/htmlFiles/acceptedOffersU.html">Accepted offers</a></li>
                    <li><a href="http://localhost/ProjectTW/phpFiles/logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <section class="user-info">
    <div class="user-data">
        <h2>User name</h2>
        <p class="username"><span class="value"><?php echo htmlspecialchars($result['username'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    </div>

    <div class="user-data">
        <h2>City</h2>
        <p class="city"><span class="value"><?php echo htmlspecialchars($result['city'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    </div>

    <div class="user-data">
        <h2>Contact</h2>
        <p class="contact"><span class="value"><?php echo htmlspecialchars($result['email'], ENT_QUOTES, 'UTF-8'); ?></span></p> 
        <?php echo "<br>"; ?>
        <p class="contact"><span class="value"><?php echo htmlspecialchars($result['phone'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    </div>
    </section>
    </body>
    </html>


