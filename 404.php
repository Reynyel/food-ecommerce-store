<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    //redirect them to your desired location
    header('location: http://localhost/freshcery/index.php');
    exit;
}

?>
<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php


?>
<div class="banner">
    <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo $appurl; ?>/assets/img/bg-header.jpg');">
        <div class="container">
            <h1 class="pt-5">
                404 page, we cannot find the page that you are looking for.
            </h1>
            <!-- <p class="lead">
                Save time and leave the groceries to us.
            </p> -->
            <a href="<?php echo $appurl; ?>" class="btn btn-primary text-uppercase">home</a>


        </div>
    </div>
</div>

<?php require "includes/footer.php"; ?>