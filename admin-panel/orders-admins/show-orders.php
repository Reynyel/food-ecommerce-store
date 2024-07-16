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

$orders = $conn->query("SELECT * FROM orders");
$orders->execute();

$allOrders = $orders->fetchAll(PDO::FETCH_OBJ);

?>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4 d-inline">Orders</h5>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">first name</th>
              <th scope="col">last name</th>
              <th scope="col">email</th>
              <th scope="col">country</th>
              <th scope="col">status</th>
              <th scope="col">price in USD</th>
              <th scope="col">date</th>
              <th scope="col">update</th>
              <th scope="col">delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($allOrders as $order) : ?>
              <tr>
                <th scope="row"><?php echo $order->id; ?></th>
                <td><?php echo $order->name; ?></td>
                <td><?php echo $order->lname; ?></td>
                <td><?php echo $order->email; ?></td>
                <td><?php echo $order->country; ?></td>
                <td><?php echo $order->status; ?></td>
                <td><?php echo $order->price; ?></td>
                <td><?php echo $order->created_at; ?></td>
                <td>
                  <a href="<?php echo ADMINURL; ?>/orders-admins/update-orders-status.php?id=<?php echo $order->id; ?>" class="btn btn-warning text-white mb-4 text-center">Update</a>
                </td>
                <td><a href="delete-order.php?id=<?php echo $order->id; ?>" class="btn btn-danger  text-center ">Delete </a></td>

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