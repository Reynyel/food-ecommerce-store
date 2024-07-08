<?php
// Including necessary files
require "../includes/header.php";
require "../config/config.php";

if (isset($_POST['delete'])) {
    $id = $_POST['id'];


    $update = $conn->prepare("DELETE FROM cart WHERE id = :id");
    $update->execute([
        ':id' => $id
    ]);

    echo "Product updated successfully.";
}
