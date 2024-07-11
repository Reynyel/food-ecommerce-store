<?php
// Including necessary files
require "../includes/header.php";
require "../config/config.php"; ?>
<?php
if (!isset($_SESSION['username'])) {
    echo "<script> window.location.href='" . $appurl . "';</script>";
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // if the user id doesnt match the url, return to index
    if ($id != $_SESSION['id']) {
        echo "<script> window.location.href='" . $appurl . "';</script>";
    }

    $select = $conn->query("SELECT * FROM users where id='$id'");
    $select->execute();

    $users = $select->fetch(PDO::FETCH_OBJ);

    if (isset($_POST['submit'])) {
        $fullname = $_POST['fullname'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $zip_code = $_POST['zip_code'];
        $phone_number = $_POST['phone_number'];

        $update = $conn->prepare("UPDATE users SET fullname = '$fullname',
        address = '$address', city = '$city', country = '$country',
        zip_code = '$zip_code', phone_number = '$phone_number' WHERE id='$id'");

        $update->execute();
        echo "<script> window.location.href='" . $appurl . "';</script>";
    }
} else {
    // If no ID parameter is provided, do nothing or handle accordingly
    echo "<script> window.location.href='" . $appurl . "/404.php';</script>";
}
?>
<div id="page-content" class="page-content">
    <div class="banner">
        <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo $appurl; ?>/assets/img/bg-header.jpg');">
            <div class="container">
                <h1 class="pt-5">
                    Settings
                </h1>
                <p class="lead">
                    Update Your Account Info
                </p>
            </div>
        </div>
    </div>

    <section id="checkout">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-6">
                    <h5 class="mb-3">ACCOUNT DETAILS</h5>
                    <!-- Bill Detail of the Page -->
                    <form action="setting.php?id=<?php echo $id; ?>" method="POST" class="bill-detail">
                        <fieldset>
                            <div class="form-group row">
                                <div class="col">
                                    <input class="form-control" placeholder="Full Name" type="text" name="fullname" value="<?php echo $users->fullname; ?>">
                                </div>

                            </div>

                            <div class="form-group">
                                <textarea class="form-control" placeholder="Address" name="address"><?php echo $users->address; ?></textarea>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Town / City" type="text" name="city" value="<?php echo $users->city; ?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="State / Country" type="text" name="country" value="<?php echo $users->country; ?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Postcode / Zip" type="text" name="zip_code" value="<?php echo $users->zip_code; ?>">
                            </div>
                            <div class="form-group row">
                                <!-- <div class="col">
                                    <input class="form-control" placeholder="Email Address" type="email">
                                </div> -->
                                <div class="col">
                                    <input class="form-control" placeholder="Phone Number" type="tel" name="phone_number" value="<?php echo $users->phone_number; ?>">
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <input class="form-control" placeholder="Password" type="password">
                            </div> -->
                            <div class="form-group text-right">
                                <button type="submit" name="submit" class="btn btn-primary">UPDATE</button>
                                <div class="clearfix">
                                </div>
                        </fieldset>
                    </form>
                    <!-- Bill Detail of the Page end -->
                </div>
            </div>
        </div>
    </section>
</div>
<?php
// Including necessary files
require "../includes/footer.php";
