<?php
    session_start();
    include "../koneksi.php";
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
    $a = $id["id_user"];
    $kelas = mysqli_query($koneksi, "SELECT * FROM kelas where id_user = $a ");
    $cek = mysqli_fetch_array($kelas);
    $namaKelas = $cek['kelas'];
    $id_kelas = $cek['id_kelas'];
    $request1 = mysqli_query($koneksi, "SELECT * from tb_jam_awal");
    $request2 = mysqli_query($koneksi, "SELECT * from tb_jam_akhir");
    $request3 = mysqli_query($koneksi, "SELECT * from mapel");
    $request4 = mysqli_query($koneksi, "SELECT * from kehadiran");
    $date = date("Y-m-d");
    if (isset($_POST['kembali'])) {
        header('Location: dashboardSiswa.php');
    }
    if (isset($_POST['Submit'])) {
        $_SESSION['namaKelas'] = $_POST['kelas'];
        $nkelas = $_POST['kelas'];
        $tanggal= $_POST['tanggal'];
        $awal= $_POST['awal'];
        $akhir = $_POST['akhir'];
        $namaGuru= $_POST['id_guru'];
        $mapel= $_POST['mapel'];
        $materi= $_POST['materi'];
        $keterangan= $_POST['kehadiran'];

        $query = mysqli_query($koneksi, "INSERT INTO tb_riwayat(id_riwayat, id_kelas, id_guru, id_mapel, tanggal, id_awal, id_akhir, materi, id_kehadiran) 
        VALUES ('',$nkelas,$namaGuru,$mapel,'$tanggal',$awal,$akhir,'$materi',$keterangan)");

        header('Location: dashboardSiswa.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/searchGuru.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Quiz Navigation</title>
    <style>
         body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 20px;
            overflow: hidden;

        }
        h2 {
            color: #444;
            text-align: left;
            font-weight: 800;
        }
        p{
            margin-bottom: 5px;
        }
        .section {
            display: block;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: 20px auto;
        }
        button {
            background-color: #007BFF;
            width: 20%;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .tombol{
            width: 20%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .tombol:hover{
            background-color: #2e6430;
        }
        button:hover {
            background-color: #0056b3;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 5px;
        }

    </style>
</head>
<body>
<div class="container mt-4">
<form action="" method="POST">
    <div class="mb-3 w-100">
        <div id="section1" class="section">
            <h2>Agenda Kelas</h2>
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <p>Kelas:</p>
                    <input type="text" readonly value="<?php echo $namaKelas ?>" class="form-control">
                    <input type="hidden" name="kelas" value="<?php echo $id_kelas; ?>">
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <p>Pilih Tanggal:</p>
                    <input type="date" name="tanggal" id="" max="<?php echo $date ; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <p>Jam Masuk :</p>
                    <select name="awal" id="jam_awal" onchange="updateJamAkhir()" class="form-select">
                        <option value="" data-jam="<?php echo 0 ;?>"></option>
                        <?php
                            while ($cek = $request1->fetch_assoc()) {
                                $jam_awal = $cek['id_awal'];
                        ?>
                                <option value="<?php echo $cek['id_awal'] ; ?>" data-jam="<?php echo $jam_awal ; ?>"> <?php echo $cek['ket_awal'] ; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <p>Jam Keluar :</p>
                    <select name="akhir" id="jam_akhir" onchange="updateJamAwal()" class="form-select">
                        <option value=""></option>
                        <?php
                            while ($cek = $request2->fetch_assoc()) {
                                $jam_akhir = $cek['id_akhir'];
                        ?>
                                <option value="<?php echo $cek['id_akhir'] ; ?>" data-jam="<?php echo $jam_akhir; ?>"> <?php echo $cek['ket_akhir'] ; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <p>Nama Guru:</p>
                    <div class="form-group">
                        <div class="dropdown">
                            <input type="text" name="nama_guru" id="nama_guru" onclick="myFunction()" class="form-control" placeholder="--Please Choose--" readonly style="width:100%" />
                            <input type="hidden" name="id_guru" id="id_guru" class="form-control" />
                            <input type="hidden" name="nama_guru" id="nama_guru" class="form-control" />
                            <div id="myDropdown" class="dropdown-content">
                                <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
                                <a onclick="empty()">--Please Choose--</a>
                                <?php
                                    $query = "SELECT * FROM guru";
                                    $resultadu =mysqli_query($koneksi, $query); 
                                    while($data = mysqli_fetch_array($resultadu)){
                                ?>
                                <a onclick="autofill_choose('<?php echo $data['id_guru']; ?>','<?php echo $data['nama_guru']; ?>')">
                                    <?php echo $data['nama_guru']; ?></a>
                                <?php 
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <p>Mapel:</p>
                    <select name="mapel" id="" class="form-select">
                            <option value=""></option>
                            <?php
                            while ($cek = $request3->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $cek['id_mapel'] ; ?>"> <?php echo $cek['mapel'] ; ?></option>
                            <?php
                            }
                            ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <p>Materi :</p>
                    <textarea id="input4" name="materi" class="form-control" placeholder="Masukkan teks"></textarea>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <p>Kehadiran Guru :</p>
                    <select name="kehadiran" id="" class="form-select">
                        <option value=""></option>
                        <?php
                        while ($cek = $request4->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $cek['id_kehadiran'] ; ?>"> <?php echo $cek['kode_kehadiran']."/". $cek['ket_kehadiran'] ; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" name="kembali">Kembali</button>
            <button type="submit" name="Submit" class="tombol">Kirim</button>
        </div>
    </div>
</form>
</div>
<script src="../script/jam.js"></script>
<script src="../script/searchGuru.js"></script>

</body>
</html>
