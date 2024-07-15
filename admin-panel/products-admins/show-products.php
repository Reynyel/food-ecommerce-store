<?php
require "../layouts/header.php";
require "../../config/config.php";
?>

<?php
if (!isset($_SESSION['adminname'])) {
  echo "<script> window.location.href='" . ADMINURL . "/admins/login-admins.php';</script>";
} ?>

<?php
// query to display all products

$products = $conn->query("SELECT * FROM products");
$products->execute();

$allProducts = $products->fetchAll(PDO::FETCH_OBJ);

?>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4 d-inline">Products</h5>
        <a href="create-products.php" class="btn btn-primary mb-4 text-center float-right">Create Products</a>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">product</th>
              <th scope="col">price in $$</th>
              <th scope="col">expiration date</th>
              <th scope="col">status</th>
              <th scope="col">delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($allProducts as $product) : ?>
              <tr>
                <th scope="row"><?php echo $product->id; ?></th>
                <td><?php echo $product->title; ?></td>
                <td><?php echo $product->price; ?></td>
                <td><?php echo $product->exp_date; ?></td>
                <?php if ($product->status == 1) : ?>
                  <td><a href="<?php echo ADMINURL; ?>/products-admins/status.php?id=<?php echo $product->id; ?>&status=<?php echo $product->status; ?>" class="btn btn-success  text-center ">Available</a></td>
                <?php else : ?>
                  <td><a href="<?php echo ADMINURL; ?>/products-admins/status.php?id=<?php echo $product->id; ?>&status=<?php echo $product->status; ?>" class="btn btn-danger  text-center ">Unavailable</a></td>
                <?php endif; ?>
                <td><a href="<?php echo ADMINURL; ?>/products-admins/delete.php?id=<?php echo $product->id; ?>" class="btn btn-danger  text-center ">Delete</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<?php
require "../layouts/footer.php";
?>