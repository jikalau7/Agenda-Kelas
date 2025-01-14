<?php
    function dashboard(){
        return '
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="logo">Logo</div>
            <ul class="nav-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="dashboardGuru.php">Data Guru</a></li>
                <li><a href="tambahGuru.php">Tambah Guru</a></li>
                <li><a href="dataMapel.php">Data Mapel</a></li>
                <li><a href="tambahMapel.php">Tambah Mapel</a></li>
                <li><a href="#">Profile</a></li>
            </ul>    
        </nav>
        ';
    }