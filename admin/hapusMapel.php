<?php
session_start();
include '../koneksi.php';
$username = $_SESSION['username'];
$level = $_SESSION['level'];
if($level != 'admin'){
    header("Location: ../login.php");;
}
if(empty($username)){
    header("Location: ../login.php");;
}
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM mapel WHERE id_mapel = $id");
header('Location: dataMapel.php');
?>