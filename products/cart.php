<?php
// Including necessary files
require "../includes/header.php";
require "../config/config.php";

// Fetch products for the logged-in user
$products = $conn->prepare("SELECT * FROM cart WHERE user_id = $_SESSION[id]");
$products->execute();

$allProducts = $products->fetchAll(PDO::FETCH_OBJ);
?>
<div id="page-content" class="page-content">
    <div class="banner">
        <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo $appurl; ?>/assets/img/bg-header.jpg');">
            <div class="container">
                <h1 class="pt-5">
                    Your Cart
                </h1>
                <p class="lead">
                    Save time and leave the groceries to us.
                </p>
            </div>
        </div>
    </div>

    <section id="cart">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="10%"></th>
                                    <th>Products</th>
                                    <th>Price</th>
                                    <th width="15%">Quantity</th>
                                    <th width="15%">Update</th>
                                    <th>Subtotal</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($allProducts as $product) : ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo $appurl; ?>/assets/img/<?php echo $product->pro_image; ?>" width="60">
                                        </td>
                                        <td>
                                            <?php echo $product->pro_title; ?><br>
                                            <small>1000g</small>
                                        </td>
                                        <td>
                                            PHP <?php echo $product->price; ?>
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" min="1" data-bts-button-down-class="btn btn-primary" data-bts-button-up-class="btn btn-primary" value="<?php echo $product->pro_qty; ?>" name="vertical-spin">
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-primary">UPDATE</a>
                                        </td>
                                        <td>
                                            Rp 30.000
                                        </td>
                                        <td>
                                            <a href="javasript:void" class="text-danger"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col">
                    <a href="shop.html" class="btn btn-default">Continue Shopping</a>
                </div>
                <div class="col text-right">

                    <div class="clearfix"></div>
                    <h6 class="mt-3">Total: Rp 180.000</h6>
                    <a href="checkout.html" class="btn btn-lg btn-primary">Checkout <i class="fa fa-long-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- HTML section ends here -->
<?php require "../includes/footer.php"; ?>

<script>
    $(document).ready(function() {
        $(".form-control").keyup(function() {
            var value = $(this).val();
            value = value.replace(/^(0*)/, "");
            $(this).val(1);
        });

    })
</script>