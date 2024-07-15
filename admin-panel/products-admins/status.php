<?php
require "../layouts/header.php";
require "../../config/config.php";
?>

<?php
if (!isset($_SESSION['adminname'])) {
    echo "<script> window.location.href='" . ADMINURL . "/admins/login-admins.php';</script>";
} ?>

<?php
// query to chamge status of products
if (isset($_GET['id']) and isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    if ($status == 0) {
        $update = $conn->prepare("UPDATE products SET status = 1 WHERE id = '$id'");
        $update->execute();
    } else {
        $update = $conn->prepare("UPDATE products SET status = 0 WHERE id = '$id'");
        $update->execute();
    }

    echo "<script> window.location.href='" . ADMINURL . "/products-admins/show-products.php';</script>";
}
