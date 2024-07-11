<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    //redirect them to your desired location
    header('location: http://localhost/freshcery/index.php');
    exit;
}

?>
<?php
// Including necessary files
require "../includes/header.php";
require "../config/config.php";


if (!isset($_SESSION['username'])) {
    echo "<script> window.location.href='" . $appurl . "';</script>";
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $pro_qty = $_POST['pro_qty'];
    $sub_total = $_POST['subtotal'];

    $update = $conn->prepare("UPDATE cart SET pro_qty = :pro_qty, pro_subtotal = :sub_total WHERE id = :id");
    $update->execute([
        ':pro_qty' => $pro_qty,
        ':sub_total' => $sub_total,
        ':id' => $id
    ]);

    echo "Product updated successfully.";
}
