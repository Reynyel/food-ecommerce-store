<?php
// Including necessary files
require "../includes/header.php";
require "../config/config.php";


// if (!isset($_SESSION['username'])) {
//     echo "<script> window.location.href='" . $appurl . "';</script>";
// }

// Handling form submission to add products to cart
if (isset($_POST['submit'])) {
    // Retrieving form data
    $pro_id = $_POST['pro_id'];
    $pro_title = $_POST['pro_title'];
    $pro_image = $_POST['pro_image'];
    $pro_price = $_POST['pro_price'];
    $pro_qty = $_POST['pro_qty'];
    $pro_subtotal = $_POST['pro_subtotal'];
    $user_id = $_POST['user_id'];

    // Preparing and executing SQL insertion into 'cart' table
    $insert = $conn->prepare("INSERT INTO cart (pro_id, pro_title, pro_image, pro_price, pro_qty, pro_subtotal, user_id) VALUES(:pro_id, :pro_title, :pro_image, :pro_price, :pro_qty, :pro_subtotal,:user_id)");

    $insert->execute([
        ':pro_id' => $pro_id,
        ':pro_title' => $pro_title,
        ':pro_image' => $pro_image,
        ':pro_price' => $pro_price,
        ':pro_qty' => $pro_qty,
        ':pro_subtotal' => $pro_subtotal,
        ':user_id' => $user_id,
    ]);
}

// Handling product details retrieval based on ID from URL parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $select = $conn->prepare("SELECT * FROM products WHERE status = 1 AND id = :id");
    $select->execute([':id' => $id]);

    // Fetching the selected product details
    $product = $select->fetch(PDO::FETCH_OBJ);

    // Fetching related products based on category of the selected product
    $relatedProducts = $conn->prepare("SELECT * FROM products WHERE status = 1 AND category_id = :category_id AND id != :id");
    $relatedProducts->execute([':category_id' => $product->category_id, ':id' => $id]);

    // Fetching all related products as an array of objects
    $allRelatedProducts = $relatedProducts->fetchAll(PDO::FETCH_OBJ);

    // Initialize $validate to avoid undefined variable warnings
    $validate = null;

    // Validate cart products
    if (isset($_SESSION['id'])) {
        $validate = $conn->prepare("SELECT * FROM cart WHERE pro_id = $id AND user_id = $_SESSION[id]");
        $validate->execute();

        // Error handling for SQL query
        if ($validate === false) {
            $errorInfo = $conn->errorInfo();
            echo "SQL Error: " . $errorInfo[2];
        }
    }
} else {
    // If no ID parameter is provided, do nothing or handle accordingly
    echo "<script> window.location.href='" . $appurl . "/404.php';</script>";
}
?>
<!-- HTML section starts here -->
<div id="page-content" class="page-content">
    <!-- Banner section -->
    <div class="banner">
        <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo $appurl; ?>/assets/img/bg-header.jpg');">
            <div class="container">
                <h1 class="pt-5">
                    The Meat Product Title
                </h1>
                <p class="lead">
                    Save time and leave the groceries to us.
                </p>
            </div>
        </div>
    </div>
    <!-- Product detail section -->
    <div class="product-detail">
        <div class="container">
            <div class="row">
                <!-- Product image slider -->
                <div class="col-sm-6">
                    <div class="slider-zoom">
                        <a href="<?php echo IMGURLPRODUCT; ?>/<?php echo $product->image; ?>" class="cloud-zoom" rel="transparentImage: 'data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==', useWrapper: false, showTitle: false, zoomWidth:'500', zoomHeight:'500', adjustY:0, adjustX:10" id="cloudZoom">
                            <img alt="Detail Zoom thumbs image" src="<?php echo IMGURLPRODUCT; ?>/<?php echo $product->image; ?>" style="width: 100%;">
                        </a>
                    </div>
                </div>
                <!-- Product details -->
                <div class="col-sm-6">
                    <p>
                        <strong>Overview</strong><br>
                        <?php echo $product->description; ?>
                    </p>
                    <div class="row">
                        <div class="col-sm-6">
                            <p>
                                <strong>Price</strong> (/Pack)<br>
                                <span class="price">PHP <?php echo $product->price; ?></span>
                                <!-- <span class="old-price">Rp 150.000</span> -->
                            </p>
                        </div>
                    </div>
                    <p class="mb-1">
                        <strong>Quantity</strong>
                    </p>
                    <!-- Form to add product to cart -->
                    <form method="POST" id="form-data">
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="hidden" name="pro_title" value="<?php echo $product->title; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="hidden" name="pro_image" value="<?php echo $product->image; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="hidden" name="pro_price" value="<?php echo $product->price; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="hidden" name="user_id" value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="hidden" name="pro_id" value="<?php echo $product->id; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="pro_qty form-control" type="number" min="1" data-bts-button-down-class="btn btn-primary" data-bts-button-up-class="btn btn-primary" value="<?php echo $product->quantity; ?>" name="pro_qty">
                            </div>
                            <div class="col-sm-6"><span class="pt-1 d-inline-block">Pack (1000 gram)</span></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="subtotal_price form-control" type="hidden" name="pro_subtotal" value="<?php echo $product->price * $product->quantity; ?>">
                            </div>
                        </div>
                        <?php if (isset($_SESSION['username'])) : ?>
                            <!-- Submit button to add to cart -->
                            <?php if ($validate && $validate->rowCount() > 0) : ?>
                                <button name="submit" type="submit" class="btn-insert mt-3 btn btn-primary btn-lg" disabled>
                                    <i class="fa fa-shopping-basket"></i> Added to Cart
                                </button>
                            <?php else : ?>
                                <button name="submit" type="submit" class="btn-insert mt-3 btn btn-primary btn-lg">
                                    <i class="fa fa-shopping-basket"></i> Add to Cart
                                </button>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="alert alert-success bg-success text-white text-center mt-3">
                                Log in to buy this product.
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Related products section -->
    <section id="related-product">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title">Related Products</h2>
                    <!-- Carousel for related products -->
                    <div class="product-carousel owl-carousel">
                        <?php foreach ($allRelatedProducts as $allRelatedProduct) : ?>
                            <div class="item">
                                <div class="card card-product">
                                    <div class="card-ribbon">
                                        <div class="card-ribbon-container right">
                                            <span class="ribbon ribbon-primary">SPECIAL</span>
                                        </div>
                                    </div>
                                    <div class="card-badge">
                                        <div class="card-badge-container left">
                                            <span class="badge badge-default">
                                                Until <?php echo $allRelatedProduct->exp_date; ?>
                                            </span>
                                            <span class="badge badge-primary">
                                                20% OFF
                                            </span>
                                        </div>
                                        <img src="<?php echo IMGURLPRODUCT; ?>/<?php echo $allRelatedProduct->image; ?>" class="card-img-top" alt="...">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="<?php echo $appurl; ?>/shops/detail-products.php?id=<?php echo $allRelatedProduct->id; ?>"><?php echo $allRelatedProduct->title; ?></a>
                                        </h5>
                                        <div class="card-price">
                                            <span class="discount">PHP <?php echo $allRelatedProduct->price; ?></span>
                                        </div>
                                        <a href="<?php echo $appurl; ?>/shops/detail-products.php?id=<?php echo $allRelatedProduct->id; ?>" class="btn btn-block btn-primary">
                                            Add to Cart <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- HTML section ends here -->
<?php require "../includes/footer.php"; ?>


<script>
    $(document).ready(function() {
        // Ensure quantity input value is at least 1
        $(".pro_qty").on('input', function() {
            var value = $(this).val();
            if (value < 1) {
                $(this).val(1);
            }
        });

        // AJAX call to add product to cart without refreshing the page
        $(".btn-insert").on("click", function(e) {
            e.preventDefault();

            var form_data = $("#form-data").serialize() + '&submit=submit';

            $.ajax({
                url: "detail-product.php?id=<?php echo $id; ?>",
                method: "POST",
                data: form_data,
                success: function() {
                    alert("Product added to cart");
                    $(".btn-insert").html("<i class='fa fa-shopping-basket'></i> Added to Cart").prop("disabled", true);
                    withRef();
                }
            });
        });

        function withRef() {
            $("body").load("detail-product.php?id=<?php echo $id; ?>");
        }

        $(".pro_qty").on('input', function() {
            var $el = $(this).closest('form');

            var pro_qty = $el.find(".pro_qty").val();
            var pro_price = "<?php echo $product->price; ?>"; // Ensure this line fetches the correct price

            if (!isNaN(pro_qty) && !isNaN(pro_price)) {
                var subtotal = pro_qty * pro_price;
                // alert(subtotal);
                $el.find(".subtotal_price").val(subtotal);
            } else {
                alert("Error: Invalid quantity or price.");
            }
        });
    });
</script>