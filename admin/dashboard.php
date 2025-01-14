<?php
    include "../koneksi.php";    
    include "../function.php";
    session_start(); 
    $username = $_SESSION['username'];
    $level = $_SESSION['level'];
    if($level != 'admin'){
        header("Location: ../login.php");;
    }
    $query = mysqli_query($koneksi, "SELECT * from kelas");
    if(empty($username)){
        header("Location: ../login.php");;
    }

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($id) && $id != "") {
        $table = mysqli_query($koneksi, "SELECT tb_riwayat.id_riwayat, tb_riwayat.id_kelas, kelas.kelas, tb_riwayat.tanggal, tb_jam_awal.ket_awal, tb_jam_akhir.ket_akhir, guru.nama_guru, mapel.mapel, tb_riwayat.materi, kehadiran.ket_kehadiran
        from tb_riwayat
        inner join kelas on tb_riwayat.id_kelas = kelas.id_kelas
        join tb_jam_awal on tb_riwayat.id_awal = tb_jam_awal.id_awal
        join tb_jam_akhir on tb_riwayat.id_akhir = tb_jam_akhir.id_akhir
        join guru on tb_riwayat.id_guru = guru.id_guru
        join kehadiran on tb_riwayat.id_kehadiran = kehadiran.id_kehadiran
        join mapel on tb_riwayat.id_mapel = mapel.id_mapel
        where tb_riwayat.id_kelas = $id");
    }
}
$k ="";
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
                <!-- Form untuk memilih tabel -->
                <form id="myForm" action="" method="GET">
                    <div class="select-container">
                    <select id="tableSelector" name="id" onchange="submitForm()" class="select-box">
                        <option value="">-- Pilih Tabel --</option>
                        <?php
                            while ($kelas = $query->fetch_assoc()) {
                                $valid = $kelas['id_kelas'];
                                if ($kelas['kelas'] == 'admin') {
                                    break;
                                }
                        ?>
                        <option value="<?php echo $kelas['id_kelas'] ; ?>" <?php echo (isset($id) && $id == "$valid") ? 'selected' : ''; ?>><?php echo $kelas['kelas'] ; ?></option>
                        <?php
                        
                            }
                        ?>
                        </select> 
                    </div>
                </form> <br>

                <?php
                    if (isset($id) && $id != "") {
                ?>
                <div class="table-container">
                <table class="responsive-table" id="dataTable">
                    <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Jam Awal</th>
                        <th>Jam Akhir</th>
                        <th>Guru</th>
                        <th>Mapel</th>
                        <th>Materi</th>
                        <th>Kehadiran</th>
                    </tr>
                    </thead>
                    <?php
                        while ($data = $table-> fetch_assoc()) {
                            $k = $data['kelas'];
                    ?>
                    <tr>
                        <td style="font-weight: bold;"><?php echo $data['kelas'] ; ?></td>
                        <td><?php echo $data['tanggal'] ; ?></td>
                        <td><?php echo $data['ket_awal'] ; ?></td>
                        <td><?php echo $data['ket_akhir'] ; ?></td>
                        <td><?php echo $data['nama_guru'] ; ?></td>
                        <td><?php echo $data['mapel'] ; ?></td>
                        <td><?php echo $data['materi'] ; ?></td>
                        <td><?php echo $data['ket_kehadiran'] ; ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>
                <button class="export-btn" onclick="exportToExcel()">Ekspor ke Excel</button>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
    

    <script src="../script/dashboard.js"></script>
    <script>
        function submitForm() {
            // Kirim form otomatis saat memilih nilai
            document.getElementById('myForm').submit();
        }
        function exportToExcel() {
            var table = document.getElementById("dataTable");
            var wb = XLSX.utils.table_to_book(table, {sheet: "<?php echo $k; ?>"});
            XLSX.writeFile(wb, "<?php echo $k; ?>_data_kelas.xlsx");
        }
    </script>
</body>
</html>
