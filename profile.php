<?php
session_start();
require("connection.php");
require("function.php");
check_login();

// نجيب الـ id من السيشن على طول (مش لازم ننتظر الـ Update)
$id = $_SESSION['user']->id;

// كل مرة الصفحة تتفتح، نحدث بيانات اليوزر من الداتا بيز (مش من السيشن القديمة)
$query = "SELECT * FROM `users` where id = '$id' limit 1";
$result = mysqli_query($connection, $query);
if (mysqli_num_rows($result) > 0){
    $_SESSION['user'] = mysqli_fetch_object($result);
}
?>

<?php include("header.php");  ?>

<?php
// ============ جزء تحديث البيانات (Update) ============
if (isset($_POST['edit-profile']) && $_POST['edit-profile'] === "Update"){

    $image_added = false;
    if (isset($_FILES['image']['name']) && $_FILES['image']['error'] === 0){

        $folder = "upload/";
        if(!file_exists($folder)){
            mkdir($folder);
        }
        $destination = $folder . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']["tmp_name"], $destination);
        $image_added = true;

        if (!empty($_SESSION['user']->image) && file_exists($_SESSION['user']->image)){
            unlink($_SESSION['user']->image);
        }
    }

    // save data in variable
    $username = addslashes($_POST['username']);
    $email = addslashes($_POST['email']);
    $password = $_POST['password'];

    // لو الباسورد اتغير، نشفره. لو سايبه فاضي أو زي القديم، نسيبه زي ما هو
    if(!empty($password) && $password !== $_SESSION['user']->password){
        $password = password_hash(addslashes($password), PASSWORD_DEFAULT);
    } else {
        $password = $_SESSION['user']->password;
    }

    // query لتحديث البيانات
    if ($image_added){
        $query = "UPDATE `users` SET username = '$username', email = '$email', password = '$password', image = '$destination' where id = '$id'";
    } else {
        $query = "UPDATE `users` SET username = '$username', email = '$email', password = '$password' where id = '$id'";
    }
    mysqli_query($connection, $query);

    // نحدث السيشن فورًا بعد التحديث
    $query = "SELECT * FROM `users` where id = '$id' limit 1";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) > 0){
        $_SESSION['user'] = mysqli_fetch_object($result);
    }
    header("location:profile.php");
    exit;
}
?>

<?php if(isset($_GET['action']) && $_GET["action"] === "edit"){ ?>

<main>
    <h2 style="text-align:center;">Edit Profile</h2>
    <div style="text-align:center;padding-top:20px;">
        <img width="150px" src="<?php echo $_SESSION['user']->image; ?>" />
    </div>
    <form class="edit-profile" action="" method="post" enctype="multipart/form-data">
        Image <input type="file" name="image"/>
        <input value="<?php echo $_SESSION['user']->username; ?>" type="text" placeholder="username" name="username"/>
        <input type="email" value="<?php echo $_SESSION['user']->email; ?>" placeholder="email" name="email"/>
        <input type="password" value="" placeholder="password" name="password"/>
        <input type="submit" value="Update" name="edit-profile"/>
    </form>
</main>

<?php

// ============ جزء الحذف (Delete) ============
} else if ( isset($_GET['action']) && $_GET['action'] === "delete"){

if (isset($_POST['delete']) && $_POST['delete'] == "delete User" ){
    $del_id = addslashes($_POST['id']);
    $query = "DELETE FROM `users` WHERE id = '$del_id'";
    mysqli_query($connection, $query);
    header("location:logout.php");
    exit;
}
?>

<main>
    <h2 style="text-align:center;">Delete Profile Page</h2>
    <div style="text-align:center;padding-top:20px;">
        <img width="150px" src="<?php echo $_SESSION['user']->image; ?>" />
    </div>
    <div class="text-center">
        <p>User Name IS : <?php echo $_SESSION['user']->username; ?></p>
        <p>Email Is : <?php echo $_SESSION['user']->email; ?></p>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $_SESSION['user']->id; ?>">
            <input type="submit" name="delete" value="delete User"/>
        </form>
        <button><a href="profile.php">Cancel</a></button>
    </div>
</main>

<?php
// ============ جزء العرض العادي (View) ============
} else{
?>

<main class="profile">
    <div class="d-flex jc-c profile-page">
        <div class="profile-image">
            <?php if (empty($_SESSION['user']->image)): ?>
                <img width="150px" src="./images.png"/>
            <?php else: ?>
                <img width="150px" src="<?php echo $_SESSION['user']->image; ?>"/>
            <?php endif; ?>
        </div>
        <div class="profile-data">
            <p>UserName : <?php echo $_SESSION['user']->username; ?></p>
            <p>Email : <?php echo $_SESSION['user']->email; ?></p>
            <button><a href="profile.php?action=edit">Edit Profile</a></button>
            <button><a href="profile.php?action=delete">Delete Profile</a></button>
        </div>
    </div>
</main>

<?php } ?>
<?php include("footer.php"); ?>