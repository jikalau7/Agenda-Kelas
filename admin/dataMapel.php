<?php
    include "../function.php";
    include "../koneksi.php";    
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
                <div class="header-right">
                    <a href="../logout.php">
                        <button class="logout-btn">Logout</button>
                    </a>
                    <button class="toggle-sidebar-btn" id="toggleSidebarBtn">☰</button>
                </div>
            </header>
            <div class="content">
                <h2>Selamat datang, <?php echo $username ?></h2>
                <h3>Daftar Mapel</h3>
                <div class="search-container">
                    <input 
                        type="text" 
                        id="searchInput" 
                        class="search-box" 
                        placeholder="Cari nama mapel..." 
                        onkeyup="searchTable()"
                    >
                <!-- Form untuk memilih tabel -->
                <div class="table-container">
                <table class="responsive-table" id="dataTable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Mapel</th>
                        <th>Fitur</th>
                    </tr>
                    </thead>
                    <?php
                        $i = 1;
                        while ($data = $table-> fetch_assoc()) {
                    ?>
                    <tr>
                        <td style="font-weight: bold;"><?php echo $i++ ; ?></td>
                        <td><?php echo $data['mapel'] ; ?></td>
                        <td>
                            <a href="hapusMapel.php?id=<?= $data['id_mapel'] ?>" onclick="showLink()">Hapus</a> /
                            <a href="editMapel.php?id=<?= $data['id_mapel'] ?>">Edit</a>
                        </td>
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
        
        function searchTable() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const table = document.getElementById('dataTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) { // Mulai dari 1 karena baris 0 adalah header
                const cells = rows[i].getElementsByTagName('td');
                let match = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].innerText.toLowerCase().includes(input)) {
                        match = true;
                        break;
                    }
                }

                rows[i].style.display = match ? '' : 'none';
            }
        }
        function showLink(event) {
            const userConfirmed = confirm("Apakah Anda yakin ingin melanjutkan?");
            if (!userConfirmed) {
                event.preventDefault(); // Batalkan tindakan jika memilih "Tidak"
            }
        }
    </script>
</body>
</html>
