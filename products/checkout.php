<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    //redirect them to your desired location
    header('location: http://localhost/freshcery/index.php');
    exit;
}

?>
<?php // Including necessary files 
require "../includes/header.php";
require "../config/config.php"; ?>
<?php

if (!isset($_SESSION['username'])) {
    echo "<script> window.location.href='" . $appurl . "';</script>";
}



$products = $conn->prepare("SELECT * FROM cart WHERE user_id = $_SESSION[id]");
$products->execute();

$allProducts = $products->fetchAll(PDO::FETCH_OBJ);
if (isset($_SESSION['price'])) {
    $_SESSION['price'] = (float) $_SESSION['price']; // Ensure price is a float
    $_SESSION['total_price'] = $_SESSION['price'] + 20;
}
if (isset($_POST['submit'])) {
    if (
        empty($_POST['name']) or
        empty($_POST['lname']) or
        empty($_POST['cname']) or
        empty($_POST['address']) or
        empty($_POST['city']) or
        empty($_POST['country']) or
        empty($_POST['zip_code']) or
        empty($_POST['email']) or
        empty($_POST['phone_number']) or
        empty($_POST['order_notes'])
    ) {
        echo "<script>alert('one or more inputs are empty');</script>";
    } else {
        $name = $_POST['name'];
        $lname = $_POST['lname'];
        $cname = $_POST['cname'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $zip_code = $_POST['zip_code'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $order_notes = $_POST['order_notes'];
        $price = $_SESSION['total_price'];
        $user_id = $_SESSION['id'];


        $insert = $conn->prepare("INSERT INTO orders(name, lname, cname, address, city, country, zip_code, email, phone_number, order_notes, price, user_id)
        VALUES (:name, :lname, :cname, :address, :city, :country, :zip_code, :email, :phone_number, :order_notes, :price, :user_id)");

        $insert->execute([
            ":name" => $name,
            ":lname" => $lname,
            ":cname" => $cname,
            ":address" => $address,
            ":city" => $city,
            ":country" => $country,
            ":zip_code" => $zip_code,
            ":email" => $email,
            ":phone_number" => $phone_number,
            ":order_notes" => $order_notes,
            ":price" => $price,
            ":user_id" => $user_id
        ]);
        echo "<script> window.location.href='" . $appurl . "/products/charge.php';</script>";
    }
}
?>

<div id="page-content" class="page-content">
    <div class="banner">
        <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo $appurl; ?>/assets/img/bg-header.jpg');">
            <div class="container">
                <h1 class="pt-5">
                    Checkout
                </h1>
                <p class="lead">
                    Save time and leave the groceries to us.
                </p>
            </div>
        </div>
    </div>

    <section id="checkout">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-7">
                    <h5 class="mb-3">BILLING DETAILS</h5>
                    <!-- Bill Detail of the Page -->
                    <form action="checkout.php" method="POST" class="bill-detail">
                        <fieldset>
                            <div class="form-group row">
                                <div class="col">
                                    <input class="form-control" placeholder="Name" type="text" name="name">
                                </div>
                                <div class="col">
                                    <input class="form-control" placeholder="Last Name" type="text" name="lname">
                                </div>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Company Name" type="text" name="cname">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Address" name="address"></textarea>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Town / City" type="text" name="city">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="State / Country" type="text" name="country">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Postcode / Zip" type="text" name="zip_code">
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <input class="form-control" placeholder="Email Address" type="email" name="email">
                                </div>
                                <div class="col">
                                    <input class="form-control" placeholder="Phone Number" type="tel" name="phone_number">
                                </div>
                            </div>

                            <div class="form-group">
                                <textarea class="form-control" placeholder="Order Notes" name="order_notes"></textarea>
                            </div>
                        </fieldset>
                        <button name="submit" type="submit" class="btn btn-primary float-left">PROCEED TO CHECKOUT <i class="fa fa-check"></i></button>
                    </form>
                    <!-- Bill Detail of the Page end -->
                </div>
                <div class="col-xs-12 col-sm-5">
                    <div class="holder">
                        <h5 class="mb-3">YOUR ORDER</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Products</th>
                                        <th class="text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($allProducts as $product) : ?>
                                        <tr>
                                            <td>
                                                <?php echo $product->pro_title; ?> x<?php echo $product->pro_qty; ?>
                                            </td>
                                            <td class="text-right">
                                                PHP <?php echo $product->pro_price; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfooter>
                                    <tr>
                                        <td>
                                            <strong>Cart Subtotal</strong>
                                        </td>
                                        <td class="text-right">
                                            <?php if (isset($_SESSION['id'])) : ?>
                                                PHP <?php echo $_SESSION['price']; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Shipping</strong>
                                        </td>
                                        <td class="text-right">
                                            PHP 20.000
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>ORDER TOTAL</strong>
                                        </td>
                                        <td class="text-right">
                                            <strong>PHP <?php echo $_SESSION['price'] + 20 ?></strong>
                                        </td>
                                    </tr>
                                </tfooter>
                            </table>
                        </div>


                    </div>
                    <!-- <p class="text-right mt-3">
                        <input checked="" type="checkbox"> I’ve read &amp; accept the <a href="#">terms &amp; conditions</a>
                    </p> -->

                    <div class="clearfix">
                    </div>
                </div>
            </div>
    </section>
</div>
<!-- HTML section ends here -->
<?php require "../includes/footer.php"; ?>