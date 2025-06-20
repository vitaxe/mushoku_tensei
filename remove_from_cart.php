<?php
require_once './db_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    dbQuery("DELETE FROM cart WHERE id = ?", [$id]);
}

header("Location: cart.php");
exit;
