<?php
    include "../koneksi.php";
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
    $table = mysqli_query($koneksi, "SELECT * FROM  mapel");

    if (isset($_POST['tambah'])) {
        $tambah = $_POST['inputMapel'];

        $input = mysqli_query($koneksi, "INSERT INTO mapel (mapel) VALUES ('$tambah')");
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
    <title>Dashboard</title>
</head>
<body>
    <div class="container">
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
            <h2>Tambah Mapel</h2>
            <form action="" method="post">
                <label for="inputMapel">
                    <input type="text" name="inputMapel" id="inputMapel" required placeholder="Masukan Mapel">
                </label>
                <input type="submit" value="Tambah" name="tambah" class="tombol">
            </form>
            </div>
        </div>
    </div>
    <script src="../script/dashboard.js"></script>
</body>
</html>
