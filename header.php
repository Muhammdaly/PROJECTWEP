<!-- Header file for the project, which includes the HTML structure and navigation menu. It also checks if a user is logged in or not and displays appropriate links accordingly. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صيدليات</title>
    <link rel="stylesheet" href="CSS/style.css"/>
</head>
<body>
    <header>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="Pharmacies.php">Pharmacies</a></li>

            <?php if(empty($_SESSION['user'])){?>
            
            <li><a href="login.php">Login</a></li>
            <li><a href="signup.php">SignUp User</a></li>
            <li><a href="signup_owner.php">SignUp Owner</a></li>
            <?php }else{?>
            <li><a href="logout.php">logout</a></li>
            <?php } ?>

        </ul>
    </header>
    
