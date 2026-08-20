<?php
session_start();
require("connection.php");

if($_POST){

    // Save data in variable
    $email = $_POST['email'];
    $password = $_POST['password'];

    // query - نجيب اليوزر بالإيميل بس (من غير الباسورد)
    $query = "SELECT * FROM `users` WHERE email = '$email' LIMIT 1";

    // execute mysql
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_object($result);

        // نتحقق من الباسورد المشفر
        if(password_verify($password, $row->password))
        {
            $_SESSION['user'] = $row;
            header("location:profile.php");
            exit;
        }
        else
        {
            $error = "the email or password are incorrect";
        }
    }
    else
    {
        $error = "the email or password are incorrect";
    }
}
?>
<?php include("header.php");  ?>
<main>
    <form  class="loginform" action="" method="post">

        <input type="email" name="email" placeholder="Email"/><br>
        <input type="password" name="password" placeholder="password"/><br>
        <button>Login</button>

        <?php if(isset($error))
        {
        ?>
        <div>
        <?php
        echo $error;
        }
        ?>
        </div>

    </form>
</main>
<?php include("footer.php");?>