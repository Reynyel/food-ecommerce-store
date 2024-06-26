<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $select = $conn->query("SELECT * FROM products WHERE status = 1 AND id = '$id'");
    $select->execute();

    $product = $select->fetch(PDO::FETCH_OBJ);

    // fetch related products
    $relatedProducts = $conn->query("SELECT * FROM products WHERE status = 1 
    AND category_id = '$product->category_id' AND id != '$id'");

    $relatedProducts->execute();

    // GET ALL RELATED PRODUCTS
    $allRelatedProducts = $relatedProducts->fetchAll(PDO::FETCH_OBJ);

    // var_dump($allRelatedProducts);
} else {
}
?>
<div id="page-content" class="page-content">
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
    <div class="product-detail">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="slider-zoom">
                        <a href="<?php echo $appurl; ?>/assets/img/<?php echo $product->image; ?>" class="cloud-zoom" rel="transparentImage: 'data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==', useWrapper: false, showTitle: false, zoomWidth:'500', zoomHeight:'500', adjustY:0, adjustX:10" id="cloudZoom">
                            <img alt="Detail Zoom thumbs image" src="<?php echo $appurl; ?>/assets/img/<?php echo $product->image; ?>" style="width: 100%;">
                        </a>
                    </div>
                </div>
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
                    <div class="row">
                        <div class="col-sm-5">
                            <input class="form-control" type="number" min="1" data-bts-button-down-class="btn btn-primary" data-bts-button-up-class="btn btn-primary" value="<?php echo $product->quantity; ?>" name="vertical-spin">
                        </div>
                        <div class="col-sm-6"><span class="pt-1 d-inline-block">Pack (1000 gram)</span></div>
                    </div>

                    <button class="mt-3 btn btn-primary btn-lg">
                        <i class="fa fa-shopping-basket"></i> Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section id="related-product">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title">Related Products</h2>
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
                                        <img src="<?php echo $appurl; ?>assets/img/<?php echo $allRelatedProduct->image; ?>" alt="Card image 2" class="card-img-top">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <a href="<?php echo $allRelatedProduct->exp_date; ?>/products/detail-product.php"><?php echo $allRelatedProduct->title; ?></a>
                                        </h4>
                                        <div class="card-price">
                                            <!-- <span class="discount">Rp. 300.000</span> -->
                                            <span class="reguler">PHP <?php echo $allRelatedProduct->price; ?></span>
                                        </div>
                                        <a href="<?php echo $appurl; ?>/products/detail-product.php?id=<?php echo $allRelatedProduct->id; ?>" class="btn btn-block btn-primary">
                                            Add to Cart
                                        </a>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
    </section>
</div>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h5>About</h5>
                <p>Nisi esse dolor irure dolor eiusmod ex deserunt proident cillum eu qui enim occaecat sunt aliqua anim eiusmod qui ut voluptate.</p>
            </div>
            <div class="col-md-3">
                <h5>Links</h5>
                <ul>
                    <li>
                        <a href="about.html">About</a>
                    </li>
                    <li>
                        <a href="contact.html">Contact Us</a>
                    </li>
                    <li>
                        <a href="faq.html">FAQ</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">How it Works</a>
                    </li>
                    <li>
                        <a href="terms.html">Terms</a>
                    </li>
                    <li>
                        <a href="privacy.html">Privacy Policy</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Contact</h5>
                <ul>
                    <li>
                        <a href="tel:+620892738334"><i class="fa fa-phone"></i> 08272367238</a>
                    </li>
                    <li>
                        <a href="mailto:hello@domain.com"><i class="fa fa-envelope"></i> hello@domain.com</a>
                    </li>
                </ul>

                <h5>Follow Us</h5>
                <ul class="social">
                    <li>
                        <a href="javascript:void(0)" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" target="_blank"><i class="fab fa-instagram"></i></a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" target="_blank"><i class="fab fa-youtube"></i></a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Get Our App</h5>
                <ul class="mb-0">
                    <li class="download-app">
                        <a href="#"><img src="assets/img/playstore.png"></a>
                    </li>
                    <li style="height: 200px">
                        <div class="mockup">
                            <img src="assets/img/mockup.png">
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
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