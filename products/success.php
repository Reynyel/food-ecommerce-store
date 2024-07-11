<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php
if (isset($_SESSION['id'])) {

    $delete = $conn->prepare("DELETE FROM cart WHERE user_id = '$_SESSION[id]'");
    $delete->execute();
}
?>
<div class="banner">
    <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo $appurl; ?>/assets/img/bg-header.jpg');">
        <div class="container">
            <h1 class="pt-5">
                Payment has been a success
            </h1>
            <p class="lead">
                Save time and leave the groceries to us.
            </p>
            <a href="<?php echo $appurl; ?>" class="btn btn-primary text-uppercase">home</a>


        </div>
    </div>
</div>

<?php require "../includes/footer.php"; ?>