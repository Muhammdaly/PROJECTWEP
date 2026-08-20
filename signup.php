<?php
require("connection.php");
if($_POST){
    // link between my signup page and mysql

    // save my i/p data
    $username = $_POST['username'];
    $email = $_POST['Email'];
    $password = $_POST['password'];
    $date = date("Y-m-d H:i:s");

    // نتحقق الأول إن الإيميل مش مسجل قبل كده
    $check_query = "SELECT * FROM `users` WHERE email = '$email' LIMIT 1";
    $check_result = mysqli_query($connection, $check_query);

    if(mysqli_num_rows($check_result) > 0){
        $error = "this email is already registered";
    } else {
        // تشفير الباسورد قبل التخزين
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // my sql query to insert data into database
        $query = "INSERT INTO users (`username`, `email`, `password`, `date`) VALUES ('$username', '$email', '$hashed_password', '$date')";

        // Send Query
        $result = mysqli_query($connection, $query);

        if($result){
            header("location:login.php");
            exit;
        } else {
            $error = "something went wrong, please try again";
        }
    }
}
?>
<?php include("header.php");  ?>

<main>
<form class="signup-form" action="" method="post">
    <input type="text" name="username" placeholder="username"required />
    <input type="email" name="Email" placeholder="Email"required/>
    <input type="password" name="password" placeholder="password"required minlength="6"/>
    <button>Sign UP</button>

    <?php if(isset($error)){ ?>
        <div><?php echo $error; ?></div>
    <?php } ?>
</form>

</main>
<?php include("footer.php");  ?>
