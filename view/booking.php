<?php include('layouts/header.php');

if (!isset($_SESSION['email'])) {
        header("location: /");
}

$url = parse_url($_SERVER['REQUEST_URI']);

parse_str($url['query'], $params);

$locationDetails = getLocationbyID($db, $params["id"]);
if (!$locationDetails) {
        header("location: /map");
} else if (!$locationDetails["car"]) {
        header("location: /map");
} else if ($currentBooking) {
        header("location: /map");
}
?>



<div class="header">
        <h2>Bookings</h2>

</div>

<form method="post" action="#">
        <?php include($errorPath); ?>
        <?php if (isset($_SESSION['success'])) : ?>
                <div class="error success">
                        <h3>
                                <?php
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                                ?>
                        </h3>
                </div>
        <?php endif ?>

        <input type="hidden" name="post" value="book">
        <input type="hidden" name="locationID" value=<?= $locationDetails["id"] ?>>
        <input type="hidden" name="userID" value=<?= $user["id"] ?>>
        <input type="hidden" name="carID" value=<?= $locationDetails["car"]["id"] ?>>



        <h7 class="profile"> Location: </h7> <b class="details"><?= $locationDetails["name"] ?></b>
        </br>
        <h7 class="profile"> Car: </h7><b class="details"><?= $locationDetails["car"]["carName"] ?> (<?= $locationDetails["car"]["carType"] ?>)</b>
        </br>
        </br>

        <div class="input-group">
                <label>Please select start time of booking</label>
                <input type="text" id="timepicker1" name="startTime" required readonly />
        </div>
        <div class="input-group">
                <label>Please select duration of booking</label>
                <input type="text" id="timepicker2" name="endTime" required readonly />
        </div>
        <br>
        <b>Estimated cost : </b><input size="6" type="text" id="cost" name="cost" readonly />
        <br>
        <div class="input-group">
                <button type="submit" class="btn" name="book">Book</button>
        </div>

</form>
<script type="text/javascript">
        setFirst()
        setSecond()
</script>
<?php include('layouts/footer.php') ?>