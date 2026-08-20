<?php
session_start();
require("connection.php");
include("header.php");

$query = "SELECT * FROM `pharmacies`";
$result = mysqli_query($connection, $query);
?>

<main>
    <h2 style="text-align:center; margin-top:20px;">Pharmacies</h2>

    <div class="pharmacies-grid">

        <?php while($row = mysqli_fetch_object($result)){ ?>

            <div class="pharmacy-card">
                <?php if(!empty($row->image)): ?>
                    <img src="<?php echo $row->image; ?>" alt="<?php echo $row->name; ?>">
                <?php else: ?>
                    <img src="images/default-pharmacy.png" alt="<?php echo $row->name; ?>">
                <?php endif; ?>

                <p class="pharmacy-name"><?php echo $row->name; ?></p>
                <p class="pharmacy-info">📍 <?php echo $row->address; ?></p>
                <p class="pharmacy-info">📞 <?php echo $row->phone; ?></p>
            </div>

        <?php } ?>

    </div>
</main>

<?php include("footer.php"); ?>