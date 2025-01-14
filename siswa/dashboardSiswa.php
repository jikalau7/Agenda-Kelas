<?php
    include "../koneksi.php";   
    session_start(); 
    $username = $_SESSION['username'];
    $level = $_SESSION['level'];
    if($level != 'siswa'){
        header("Location: ../login.php");;
    }
    if(empty($username)){
        header("Location: ../login.php");;
    }
    $user = mysqli_query($koneksi, "SELECT * FROM user where username = '$username'");
    $id = mysqli_fetch_array($user);
    $idUser = $id['id_user'];
    $kelas =  mysqli_query($koneksi, "SELECT * FROM kelas where id_user = $idUser");
    $cek = mysqli_fetch_array($kelas);
    $idKelas = $cek['id_kelas'];
    $table = mysqli_query($koneksi, "SELECT tb_riwayat.id_riwayat, tb_riwayat.id_kelas, kelas.kelas, tb_riwayat.tanggal, tb_jam_awal.ket_awal, tb_jam_akhir.ket_akhir, guru.nama_guru, mapel.mapel, tb_riwayat.materi, kehadiran.ket_kehadiran
        from tb_riwayat
        inner join kelas on tb_riwayat.id_kelas = kelas.id_kelas
        join tb_jam_awal on tb_riwayat.id_awal = tb_jam_awal.id_awal
        join tb_jam_akhir on tb_riwayat.id_akhir = tb_jam_akhir.id_akhir
        join guru on tb_riwayat.id_guru = guru.id_guru
        join kehadiran on tb_riwayat.id_kehadiran = kehadiran.id_kehadiran
        join mapel on tb_riwayat.id_mapel = mapel.id_mapel
        where tb_riwayat.id_kelas = $idKelas");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/dashboard.css">
    <link rel="stylesheet" href="../style/table.css">
    <title>Dashboard</title>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="logo">Logo</div>
            <ul class="nav-links">
                <li><a href="dashboardSiswa.php">Dashboard</a></li>
                <li><a href="main_page.php">Pengisian Agenda</a></li>
                <li><a href="#">Profile</a></li>
            </ul>
        </nav>

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
                <h3>Riwayat Kehadiran Kelas</h3>
                <div class="table-container">
                <table class="responsive-table">
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
                </div>
            </div>
        </div>
    </div>

    <script src="../script/dashboard.js"></script>
    <script>
        function submitForm() {
            // Kirim form otomatis saat memilih nilai
            document.getElementById('myForm').submit();
        }
    </script>
</body>
</html>
