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
    $query = mysqli_query($koneksi, "SELECT * from kelas");

        $table = mysqli_query($koneksi, "SELECT * from guru");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/dashboard.css">
    <link rel="stylesheet" href="../style/table.css">
    <link rel="stylesheet" href="../style/select.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <title>Dashboard</title>
    <style>
        th{
            background-color: #366ed8;
        }
        /* Gaya untuk kotak pencarian */
        .search-container {
            margin-bottom: 20px;
            text-align: left;
        }

        .search-box {
            width: 100%;
            max-width: 300px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php
        echo dashboard();
    ?>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <div class="header-left">
                </div>
                <div class="header-right">
                    <a href="../logout.php">
                        <button class="logout-btn">Logout</button>
                    </a>
                    <button class="toggle-sidebar-btn" id="toggleSidebarBtn">☰</button>
                </div>
            </header>
            <div class="content">
                <h2>Selamat datang, <?php echo $username ?></h2>
                <h3>Pilih Kelas</h3>
                <!-- Pencarian -->
                <div class="search-container">
                    <input 
                        type="text" 
                        id="searchInput" 
                        class="search-box" 
                        placeholder="Cari nama guru..." 
                        onkeyup="searchTable()"
                    >
                </div>
                <!-- Tabel Data -->
                <div class="table-container">
                    <table class="responsive-table" id="dataTable">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Guru</th>
                            <th>Keterangan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        while ($data = $table->fetch_assoc()) {
                        ?>
                        <tr>
                            <td style="font-weight: bold;"><?php echo $i; ?></td>
                            <td><?php echo $data['nama_guru']; ?></td>
                            <td>
                                <a href="hapusGuru.php?id=<?= $data['id_guru'] ?>" onclick="showLink()">hapus</a> /
                                <a href="editGuru.php?id=<?= $data['id_guru'] ?>">ganti</a>
                            </td>
                        </tr>
                        <?php
                            $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script src="../script/dashboard.js"></script>
<script src="../script/search.js"></script>
<script>
        function showLink(event) {
            const userConfirmed = confirm("Apakah Anda yakin ingin melanjutkan?");
            if (!userConfirmed) {
                event.preventDefault(); // Batalkan tindakan jika memilih "Tidak"
            }
        }
</script>
</body>
</html>