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

if (isset($_POST['delete'])) {
    $id = $_POST['id'];


    $update = $conn->prepare("DELETE FROM cart WHERE id = :id");
    $update->execute([
        ':id' => $id
    ]);

    echo "Product updated successfully.";
}
