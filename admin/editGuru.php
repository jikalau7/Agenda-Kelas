<?php
include '../koneksi.php';
include "../function.php";
session_start(); 
$username = $_SESSION['username'];
$level = $_SESSION['level'];
if($level != 'admin'){
    header("Location: ../login.php");;
}
if(empty($username)){
    header("Location: ../login.php");;
}
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * from guru where id_guru = $id");
$valid = mysqli_fetch_array($query);

if (isset($_POST['ubah'])) {
    $edit = $_POST['edit'];

    $ubah = mysqli_query($koneksi, "UPDATE `guru` SET `nama_guru`='$edit' WHERE id_guru = $id");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/dashboard.css">
    <link rel="stylesheet" href="../style/table.css">
    <link rel="stylesheet" href="../style/select.css">
    <link rel="stylesheet" href="../style/form1.css">
    <link rel="stylesheet" href="../style/tombol.css">
    <title>Edit</title>
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <?php
            echo dashboard();
        ?>
        <!-- Main Content -->
        <div class="main-content">
            <header>
                <div class="header-right">
                    <a href="../logout.php">
                        <button class="logout-btn">Logout</button>
                    </a>
                    <button class="toggle-sidebar-btn" id="toggleSidebarBtn">☰</button>
                </div>
            </header>
            <h2>Selamat datang, <?php echo $username ?></h2>
            <div class="form-container">
            <form action="" method="post">
                <h2>Edit data guru</h2>
                <input type="text" name="edit" value="<?php echo $valid['nama_guru'] ; ?>">
                <input type="submit" value="ubah" name="ubah" class="tombol">
            </form>
        </div>
</div>
<script src="../script/dashboard.js"></script>
</body>
</html>