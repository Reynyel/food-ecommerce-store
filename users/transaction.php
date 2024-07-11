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

    $select = $conn->query("SELECT * FROM orders where user_id='$id'");
    $select->execute();

    $data = $select->fetchAll(PDO::FETCH_OBJ);
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
                    Your Transactions
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
                                    <th width="5%"></th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($data) > 0) : ?>
                                    <?php foreach ($data as $order) : ?>
                                        <tr>
                                            <td><?php echo $order->id; ?></td>
                                            <td>
                                                <?php echo $order->name; ?>
                                            </td>
                                            <td>
                                                <?php echo $order->created_at; ?>
                                            </td>
                                            <td>
                                                PHP <?php echo $order->price; ?>
                                            </td>
                                            <td>
                                                <?php echo $order->status; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="alert alert-success bg-success text-white text-center">
                                        There are no orders yet.
                                    </div>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </section>


</div>
<?php
// Including necessary files
require "../includes/footer.php";
